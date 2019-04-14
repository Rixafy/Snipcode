<?php

declare(strict_types=1);

namespace Snipcode\Model\Slug;

use Snipcode\Model\Snippet\Snippet;
use Snipcode\Model\Variable\Exception\VariableNotFoundException;
use Snipcode\Model\Variable\VariableFacade;
use Hashids\Hashids;

class SlugHelper
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
		$insertedSnippets = $this->variableFacade->getByName('snippets_inserted');

		$insertedSnippets->increaseValue();

		$snippet->createSlug($insertedSnippets->getValue(), $this->hashIds->encode($insertedSnippets->getValue()));

		return $snippet;
	}
}