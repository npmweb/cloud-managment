#!/Applications/MAMP/bin/php/php5.5.3/bin/php
<?php
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\Console\Application;
use NpmWeb\RackspaceCloud\Commands;

echo "RackspaceCloud App:\n";
Dotenv::load(dirname(__FILE__) . '/../config/','rackspace.env');

$app = new Application('NPMCloud','1.0');

$app->addCommands([
	new Commands\TestCommand(),
	new Commands\ListImagesCommand(),
	new Commands\UpdateScaleGroupImageCommand()
]);
$app->run();