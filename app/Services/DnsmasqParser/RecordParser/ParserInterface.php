<?php
/**
 * Created by PhpStorm.
 * User: nono
 * Date: 2/24/19
 * Time: 10:55 AM
 */

namespace App\Services\DnsmasqParser\RecordParser;


interface ParserInterface
{
    public function parse(string $domain, string $record, string $content);
}
