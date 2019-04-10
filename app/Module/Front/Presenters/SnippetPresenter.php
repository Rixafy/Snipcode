<?php declare(strict_types=1);

namespace App\Presenters;

use App\Model\Snippet\Snippet;
use App\Model\Snippet\SnippetFacade;
use App\Model\Snippet\Exception\SnippetNotFoundException;

final class SnippetPresenter extends BasePresenter
{
    /** @var SnippetFacade @inject */
    public $snippetFacade;

    /** @var Snippet */
    private $snippet;

    public function startup(): void
	{
		parent::startup();

		try {
			$this->snippet = $this->snippetFacade->getBySlug($this->getParameter('slug'), true);

		} catch (SnippetNotFoundException $e) {
			$this->error('Snippet not found');
		}
	}


    public function renderDefault(string $slug): void
    {
        $this->template->snippet = $this->snippet;
    }

    public function actionRaw(string $slug): void
    {
        $this->getHttpResponse()->setContentType('text/plain', 'UTF-8');

        exit($this->snippet->getPayload());
    }
}
