<?php declare(strict_types=1);

namespace Snipcode\Presenters;

use Snipcode\Component\SnippetFormComponent;
use Snipcode\Entity\Session;
use Snipcode\Model\Snippet\Snippet;
use Snipcode\Facade\ConfigFacade;
use Snipcode\Facade\ProfileFacade;
use Snipcode\Model\Snippet\SnippetFacade;
use Snipcode\Model\Snippet\Exception\SnippetNotFoundException;
use Nette\Application;
use Nette\ComponentModel\IComponent;
use Ramsey\Uuid\Uuid;

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
    protected $session;

    /** @var Snippet */
    protected $forkSnippet;

    public function startup(): void
    {
        parent::startup();

        $sessionSnippet = $this->getSession()->getSection('snippet');

        if ($sessionSnippet->{'pending'} !== null) {
            unset($sessionSnippet->{'pending'});
        }

        $this->session = $this->profileFacade->getCurrentSession();
    }

    public function actionDefault(?string $forkId = null): void
    {
        if ($forkId != null) {
            $this->forkSnippet = $this->snippetFacade->get(Uuid::fromString($forkId));
        }
    }

    public function renderDefault(): void
    {
        $this->template->session = $this->session;
        $this->template->forkSnippet = $this->forkSnippet;

        if (isset($this->getSession()->getSection('snippet')->{'pending'})) {
			try {
				$this->template->pendingSnippet = $this->snippetFacade->getBySlug($this->getSession()->getSection('snippet')->{'pending'});

			} catch (SnippetNotFoundException $e) {
			}
        }
	}

    public function getForkText(): ?string
    {
        if ($this->forkSnippet !== null) {
            return $this->forkSnippet->getPayload();
        }

        return null;
    }

    protected function createComponentSnippetForm(): IComponent
    {
        return $this->snippetFormComponent->addOnSuccess(function () {
            $this->redrawControl('homepage');
        });
    }

    protected function shutdown(Application\IResponse $response)
	{

	}
}
