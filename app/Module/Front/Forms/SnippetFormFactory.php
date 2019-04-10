<?php declare(strict_types=1);

namespace App\Form;

use App\Component\BaseComponent;
use App\Facade\ProfileFacade;
use App\Model\Snippet\SnippetData;
use App\Model\Snippet\SnippetFacade;
use App\Repository\SyntaxRepository;
use DateTime;
use Nette\Application\UI\Form;
use Nette\Http\Session;

class SnippetFormFactory
{
    /** @var SnippetFacade @inject */
    public $snippetFacade;

    /** @var ProfileFacade @inject */
    public $profileFacade;

    /** @var SyntaxRepository @inject */
    public $syntaxRepository;

    /** @var BaseComponent */
    protected $baseComponent;

    /** @var Session */
    protected $netteSession;

    public function __construct(SnippetFacade $snippetFacade, ProfileFacade $profileFacade, SyntaxRepository $syntaxRepository, Session $netteSession)
    {
        $this->snippetFacade = $snippetFacade;
        $this->profileFacade = $profileFacade;
        $this->syntaxRepository = $syntaxRepository;
        $this->netteSession = $netteSession;
    }

    public function create(BaseComponent $baseComponent, ?string $forkText)
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

        $form->addSubmit('send', 'Save Snippet')
            ->setAttribute('class', 'ajax button bg-blue');

        $form->setDefaults([
            'expire_in' => 7,
            'payload' => $forkText ?? ''
        ]);

        $form->onSuccess[] = [$this, 'processForm'];

        return $form;
    }

    public function processForm(Form $form, array $values)
    {
        $snippetData = new SnippetData;
        $snippetData->title = $values['title'] === '' ? null : $values['title'];
        $snippetData->payload = $values['payload'];
        $snippetData->expireAt = new DateTime('+' . $values['expire_in'] . ' day');
        $snippetData->authorIpAddress = $this->profileFacade->getCurrentIpAddress();
        $snippetData->authorSession = $this->profileFacade->getCurrentSession();

        $snippet = $this->snippetFacade->create($snippetData);

        $this->netteSession->getSection('snippet')->{'pending'} = $snippet->getSlug();

        $this->baseComponent->onSuccess();
    }
}