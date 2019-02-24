<?php
/**
 * Created by PhpStorm.
 * User: nono
 * Date: 2/24/19
 * Time: 4:01 PM
 */

namespace App\Observers;


use App\Models\Record;
use App\Services\DnsmasqParseService;

class RecordObserver
{
    public function saved(Record $record)
    {
        /** @var DnsmasqParseService $dnsmasqParseService */
        $dnsmasqParseService = app(DnsmasqParseService::class);
        $dnsmasqParseService->generateRecords();
        $dnsmasqParseService->generateHosts();
    }
}
