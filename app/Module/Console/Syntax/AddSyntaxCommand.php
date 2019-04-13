<?php

declare(strict_types=1);

namespace Snipcode\Module\Console\Syntax;

use Snipcode\Model\Syntax\SyntaxData;
use Snipcode\Model\Syntax\SyntaxFacade;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

final class AddSyntaxCommand extends Command
{
	/** @var SyntaxFacade @inject */
	public $syntaxFacade;

	protected function configure(): void
	{
		$this->setName('app:syntax:add');
	}

	protected function execute(InputInterface $input, OutputInterface $output): void
	{
		$helper = $this->getHelper('question');

		$name = $helper->ask($input, $output, new Question('Syntax name: '));
		$shortName = $helper->ask($input, $output, new Question('Syntax short name: '));

		if ($name !== null && $shortName !== null) {
			$syntaxData = new SyntaxData();
			$syntaxData->name = $name;
			$syntaxData->shortName = $shortName;

			$syntax = $this->syntaxFacade->create($syntaxData);

			$output->writeln('<fg=green;options=bold>Syntax ' . $syntax->getName() . ' created!</>');

		} else {
			$output->writeln('<fg=red;options=bold>Please specify name and short name of Syntax.</>');
		}
	}
}
