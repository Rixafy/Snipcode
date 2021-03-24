<?php 

declare(strict_types=1);

namespace App\Module\Front;

use App\Model\Session\Session;
use App\Model\Session\SessionProvider;
use Nette;
use Nette\Application\Helpers;
use Nette\DI\Attributes\Inject;

abstract class BaseFrontPresenter extends Nette\Application\UI\Presenter
{
    #[Inject] public SessionProvider $sessionProvider;
    
    protected Session $session;

    public function startup(): void
    {
        parent::startup();

        $this->sessionProvider->setup();
        $this->session = $this->sessionProvider->provide();
    }

    public function beforeRender(): void
    {
        $this->setLayout(__DIR__ . '/@Templates/@Layout/layout.latte');
        $this->getTemplate()->setFile(__DIR__ . '/@Templates/' . Helpers::splitName($this->getName())[1] . '/' . $this->getAction() . '.latte');
    }
}
