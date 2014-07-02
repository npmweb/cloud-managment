<?php namespace NpmWeb\RackspaceCloud\Commands;

// run from the src folder
// ./app.sh update-scale-group-image --scale-group=scale-group-id --server=server-id
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface as InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface as OutputInterface;

use OpenCloud\Common\Http\Message\Formatter;

class UpdateScaleGroupImageCommand extends AbstractRackspaceCommand {

	public function configure() {

		$definition = [new InputOption('scale-group', 'g', InputOption::VALUE_REQUIRED, 'Scale group ID.'),
                       new InputOption('server', 's', InputOption::VALUE_REQUIRED, 'ID of the server whose image you need to use')];

		$this->setName('update-scale-group-image')
		     ->setDescription('Re-configures the scaling group to use the latest image')
		     ->setDefinition($definition)
		     ->setHelp('./app.sh update-scale-group-image --scale-group=id-1234 --server=id-4321');

		$this->connectToRackspace();

		return;

	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$this->output = $output;

		$serverId = $input->getOption('server');
		$scaleGroupId = $input->getOption('scale-group');

		$this->output->writeln("ServerID[".$serverId."] ScaleGroup[".$scaleGroupId."]");

		$latest = $this->latestImage($serverId);

		if (!$latest) throw new \Exception("Latest image not found");

		$this->output->writeln("The latest image is ".$latest->id." - ".$latest->name);

		$scaleGroup = $this->getScaleGroup($scaleGroupId);
		$launchConfig = $scaleGroup->getLaunchConfiguration();
		$server = $launchConfig->args->server;
		if ( $server->imageRef != $latest->id ) {
			$server->imageRef = $latest->id;
			$this->output->writeln("Updating Launch Config");
			$launchConfig->update();
		} else { 
			$this->output->writeln("Launch Config is already using the latest image: ".$latest->name." from ".$latest->created);
		}

		return;
	}

	private function latestImage($serverId) {
		$images = $this->listImages($serverId);

		// TODO: error if none?
		$latest = false;
		$latestTimestamp = 0;

		while ($image = $images->next()) {
			$ts = strtotime($image->created);
			if ($ts > $latestTimestamp) {
				$latest = $image;
				$latestTimestamp = $ts;
			}
		}

		return $latest;
	}


	// default groupId is the NPO scale group
	private function getScaleGroup($groupId) {
		$scaleService = $this->rackspaceClient->autoscaleService();
		$scaleGroup = $scaleService->group($groupId);

		return $scaleGroup;
	}

}