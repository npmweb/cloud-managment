<?php namespace NpmWeb\RackspaceCloud\Commands;

// run from src folder: ./app.sh test
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface as InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface as OutputInterface;

class TestCommand extends Command {

	public function configure() {
		echo __METHOD__."\n";
		$this->setName('test')
		     ->setDescription('Say Hi')
		     ->setHelp('Tests the app to see if this command stuff works.');

		return;

	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$this->output = $output;

		$this->output->writeln('Hi There');

		return;
	}
}