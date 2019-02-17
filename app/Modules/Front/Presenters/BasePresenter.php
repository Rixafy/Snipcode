<?php declare(strict_types=1);

namespace App\Presenters;

use App\Facade\ConfigFacade;
use App\Facade\ProfileFacade;
use Nette;

abstract class BasePresenter extends Nette\Application\UI\Presenter
{
    /** @var ConfigFacade @inject */
    public $configFacade;

    /** @var ProfileFacade @inject */
    public $profileFacade;

    /** @var array */
    public $constants;

    public function startup()
    {
        parent::startup();

        $this->profileFacade->beforeLoad();
        $this->constants = $this->configFacade->getConstants();
    }

    public function beforeRender()
    {
        parent::beforeRender();

        $this->setLayout($this->context->parameters['appDir'] . '/Modules/Front/Templates/@layout.latte');
        $this->template->setFile($this->context->parameters['appDir'] . '/Modules/Front/Templates/' . $this->getName() . '/' . $this->getAction() . '.latte');

        $this->template->constants = $this->constants;
    }
}