<?php 

declare(strict_types=1);

namespace App\Module\Front\Homepage;

use App\Model\Snippet\Snippet;
use App\Model\Snippet\SnippetDataFactory;
use App\Model\Snippet\SnippetFacade;
use App\Model\Snippet\Exception\SnippetNotFoundException;
use App\Module\Front\BaseFrontPresenter;
use App\Module\Front\Homepage\Form\SnippetFormFactory;
use Nette\Application\BadRequestException;
use Nette\Application\UI\Form;
use Nette\ComponentModel\IComponent;
use Ramsey\Uuid\Uuid;

/**
 * @property HomepageTemplate $template
 */
final class HomepagePresenter extends BaseFrontPresenter
{
    private ?Snippet $forkedFrom = null;

    /** @var Snippet[] */
    private array $yourSnippets;

    public function __construct(
        private SnippetFacade $snippetFacade,
        private SnippetDataFactory $snippetDataFactory,
        private SnippetFormFactory $snippetFormFactory,
    ) {
        parent::__construct();
    }

    /**
     * @throws BadRequestException
     */
    public function actionDefault(?string $forkId = null): void
    {
        if ($forkId !== null) {
            try {
                $this->forkedFrom = $this->snippetFacade->get(Uuid::fromString($forkId));
            } catch (SnippetNotFoundException) {
                throw new BadRequestException();
            }
        }

        $this->yourSnippets = $this->snippetFacade->getAllBySession($this->session->getId());
    }

    public function renderDefault(): void
    {
        $this->template->forkedFrom = $this->forkedFrom;
        $this->template->yourSnippets = $this->yourSnippets;
    }

    protected function createComponentSnippetForm(): IComponent
    {
        $form = $this->snippetFormFactory->create($this->forkedFrom);
        
        $form->onSuccess[] = function (Form $form, array $data): void {
            $slug = $this->snippetFacade->create($this->snippetDataFactory->createFromFormData($data))->getSlug();
            $this->redirect('Snippet:default', [
                'slug' => $slug
            ]);
        };
        
        return $form;
    }
}
