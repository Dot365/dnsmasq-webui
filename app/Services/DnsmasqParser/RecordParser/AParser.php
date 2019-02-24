<?php
/**
 * Created by PhpStorm.
 * User: nono
 * Date: 2/24/19
 * Time: 10:57 AM
 */

namespace App\Services\DnsmasqParser\RecordParser;


class AParser extends BaseParser
{
    protected $configFormat = 'address=/%s/%s';

    /**
     * @var HostsFarser $hostsParser
     */
    protected $hostsParser;

    protected function getHostsParser(): HostsFarser
    {
        if ($this->hostsParser instanceof HostsFarser) {
            return $this->hostsParser;
        } else {
            return $this->hostsParser = new HostsFarser();
        }
    }

    public function parse(string $domain, string $record, string $content): string
    {
        $subdomain = $record . '.' . $domain;

        switch ($record) {
            case '@':
                $config = $this->getHostsParser()->load($domain, $content);
                break;
            case '*':
                $config = $this->load($domain, $content);
                break;
            default:
                $config = $this->load($subdomain, $content);
        }

        return $config;
    }
}
