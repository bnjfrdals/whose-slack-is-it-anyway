<?php

namespace WSIIA\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Yaml\Yaml;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Exception;

class PostLineCommand extends Command
{
    const STRATEGY_RANDOM = 'random';
    const STRATEGY_MODULO = 'modulo';

    /** @var string */
    private $slackURL;

    /**
     * PostLineCommand constructor.
     *
     * @param string $slackURL
     */
    public function __construct(string $slackURL)
    {
        parent::__construct();

        $this->slackURL = $slackURL;
    }


    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('post-line')
            ->setDescription('Posts a Whose Line is it Anyway line to a Slack workflow.')
            ->addArgument('line', InputArgument::OPTIONAL, 'The line to post. If empty, the command will take one line from the collection of lines in lines.yaml depending on the requested strategy.')
            ->addOption('strategy', null, InputOption::VALUE_REQUIRED, 'The strategy to select the line (random, modulo).')
            ->addOption('weekdays', null, InputOption::VALUE_NONE, 'Post lines on week days only.')
        ;
    }

    /**
     * {@inheritdoc}
     *
     * @throws Exception
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        if ($input->getOption('weekdays') && in_array(date('w'), [0, 6])) {
            $output->writeln('Skipping line during week-ends');

            return 1;
        }

        if (!is_null($input->getOption('strategy')) && !is_null($input->getArgument('line'))) {
            throw new Exception("Strategy option cannot be used with a custom line");
        }

        if (!is_null($input->getOption('strategy'))) {
            $line = $this->getLine($input->getOption('strategy'));
        } elseif (!is_null($input->getArgument('line'))) {
            $line = $input->getArgument('line');
        } else {
            $line = $this->getLine(self::STRATEGY_RANDOM);
        }

        $client = HttpClient::create();
        $client->request('POST', $this->slackURL, [
            'headers' => [
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'line' => $line,
            ],
        ]);

        return 1;
    }

    /**
     * @param string $strategy
     *
     * @return string
     * @throws Exception
     */
    private function getLine(string $strategy): string
    {
        $path = __DIR__ . '/../../lines.yaml';
        $lines = Yaml::parseFile($path)['lines'];

        switch ($strategy) {
            case self::STRATEGY_RANDOM:
                return $lines[rand(0, count($lines) - 1)];
            case self::STRATEGY_MODULO:
                $day = date('z') + 1;

                return $lines[$day % count($lines)];
            default:
                throw new Exception("Unknown strategy $strategy");
        }
    }
}
