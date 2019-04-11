<?php

declare(strict_types=1);

namespace Snipcode\Module\Console\Syntax;

use Snipcode\Repository\SyntaxRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

final class AddSyntaxCommand extends Command
{
	/** @var SyntaxRepository @inject */
	public $syntaxRepository;

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
			$syntax = $this->syntaxRepository->create($name);

			$syntax->setShortName($shortName);

			$this->syntaxRepository->save($syntax, true);

			$output->writeln('<fg=green;options=bold>Syntax ' . $syntax->getName() . ' created!</>');

		} else {
			$output->writeln('<fg=red;options=bold>Please specify name and short name of Syntax.</>');
		}
	}
}
