<?php declare(strict_types=1);

namespace Snipcode\Service;

use Snipcode\Model\Snippet\Snippet;
use Snipcode\Model\Variable\Exception\VariableNotFoundException;
use Snipcode\Model\Variable\VariableFacade;
use Hashids\Hashids;

class SlugGenerator
{
    /** @var string */
    protected $salt;

    /** @var Hashids */
    protected $hashIds;

    /** @var VariableFacade */
    protected $variableFacade;

    public function __construct(string $salt, VariableFacade $variableFacade)
    {
        $this->salt = $salt;
        $this->hashIds = new Hashids($salt);
    	$this->variableFacade = $variableFacade;
    }

	/**
	 * @throws VariableNotFoundException
	 */
	public function injectSlug(Snippet $snippet): Snippet
	{
		$snippets_inserted = $this->variableFacade->getByName('snippets_inserted');

		$snippets_inserted->increaseValue();

		$snippet->createSlug($snippets_inserted->getValue(), $this->hashIds->encode($snippets_inserted->getValue()));

		return $snippet;
	}
}