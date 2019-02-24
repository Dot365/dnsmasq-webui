<?php
/**
 * Created by PhpStorm.
 * User: nono
 * Date: 2/24/19
 * Time: 11:32 AM
 */

namespace App\Services\DnsmasqParser\RecordParser;


class CnameParser extends BaseParser
{
    protected $configFormat = 'cname=%s,%s';
}
