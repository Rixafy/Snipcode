<?php 

declare(strict_types=1);

namespace App\Module\Front\Snippet;

use App\Model\Snippet\Snippet;
use App\Model\Snippet\Exception\SnippetNotFoundException;
use App\Model\Snippet\SnippetFacade;
use App\Module\Front\BaseFrontPresenter;
use Nette\Application\BadRequestException;

final class SnippetPresenter extends BaseFrontPresenter
{
    private Snippet $snippet;

    public function __construct(
        private SnippetFacade $snippetFacade
    ) {
        parent::__construct();
    }

    /**
     * @throws BadRequestException
     */
    public function actionDefault(string $slug): void
    {
        parent::startup();

        try {
            $this->snippet = $this->snippetFacade->getBySlug($slug);

        } catch (SnippetNotFoundException) {
            throw new BadRequestException();
        }
    }

    public function renderDefault(string $slug): void
    {
        $this->template->snippet = $this->snippet;
    }
}
