<?php

namespace App\Presenters;

use App\Component\SnippetFormComponent;
use App\Entity\Session;
use App\Entity\Snippet;
use App\Facade\ConfigFacade;
use App\Facade\ProfileFacade;
use App\Facade\SnippetFacade;

final class HomepagePresenter extends BasePresenter
{
    /** @var ConfigFacade @inject */
    public $configFacade;

    /** @var ProfileFacade @inject */
    public $profileFacade;

    /** @var SnippetFacade @inject */
    public $snippetFacade;

    /** @var SnippetFormComponent @inject */
    public $snippetFormComponent;

    /** @var Session */
    private $session;

    public function actionDefault()
    {
        $sessionSnippet = $this->getSession()->getSection('snippet');

        if ($sessionSnippet->{'pending'} !== null) {
            unset($sessionSnippet->{'pending'});
        }

        $this->session = $this->profileFacade->getCurrentSession();
    }

    public function renderDefault()
    {
        $this->template->session = $this->session;
        $this->template->session = $this->session;
    }

    protected function createComponentSnippetForm()
    {
        return $this->snippetFormComponent->addOnSuccess(function () {
            $this->redrawControl('homepage');
        });
    }
}
