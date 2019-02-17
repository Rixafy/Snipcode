<?php declare(strict_types=1);

namespace App\Presenters;

use Nette;


final class Error4xxPresenter extends BasePresenter
{
	public function startup()
	{
		parent::startup();
		if (!$this->getRequest()->isMethod(Nette\Application\Request::FORWARD)) {
			$this->error();
		}
	}


	public function renderDefault(Nette\Application\BadRequestException $exception)
	{
		// load template 403.latte or 404.latte or ... 4xx.latte
		$file = $this->context->parameters['appDir'] . '/Modules/Front/Templates/Error/'.$exception->getCode().'.latte';
		$this->template->setFile(is_file($file) ? $file : $this->context->parameters['appDir'] . '/Modules/Front/Templates/Error/4xx.latte');
	}
}
