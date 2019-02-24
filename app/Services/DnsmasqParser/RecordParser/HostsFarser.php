<?php
/**
 * Created by PhpStorm.
 * User: nono
 * Date: 2/24/19
 * Time: 12:43 PM
 */

namespace App\Services\DnsmasqParser\RecordParser;


class HostsFarser extends BaseParser
{
    protected $configFormat = '%s %s';

    protected function load(string $domain, string $content): string
    {
        return parent::load($content, $domain);
    }
}
