<?php
/**
 * Created by PhpStorm.
 * User: nono
 * Date: 2/24/19
 * Time: 4:04 PM
 */

namespace App\Observers;


use App\Models\Configure;
use App\Services\DnsmasqParseService;

class ConfigureObserver
{
    public function saved(Configure $configure)
    {
        if ($configure->name == 'nameserver') {
            /** @var DnsmasqParseService $dnsmasqParseService */
            $dnsmasqParseService = app(DnsmasqParseService::class);
            $dnsmasqParseService->generateResolvers();
        }
    }
}
