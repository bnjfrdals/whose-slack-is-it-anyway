<?php

namespace WSIIA\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Component\Yaml\Yaml;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class PostLineCommand extends Command
{
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
            ->addArgument('line', InputArgument::OPTIONAL, 'The line to post. If empty, the command will randomly take one line from the collection of lines in lines.yaml')
        ;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     * @throws TransportExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $line = $input->getArgument('line');
        $line = !is_null($line) ? $line : $this->getLine();

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
     * @return string
     */
    private function getLine(): string
    {
        $path = __DIR__ . '/../../lines.yaml';
        $lines = Yaml::parseFile($path)['lines'];

        return $lines[rand(0, count($lines) - 1)];
    }
}
