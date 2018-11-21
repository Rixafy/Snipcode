<?php

namespace App\Presenters;

use App\Component\SnippetFormComponent;
use App\Entity\Session;
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

    public function actionDefault()
    {
        $this->session = $this->profileFacade->getCurrentSession();
    }

    public function renderDefault()
    {
        $this->template->session = $this->session;
    }

    protected function createComponentSnippetForm()
    {
        return $this->snippetFormComponent->addOnSuccess(function () {
            bdump('redirecting');
            $this->redirect('Snippet:view', ['slug' => $this->snippetFacade->getTemporarySnippet()->getSlug()]);
        });
    }
}
