<?php 

declare(strict_types=1);

namespace App\Module\Front\Homepage\Form;

use App\Model\Snippet\Snippet;
use App\Model\Syntax\SyntaxFacade;
use Nette\Application\UI\Form;

class SnippetFormFactory
{
    public function __construct(
        private SyntaxFacade $syntaxFacade
    ) {}

    public function create(?Snippet $forkedFrom): Form
    {
        $form = new Form();

        $form->addText('title', 'Title')
            ->setHtmlAttribute('placeholder', 'Title (optional)')
            ->setHtmlAttribute('autocomplete', 'off')
            ->setNullable();

        $form->addTextArea('payload', 'Snippet')
            ->setHtmlAttribute('autofocus', true)
            ->setRequired('Please paste some snippet');

        $form->addSelect('syntax', 'Select syntax', $this->syntaxFacade->mapForFormData());

        $form->addSelect('expireInDays', 'Expire in', [
            1 => 'Expire in One Day',
            7 => 'Expire in One Week',
            30 => 'Expire in One Month',
            365 => 'Expire in One Year'
        ])->setDefaultValue(7);

        $form->addSubmit('send', 'Save Snippet')
            ->setHtmlAttribute('class', 'button bg-blue');

        if ($forkedFrom !== null) {
            $form->setDefaults([
                'payload' => $forkedFrom->getPayload()
            ]);
        }
        
        return $form;
    }
}
