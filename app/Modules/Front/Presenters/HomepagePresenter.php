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

    /** @var Snippet */
    private $forkSnippet;

    public function startup()
    {
        parent::startup();

        $sessionSnippet = $this->getSession()->getSection('snippet');

        if ($sessionSnippet->{'pending'} !== null) {
            unset($sessionSnippet->{'pending'});
        }

        $this->session = $this->profileFacade->getCurrentSession();
    }

    public function actionDefault(?string $forkId = null)
    {
        if ($forkId != null) {
            $this->forkSnippet = $this->snippetFacade->getById($forkId);
        }
    }

    public function renderDefault()
    {
        $this->template->session = $this->session;
        $this->template->forkSnippet = $this->forkSnippet;
    }

    public function getForkText()
    {
        if ($this->forkSnippet !== null) {
            return $this->forkSnippet->getPayload();
        }

        return null;
    }

    protected function createComponentSnippetForm()
    {
        return $this->snippetFormComponent->addOnSuccess(function () {
            $this->redrawControl('homepage');
        });
    }
}
