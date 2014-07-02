<?php namespace NpmWeb\RackspaceCloud\Commands;

// ./app.sh sup -e -c 100 -o | tr '[:upper:]' '[:lower:]' | sort | uniq | wc -l
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface as InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface as OutputInterface;

use OpenCloud\Rackspace;
use OpenCloud\Compute\Constants\ImageState;


class AbstractRackspaceCommand extends Command {

	protected function connectToRackspace() {
		$this->rackspaceClient = new Rackspace(Rackspace::US_IDENTITY_ENDPOINT, array(
		    'username' => getenv('RSCLOUD_USERNAME'),
		    'apiKey'   => getenv('RSCLOUD_API_KEY')
		));
	}

	// defaults to the web1.northpointonline.tv server
	// returns an iterator
	protected function listImages($server) {
		$compute = $this->rackspaceClient->computeService('cloudServersOpenStack', 'DFW');

		$images = $compute->imageList(true, [
			'server' => $server,
			'type' => 'SNAPSHOT',
			'status' => ImageState::ACTIVE
		]);

		return $images;
	}

}