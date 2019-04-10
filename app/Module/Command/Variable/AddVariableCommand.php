<?php

declare(strict_types=1);

namespace App\Module\Command\Variable;

use App\Repository\VariableRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

final class AddVariableCommand extends Command
{
	/** @var VariableRepository @inject */
	public $variableRepository;

	protected function configure(): void
	{
		$this->setName('app:variable:add');
	}

	protected function execute(InputInterface $input, OutputInterface $output): void
	{
		$helper = $this->getHelper('question');

		$name = $helper->ask($input, $output, new Question('Variable name: '));
		$value = $helper->ask($input, $output, new Question('Variable value: '));

		if ($name !== null && $value !== null) {
			$variable = $this->variableRepository->create($name, $value);

			$this->variableRepository->save($variable, true);

			$output->writeln('<fg=green;options=bold>Variable ' . $variable->getName() . ' [' . $variable->getValue() . '] created!</>');
		} else {
			$output->writeln('<fg=red;options=bold>Please specify name and value of the variable!</>');
		}
	}
}
