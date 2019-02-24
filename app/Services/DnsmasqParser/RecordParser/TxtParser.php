<?php
/**
 * Created by PhpStorm.
 * User: nono
 * Date: 2/24/19
 * Time: 11:34 AM
 */

namespace App\Services\DnsmasqParser\RecordParser;


class TxtParser extends BaseParser
{
    protected $configFormat = 'txt-record=%s,"%s"';
}
