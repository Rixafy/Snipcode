<?php

declare(strict_types=1);

namespace App\Module\Front\Error;

use Nette;
use Nette\Application\IPresenter;
use Nette\Application\Response;
use Nette\Application\Responses\CallbackResponse;
use Nette\Application\Responses\ForwardResponse;
use Nette\Http;
use Tracy\ILogger;

final class ErrorPresenter implements IPresenter
{
    use Nette\SmartObject;
    
    public function __construct(
        private ILogger $logger
    ) {}

    public function run(Nette\Application\Request $request): Response
    {
        $exception = $request->getParameter('exception');

        if ($exception instanceof Nette\Application\BadRequestException) {
            [$module, , $sep] = Nette\Application\Helpers::splitName($request->getPresenterName());
            return new ForwardResponse($request->setPresenterName($module . $sep . 'Error4xx'));
        }

        $this->logger->log($exception, ILogger::EXCEPTION);
        return new CallbackResponse(function (Http\IRequest $httpRequest, Http\IResponse $httpResponse): void {
            if (preg_match('#^text/html(?:;|$)#', (string) $httpResponse->getHeader('Content-Type'))) {
                require __DIR__ . '/../@Templates/Error/500.phtml';
            }
        });
    }
}
