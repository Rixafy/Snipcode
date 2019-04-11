<?php declare(strict_types=1);

namespace Snipcode\Component;

use Nette\Application\UI\Control;

abstract class BaseComponent extends Control
{
    /** @var array[] */
    protected $onChange = [];

    /** @var array[] */
    protected $onSuccess = [];

    /** @var array[] */
    protected $onFail = [];

    public function render()
    {
        $template = $this->template;

        $template->setFile($this->getPresenter()->context->parameters['appDir'] . '/Modules/Front/Templates/@Components/' . $this->getName() . '.latte');

        $template->render();
    }

    /**
     * @param callable $action
     * @return $this
     */
    public function addOnChange(callable $action): BaseComponent
    {
        $this->onChange[] = $action;

        return $this;
    }

    /**
     * @param callable $action
     * @return $this
     */
    public function addOnSuccess(callable $action): BaseComponent
    {
        $this->onSuccess[] = $action;

        return $this;
    }

    /**
     * @param callable $action
     * @return $this
     */
    public function addOnFail(callable $action): BaseComponent
    {
        $this->onFail[] = $action;

        return $this;
    }

    public function onChange(): void
    {
        foreach ($this->onChange as $action) {
            $action();
        }
    }

    public function onSuccess(): void
    {
        foreach ($this->onSuccess as $action) {
            $action();
        }
    }

    public function onFail(): void
    {
        foreach ($this->onFail as $action) {
            $action();
        }
    }
}