<?php

namespace demo\filter;

use PSX\Filter;
use PSX\Input;
use PSX\Module\ViewAbstract;

class index extends ViewAbstract
{
	public function onLoad()
	{
		$this->template->assign('result', $this->getPostResult($this->getBody()));

		if($this->getValidator()->hasError())
		{
			$this->template->assign('error', $this->getValidator()->getError());
		}

		$this->template->set(str_replace('\\', DIRECTORY_SEPARATOR, __CLASS__) . '.tpl');
	}

	public function getPostResult(Input $input)
	{
		return array(
			'string'       => $input->value_string('string', array(new Filter\Html())),
			'integer'      => $input->value_integer('integer', array(new Filter\Html())),
			'float'        => $input->value_float('float', array(new Filter\Html())),
			'boolean'      => $input->value_boolean('boolean', array(new Filter\Html())),
			'alnum'        => $input->value_alnum('string', array(new Filter\Alnum(), new Filter\Html())),
			'alpha'        => $input->value_alpha('string', array(new Filter\Alpha(), new Filter\Html())),
			'dateinterval' => $input->value_dateinterval('string', array(new Filter\DateInterval(), new Filter\Html())),
			'datetime'     => $input->value_datetime('string', array(new Filter\DateTime(), new Filter\Html())),
			'digit'        => $input->value_digit('string', array(new Filter\Digit(), new Filter\Html())),
			'email'        => $input->value_email('string', array(new Filter\Email(), new Filter\Html())),
			'html'         => $input->value_html('string', array(new Filter\Html())),
			'inarray'      => $input->value_inarray('string', array(new Filter\InArray(array('foobar')), new Filter\Html())),
			'ip'           => $input->value_ip('string', array(new Filter\Ip(), new Filter\Html())),
			'keyexists'    => $input->value_keyexists('string', array(new Filter\KeyExists(array('foo' => 'bar')), new Filter\Html())),
			'length'       => $input->value_length('string', array(new Filter\Length(3, 6), new Filter\Html())),
			'md5'          => $input->value_md5('string', array(new Filter\Md5(), new Filter\Html())),
			'regexp'       => $input->value_regexp('string', array(new Filter\Regexp('/(\w+)/'), new Filter\Html())),
			'sha1'         => $input->value_sha1('string', array(new Filter\Sha1(), new Filter\Html())),
			'url'          => $input->value_url('string', array(new Filter\Length(7, 256), new Filter\Url(), new Filter\Html())),
			'xdigit'       => $input->value_xdigit('string', array(new Filter\Xdigit(), new Filter\Html())),
		);
	}
}
