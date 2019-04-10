<?php declare(strict_types=1);

namespace App\Presenters;

use Nette;


final class Error4xxPresenter extends BasePresenter
{
	public function startup(): void
	{
		parent::startup();
		if (!$this->getRequest()->isMethod(Nette\Application\Request::FORWARD)) {
			$this->error();
		}
	}


	public function renderDefault(Nette\Application\BadRequestException $exception): void
	{
		$file = $this->context->parameters['appDir'] . '/Modules/Front/Templates/Error/'.$exception->getCode().'.latte';
		$this->template->setFile(is_file($file) ? $file : $this->context->parameters['appDir'] . '/Modules/Front/Templates/Error/4xx.latte');
	}
}
