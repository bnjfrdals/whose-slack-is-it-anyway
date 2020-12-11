<?php

// Lines
$lines = [
    "Bad times for the microphone to cut out",
    "Songs That Did Not Make It To No. 1",
    "Bad Times to be drunk",
    "Things to say that will not help you pick up girls/boys",
    "Musicals that are destined to bomb on Broadway",
    "Things you can say about a video game, but not your girlfriend",
    "Things You Don’t Want To Hear A Pilot Say",
    "Bad things to hear in a restaurant.",
    "Bad anecdotes to give on a talk show",
    "Doctors you wouldn’t want to operate on you",
    "Signs you are not going to pass your job interview",
    "Unsuccessful Themed Restaurants",
    "Odd things for a talking doll to say",
    "Sales pitches gone wrong",
    "Things you don’t expect to hear from a seashell when you put it to your ear",
    "The world’s worst neighbour",
    "Jack Bauer’s day job",
    "Bad things to say to your parents-in-law",
    "Rejected TV Spin-offs",
    "Public Service Announcements you’ll never hear",
    "Outtakes from “Antiques Roadshow”",
    "Bad high school cheerleaders’ cheers",
    "Rejected scenes from “Scenes from a Hat”",
    "Bad times to break out in song",
    "Rejected Wikileaks",
    "Dangerous Things To Do Naked",
    "If the United Nations were Las Vegas",
    "Deleted scenes from “Toy Story”",
    "Resumes That Did Not Impress",
    "Things not to say in a rough neighbourhood",
    "Pickup Lines of the Blind",
    "Why the dinosaurs REALLY went extinct",
    "World’s Worst Secret Societies",
    "Bad things to say (going through a metal detector) at an airport",
    "Bad times to fall asleep.",
    "If Batman were Fratman",
    "Bad things to do in Iraq",
    "Acceptance speeches you’d never hear",
    "If The White House Was Run By College Kids",
    "Bad things to do while driving ",
];

$index = date('d');

$options = array(
    'http' => array(
        'method'  => 'POST',
        'content' => json_encode([
            'line' => $lines[$index],
        ]),
        'header'=>  "Content-Type: application/json\r\n" .
            "Accept: application/json\r\n"
    )
);

$context  = stream_context_create( $options );
$result = file_get_contents('https://hooks.slack.com/workflows/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', false, $context );
$response = json_decode( $result );
