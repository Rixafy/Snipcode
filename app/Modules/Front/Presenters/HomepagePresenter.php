<?php

namespace App\Presenters;

use App\Component\SnippetFormComponent;
use App\Entity\Session;
use App\Entity\Snippet;
use App\Facade\ProfileFacade;
use App\Facade\SnippetFacade;

final class HomepagePresenter extends BasePresenter
{
    /** @var ProfileFacade @inject */
    public $profileFacade;

    /** @var SnippetFacade @inject */
    public $snippetFacade;

    /** @var SnippetFormComponent @inject */
    public $snippetFormComponent;

    /** @var Session */
    private $session;

    /** @var Snippet */
    private $snippet;

    public function actionDefault()
    {
        $this->session = $this->profileFacade->getCurrentSession();

        if (!empty($this->getHttpRequest()->getPost())) {
            $this->snippet = $this->snippetFacade->getLastSnippet($this->session);
        }
    }

    public function renderDefault()
    {
        $this->template->session = $this->session;

        if ($this->snippet !== null) {
            $this->template->snippet = $this->snippet;
        }
    }

    protected function createComponentSnippetForm()
    {
        return $this->snippetFormComponent->addOnSuccess(function () {
            $this->redrawControl('homepage');
        });
    }
}
