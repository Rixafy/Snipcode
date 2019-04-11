<?php

declare(strict_types=1);

namespace Snipcode\Module\Console\Variable;

use Snipcode\Model\Variable\VariableData;
use Snipcode\Model\Variable\VariableFacade;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

final class AddVariableCommand extends Command
{
	/** @var VariableFacade */
	public $variableFacade;

	public function __construct(VariableFacade $variableFacade)
	{
		parent::__construct();
		$this->variableFacade = $variableFacade;
	}

	protected function configure(): void
	{
		$this->setName('app:variable:add');
		$this->setDescription('Add new system variable');
	}

	protected function execute(InputInterface $input, OutputInterface $output): void
	{
		$helper = $this->getHelper('question');

		$name = $helper->ask($input, $output, new Question('Variable name: '));
		$value = $helper->ask($input, $output, new Question('Variable value: '));

		if ($name !== null && $value !== null) {
			$variableData = new VariableData;

			$variableData->name = $name;
			$variableData->value = $value;

			$variable = $this->variableFacade->create($variableData);

			$output->writeln('<fg=green;options=bold>Variable ' . $variable->getName() . ' [' . $variable->getValue() . '] created!</>');

		} else {
			$output->writeln('<fg=red;options=bold>Please specify name and value of the variable!</>');
		}
	}
}
