<?php
/**
 * Created by PhpStorm.
 * User: nono
 * Date: 2/24/19
 * Time: 11:14 AM
 */

namespace App\Services\DnsmasqParser\RecordParser;


abstract class BaseParser implements ParserInterface
{
    /**
     * @var string $configFormat
     */
    protected $configFormat;

    protected function load(string $domain, string $content): string
    {
        return sprintf($this->configFormat, $domain, $content);
    }

    public function parse(string $domain, string $record, string $content): string
    {
        $subdomain = $record . '.' . $domain;

        return $this->load($subdomain, $content);
    }
}
