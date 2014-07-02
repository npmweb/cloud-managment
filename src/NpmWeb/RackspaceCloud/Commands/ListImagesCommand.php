<?php namespace NpmWeb\RackspaceCloud\Commands;

// run from src folder: ./app.sh list-images --server=server-id
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface as InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface as OutputInterface;

use OpenCloud\Rackspace;
use OpenCloud\Compute\Constants\ImageState;

class ListImagesCommand extends AbstractRackspaceCommand {

	public function configure() {

		$definition = [
		    new InputOption('server', 's', InputOption::VALUE_REQUIRED, 'ID of the server whose images you want to list'),
		    new InputOption('data-center', 'c', InputArgument::OPTIONAL, 'The data center where the images live','DFW')
		];

		$this->setName('list-images')
		     ->setDescription('Lists the cloud server images')
		     ->setDefinition($definition)
		     ->setHelp('./app.sh list');

		$this->connectToRackspace();

		return;

	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$this->output = $output;

		$serverId = $input->getOption('server');
		$dataCenter = $input->getOption('data-center');

		$compute = $this->rackspaceClient->computeService('cloudServersOpenStack', $dataCenter);


		$images = $compute->imageList(true, [
			'server' => $serverId,
			'type' => 'SNAPSHOT',
			'status' => ImageState::ACTIVE
		]);
		$i = 0;
		while ($image = $images->next()) {
			$this->output->writeln($i++.": [".$image->id."] ".$image->name." created on ".$image->created." AND status is '".$image->status."'");
		}

		return;
	}
}