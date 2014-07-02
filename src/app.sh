#!/usr/bin/php
<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use NpmWeb\RackspaceCloud\Commands;

date_default_timezone_set('America/Chicago');

echo "RackspaceCloud Management App: -- " . date('Y.m.d H:i:s') . " --\n";
Dotenv::load(dirname(__FILE__) . '/../config/','rackspace.env');

$app = new Application('NPMCloud','1.0');

$app->addCommands([
	new Commands\TestCommand(),
	new Commands\ListImagesCommand(),
	new Commands\UpdateScaleGroupImageCommand()
]);
$app->run();