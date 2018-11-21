<?php

namespace App\Presenters;

use App\Facade\ProfileFacade;
use Nette;

abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    /** @var ProfileFacade @inject */
    public $profileFacade;

    public function startup()
    {
        parent::startup();

        $this->profileFacade->beforeLoad();
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout($this->context->parameters['appDir'] . '/Modules/Front/Templates/@layout.latte');
        $this->template->setFile($this->context->parameters['appDir'] . '/Modules/Front/Templates/' . $this->getName() . '/' . $this->getAction() . '.latte');
    }
}