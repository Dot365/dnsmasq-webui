<?php
/**
 * Created by PhpStorm.
 * User: nono
 * Date: 2/24/19
 * Time: 1:06 PM
 */

namespace App\Services\DnsmasqParser\CommonParser;


class NameserverParser
{
    protected $configFormat = 'nameserver %s';

    protected function load($address): string
    {
        return sprintf($this->configFormat, $address);
    }

    public function parse($address): string
    {
        return $this->load($address);
    }
}
