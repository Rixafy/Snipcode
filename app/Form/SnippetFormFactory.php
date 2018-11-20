<?php

namespace App\Form;

use App\Facade\ProfileFacade;
use App\Facade\SnippetFacade;
use App\Repository\SyntaxRepository;
use DateTime;
use Nette\Application\UI\Form;

class SnippetFormFactory
{
    /** @var SnippetFacade @inject */
    public $snippetFacade;

    /** @var SyntaxRepository @inject */
    public $syntaxRepository;

    public function __construct(SnippetFacade $snippetFacade, SyntaxRepository $syntaxRepository)
    {
        $this->snippetFacade = $snippetFacade;
        $this->syntaxRepository = $syntaxRepository;
    }

    public function create()
    {
        $form = new Form;

        $form->addTextArea('payload', 'Snippet');

        $form->addSelect('syntax', 'Select syntax', $this->syntaxRepository->getAssociatedArray('name'));

        $form->addSelect('expire_in', 'Select syntax', [
            1 => 'One Day',
            7 => 'One Week',
            30 => 'One Month',
            365 => 'One Year'
        ]);

        $form->addSubmit('send', 'Send');

        $form->onSuccess[] = [$this, 'processForm'];

        return $form;
    }

    public function processForm(Form $form, array $values)
    {
        $expireAt = new DateTime('+' . $values['expire_in'] . ' day');

        $snippet = $this->snippetFacade->createSnippet($values['payload'], $values['syntax'], $expireAt);

        $this->snippetFacade->flushSnippets();

        bdump($expireAt->format('Y-m-d'));
    }
}