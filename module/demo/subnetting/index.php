<?php

namespace demo\subnetting;

use PSX\Exception;
use PSX\Filter;
use PSX\Module\ViewAbstract;

class index extends ViewAbstract
{
	private $a;
	private $b;
	private $c;
	private $d;
	private $s;

	public function onLoad()
	{
		$validate = $this->getValidate();
		$post     = $this->getBody();

		$this->a = $post->a('integer', array(new Filter\Length(0, 255)));
		$this->b = $post->b('integer', array(new Filter\Length(0, 255)));
		$this->c = $post->c('integer', array(new Filter\Length(0, 255)));
		$this->d = $post->d('integer', array(new Filter\Length(0, 255)));
		$this->s = $post->s('integer', array(new Filter\Length(1, 31)));

		$this->getTemplate()->assign('a', $this->a);
		$this->getTemplate()->assign('b', $this->b);
		$this->getTemplate()->assign('c', $this->c);
		$this->getTemplate()->assign('d', $this->d);
		$this->getTemplate()->assign('s', $this->s);
	}

	public function onPost()
	{
		// build binary numbers
		$ip   = str_pad(decbin($this->a), 8, '0', STR_PAD_LEFT);
		$ip  .= str_pad(decbin($this->b), 8, '0', STR_PAD_LEFT);
		$ip  .= str_pad(decbin($this->c), 8, '0', STR_PAD_LEFT);
		$ip  .= str_pad(decbin($this->d), 8, '0', STR_PAD_LEFT);
		$mask = str_pad(str_repeat('1', $this->s), 32, '0', STR_PAD_RIGHT);

		// convert binary numbers to decimal array
		$ip     = array_map('bindec', explode('.', wordwrap($ip, 8, '.', true)));
		$subnet = array_map('bindec', explode('.', wordwrap($mask, 8, '.', true)));

		// calculate network address
		$network = $this->calculateNetwork($ip, $subnet);

		// calculate broadcast
		$broadcast = $this->calculateBroadcast($network, $subnet);

		// calculate range
		$start    = $network;
		$start[3] = $start[3] + 1;

		$end      = $broadcast;
		$end[3]   = $end[3] - 1;

		// assign values to template
		$this->getTemplate()->assign('ip', $this->formatIpv4($ip));
		$this->getTemplate()->assign('subnetmask', $this->formatIpv4($subnet));
		$this->getTemplate()->assign('network', $this->formatIpv4($network));
		$this->getTemplate()->assign('broadcast', $this->formatIpv4($broadcast));

		$this->getTemplate()->assign('start', $this->formatIpv4($start));
		$this->getTemplate()->assign('end', $this->formatIpv4($end));
	}

	public static function calculateNetwork(array $ip, array $subnet)
	{
		if(count($ip) != 4 || count($subnet) != 4)
		{
			throw new Exception('Invalid ip or subnet format must be i.e. 0.0.0.0');
		}

		$subnet  = array_map('intval', $subnet);
		$ip      = array_map('intval', $ip);
		$network = array();

		foreach($ip as $k => $v)
		{
			$network[$k] = $v & $subnet[$k];
		}

		return $network;
	}

	public static function calculateBroadcast(array $network, array $subnet)
	{
		if(count($network) != 4 || count($subnet) != 4)
		{
			throw new Exception('Invalid network or subnet format must be i.e. 0.0.0.0');
		}

		$count  = substr_count(implode('', array_map('decbin', $subnet)), '1');
		$invSub = str_pad(str_repeat('1', 32 - $count), 32, '0', STR_PAD_LEFT);
		$invSub = array_map('bindec', explode('.', wordwrap($invSub, 8, '.', true)));

		$broadcast = array();

		foreach($network as $k => $v)
		{
			$broadcast[$k] = $v | $invSub[$k];
		}

		return $broadcast;
	}

	public function formatIpv4(array $number)
	{
		$binary = array();

		foreach($number as $k => $v)
		{
			$binary[$k] = str_pad(decbin($v), 8, '0', STR_PAD_LEFT);
			$number[$k] = str_pad($v, 3, '0', STR_PAD_LEFT);
		}

		return implode('.', $binary) . ' = ' . implode('.', $number);
	}
}
