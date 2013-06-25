<?php

namespace Example;

use PSX\Data\HandlerAbstract;

class Handler extends HandlerAbstract
{
	public function getClassName()
	{
		return '\Example\Record';
	}

	public function getClassArgs()
	{
		return array($this->table);
	}
}
