<?php
/**
 * Created by PhpStorm.
 * User: nono
 * Date: 2/24/19
 * Time: 1:30 PM
 */

namespace App\Services\DnsmasqParser\CommonParser;


class AddnHostsParser
{
    protected $configFormat = 'addn-hosts=/etc/dnsmasq.d/%s';

    protected function load($filename): string
    {
        return sprintf($this->configFormat, $filename);
    }

    public function parse($filename): string
    {
        return $this->load($filename);
    }
}
