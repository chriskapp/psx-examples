<?php

namespace demo\filter;

use PSX_Filter_Alnum;
use PSX_Filter_Alpha;
use PSX_Filter_DateInterval;
use PSX_Filter_DateTime;
use PSX_Filter_Digit;
use PSX_Filter_Email;
use PSX_Filter_Html;
use PSX_Filter_InArray;
use PSX_Filter_Ip;
use PSX_Filter_KeyExists;
use PSX_Filter_Length;
use PSX_Filter_Md5;
use PSX_Filter_Regexp;
use PSX_Filter_Sha1;
use PSX_Filter_Url;
use PSX_Filter_Xdigit;
use PSX_Input;
use PSX_Module_ViewAbstract;

class index extends PSX_Module_ViewAbstract
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

	public function getPostResult(PSX_Input $input)
	{
		return array(
			'string'       => $input->value_string('string', array(new PSX_Filter_Html())),
			'integer'      => $input->value_integer('integer', array(new PSX_Filter_Html())),
			'float'        => $input->value_float('float', array(new PSX_Filter_Html())),
			'boolean'      => $input->value_boolean('boolean', array(new PSX_Filter_Html())),
			'alnum'        => $input->value_alnum('string', array(new PSX_Filter_Alnum(), new PSX_Filter_Html())),
			'alpha'        => $input->value_alpha('string', array(new PSX_Filter_Alpha(), new PSX_Filter_Html())),
			'dateinterval' => $input->value_dateinterval('string', array(new PSX_Filter_DateInterval(), new PSX_Filter_Html())),
			'datetime'     => $input->value_datetime('string', array(new PSX_Filter_DateTime(), new PSX_Filter_Html())),
			'digit'        => $input->value_digit('string', array(new PSX_Filter_Digit(), new PSX_Filter_Html())),
			'email'        => $input->value_email('string', array(new PSX_Filter_Email(), new PSX_Filter_Html())),
			'html'         => $input->value_html('string', array(new PSX_Filter_Html())),
			'inarray'      => $input->value_inarray('string', array(new PSX_Filter_InArray(array('foobar')), new PSX_Filter_Html())),
			'ip'           => $input->value_ip('string', array(new PSX_Filter_Ip(), new PSX_Filter_Html())),
			'keyexists'    => $input->value_keyexists('string', array(new PSX_Filter_KeyExists(array('foo' => 'bar')), new PSX_Filter_Html())),
			'length'       => $input->value_length('string', array(new PSX_Filter_Length(3, 6), new PSX_Filter_Html())),
			'md5'          => $input->value_md5('string', array(new PSX_Filter_Md5(), new PSX_Filter_Html())),
			'regexp'       => $input->value_regexp('string', array(new PSX_Filter_Regexp('/(\w+)/'), new PSX_Filter_Html())),
			'sha1'         => $input->value_sha1('string', array(new PSX_Filter_Sha1(), new PSX_Filter_Html())),
			'url'          => $input->value_url('string', array(new PSX_Filter_Length(7, 256), new PSX_Filter_Url(), new PSX_Filter_Html())),
			'xdigit'       => $input->value_xdigit('string', array(new PSX_Filter_Xdigit(), new PSX_Filter_Html())),
		);
	}
}
