<?php

namespace App\Form;

use App\Entity\Snippet;
use App\Facade\ProfileFacade;
use FreezyBee\DoctrineFormMapper\DoctrineFormMapper;
use Nette\Application\UI\Form;

class SnippetFormFactory
{
    /** @var DoctrineFormMapper @inject */
    public $mapper;

    /** @var ProfileFacade @inject */
    public $profileFacade;

    public function __construct(DoctrineFormMapper $mapper, ProfileFacade $profileFacade)
    {
        $this->mapper = $mapper;
        $this->profileFacade = $profileFacade;
    }

    public function create()
    {
        $form = new Form;

        $entity = new Snippet('', null, null, null);

        $form->addText('payload', 'Snippet');

        $form->addSelect('syntax', 'Select syntax');

        $form->addSubmit('send', 'Send');

        $this->mapper->load($entity, $form);

        $form->onSuccess[] = [$this, 'processForm'];

        return $form;
    }

    public function processForm(Form $form)
    {
        bdump($form->getValues());
    }
}