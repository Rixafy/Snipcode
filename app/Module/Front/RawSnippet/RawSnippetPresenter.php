<?php

declare(strict_types=1);

namespace App\Module\Front\RawSnippet;

use App\Model\Snippet\Exception\SnippetNotFoundException;
use App\Model\Snippet\SnippetFacade;
use App\Module\Front\BaseFrontPresenter;
use Nette\Application\AbortException;
use Nette\Application\BadRequestException;
use Nette\Application\Responses\TextResponse;

final class RawSnippetPresenter extends BaseFrontPresenter
{
    public function __construct(
        private SnippetFacade $snippetFacade
    ) {
        parent::__construct();
    }

    /**
     * @throws BadRequestException
     * @throws AbortException
     */
    public function actionDefault(string $slug): void
    {
        try {
            $payload = $this->snippetFacade->getBySlug($slug)->getPayload();
            $this->getHttpResponse()->setContentType('text/plain', 'UTF-8');
            $this->sendResponse(new TextResponse($payload));

        } catch (SnippetNotFoundException) {
            throw new BadRequestException();
        }
    }
}
