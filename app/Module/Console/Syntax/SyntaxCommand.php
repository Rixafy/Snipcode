<?php

declare(strict_types=1);

namespace App\Module\Console\Syntax;

use App\Model\Syntax\Exception\SyntaxNotFoundException;
use App\Model\Syntax\SyntaxData;
use App\Model\Syntax\SyntaxFacade;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SyntaxCommand extends Command
{
    protected static $defaultName = 'syntax:update';

    public function __construct(
        private SyntaxFacade $syntaxFacade
    ) {
        parent::__construct();
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $syntaxDataList = [];
        $syntaxDataList[] = new SyntaxData('C');
        $syntaxDataList[] = new SyntaxData('C++');
        $syntaxDataList[] = new SyntaxData('PHP');
        $syntaxDataList[] = new SyntaxData('Java');
        $syntaxDataList[] = new SyntaxData('Kotlin');
        $syntaxDataList[] = new SyntaxData('JavaScript');
        $syntaxDataList[] = new SyntaxData('Bash');
        $syntaxDataList[] = new SyntaxData('Shell');
        $syntaxDataList[] = new SyntaxData('Python');
        $syntaxDataList[] = new SyntaxData('Ruby');
        $syntaxDataList[] = new SyntaxData('Scala');
        $syntaxDataList[] = new SyntaxData('SQL');
        $syntaxDataList[] = new SyntaxData('R');
        $syntaxDataList[] = new SyntaxData('Perl');
        $syntaxDataList[] = new SyntaxData('Swift');
        $syntaxDataList[] = new SyntaxData('Rust');
        $syntaxDataList[] = new SyntaxData('Go');
        $syntaxDataList[] = new SyntaxData('TypeScript');
        
        foreach ($syntaxDataList as $data) {
            try {
                $this->syntaxFacade->getByName($data->name);
            } catch (SyntaxNotFoundException) {
                $this->syntaxFacade->create($data);
            }
        }
        
        return 0;
    }
}
