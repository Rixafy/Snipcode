<?php

namespace App\Form;

use App\Component\BaseComponent;
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

    /** @var BaseComponent */
    private $baseComponent;

    public function __construct(SnippetFacade $snippetFacade, SyntaxRepository $syntaxRepository)
    {
        $this->snippetFacade = $snippetFacade;
        $this->syntaxRepository = $syntaxRepository;
    }

    public function create(BaseComponent $baseComponent)
    {
        $this->baseComponent = $baseComponent;

        $form = new Form;

        $form->addText('title', 'Title')
            ->setAttribute('placeholder', 'Title (optional)')
            ->setAttribute('autocomplete', 'off');

        $form->addTextArea('payload', 'Snippet')
            ->setAttribute('autofocus', true)
            ->setRequired('Please paste some snippet');

        //$form->addSelect('syntax', 'Select syntax', $this->syntaxRepository->getAssociatedArray('name'));

        $form->addSelect('expire_in', 'Expire in', [
            1 => 'Expire in One Day',
            7 => 'Expire in One Week',
            30 => 'Expire in One Month',
            365 => 'Expire in One Year'
        ]);

        $form->addSubmit('send', 'Send');

        $form->setDefaults([
            'expire_in' => 7
        ]);

        $form->onSuccess[] = [$this, 'processForm'];

        return $form;
    }

    public function processForm(Form $form, array $values)
    {
        $expireAt = new DateTime('+' . $values['expire_in'] . ' day');

        $snippet = $this->snippetFacade->createSnippet($values['title'], $values['payload'], null, $expireAt);

        $this->snippetFacade->flushSnippets();

        $this->snippetFacade->setTemporarySnippet($snippet);

        $this->baseComponent->onSuccess();
    }
}