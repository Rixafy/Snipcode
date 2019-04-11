<?php declare(strict_types=1);

namespace Snipcode\Presenters;

use Snipcode\Model\Snippet\Snippet;
use Snipcode\Model\Snippet\SnippetFacade;
use Snipcode\Model\Snippet\Exception\SnippetNotFoundException;

final class SnippetPresenter extends BasePresenter
{
    /** @var SnippetFacade @inject */
    public $snippetFacade;

    /** @var Snippet */
    protected $snippet;

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
