<?php declare(strict_types=1);

namespace App\Command;

use App\Repository\ConstantRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;

final class AddConstantCommand extends Command
{
    /** @var ConstantRepository @inject */
    public $constantRepository;

    protected function configure(): void
    {
        $this->setName('app:constant:add');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $helper = $this->getHelper('question');

        $name = $helper->ask($input, $output, new Question('Constant name: '));
        $value = $helper->ask($input, $output, new Question('Constant value: '));

        if ($name !== null && $value !== null) {
            $constant = $this->constantRepository->create($name, $value);

            $this->constantRepository->save($constant, true);

            $output->writeln('<fg=green;options=bold>Constant ' . $constant->getName() . ' [' . $constant->getValue() . '] created!</>');
        } else {
            $output->writeln('<fg=red;options=bold>Please specify name and value of the constant!</>');
        }
    }
}
