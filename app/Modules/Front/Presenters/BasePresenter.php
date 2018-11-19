<?php

namespace App\Presenters;

use Nette;

abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    public function beforeRender()
    {
        parent::beforeRender();

        $this->template->setFile($this->context->parameters['appDir'].'/Modules/Front/Templates/'.$this->getName().'/'.$this->getAction().'.latte');
    }
}