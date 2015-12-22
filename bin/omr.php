<?php

require __DIR__.'/../vendor/autoload.php';

use JansenFelipe\OMR\Commands\ScanCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$application->add(new ScanCommand());
$application->run();