<?php

namespace App\Services;

use App\Models\Configure;
use App\Models\Record;
use App\Services\DnsmasqParser\CommonParser\AddnHostsParser;
use App\Services\DnsmasqParser\CommonParser\NameserverParser;
use App\Services\DnsmasqParser\CommonParser\ResolvFileParser;
use App\Services\DnsmasqParser\RecordParser\ParserFactory;
use App\Services\DnsmasqParser\RecordParser\ParserInterface;
use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class DnsmasqParseService
{
    protected $hostsFile = 'hosts';
    protected $addnHostsFile = 'addn-hosts.conf';
    protected $recordsFile = 'records.conf';
    protected $nameserverKey = 'nameserver';
    protected $nameserverFile = 'resolv';
    protected $resolvFile = 'resolv.conf';

    /**
     * @var array|ParserInterface
     */
    protected $recordParsers = [];

    /**
     * @var NameserverParser $nameserverParser
     */
    protected $nameserverParser;

    /**
     * @param $type
     * @return ParserInterface
     * @throws DnsmasqParser\DnsmasqParserException
     */
    protected function getRecordParser($type): ParserInterface
    {
        if (isset($this->recordParsers[$type])) {
            return $this->recordParsers[$type];
        } else {
            return $this->recordParsers[$type] = ParserFactory::build($type);
        }
    }

    /**
     * @return NameserverParser
     */
    protected function getNameserverParser(): NameserverParser
    {
        if ($this->nameserverParser instanceof NameserverParser) {
            return $this->nameserverParser;
        } else {
            return $this->nameserverParser = new NameserverParser();
        }
    }

    /**
     * @return Filesystem
     */
    protected function getStorage(): Filesystem
    {
        return Storage::disk('dnsmasq');
    }

    /**
     * @param string $type
     * @param string $domain
     * @param string $record
     * @param string $content
     * @return string
     * @throws DnsmasqParser\DnsmasqParserException
     */
    public function parseRecord(string $type, string $domain, string $record, string $content): string
    {
        return $this->getRecordParser($type)->parse($domain, $record, $content);
    }

    /**
     * @param Collection $records
     * @return string
     */
    public function parseRecords(Collection $records): string
    {
        $parsedRecrods = collect();

        $records->each(function (Record $record) use (&$parsedRecrods) {
            $parsedRecrods->push($this->parseRecord(
                $record->type,
                $record->domain->domain,
                $record->record,
                $record->content
            ));
        });

        return implode(PHP_EOL, $parsedRecrods->toArray());
    }

    /**
     * @param string $type
     * @param string $domain
     * @param string $record
     * @param string $content
     * @return string
     * @throws DnsmasqParser\DnsmasqParserException
     */
    public function parseHost(string $type, string $domain, string $record, string $content): string
    {
        return $this->parseRecord($type, $domain, $record, $content);
    }

    /**
     * @param Collection $hosts
     * @return string
     */
    public function parseHosts(Collection $hosts): string
    {
        $parsedHosts = collect();

        $hosts->each(function (Record $record) use (&$parsedHosts) {
            $parsedHosts->push($this->parseHost(
                $record->type,
                $record->domain->domain,
                $record->record,
                $record->content
            ));
        });

        return implode(PHP_EOL, $parsedHosts->toArray());
    }

    /**
     * @param string $address
     * @return string
     */
    public function parseNameserver(string $address): string
    {
        return $this->getNameserverParser()->parse($address);
    }

    /**
     * @param Collection $addresses
     * @return string
     */
    public function parseNameservers(Collection $addresses): string
    {
        return implode(PHP_EOL, $addresses->map(function ($address) {
            return $this->parseNameserver($address);
        })->toArray());
    }

    public function generateRecords()
    {
        $records = Record::with('domain')->where('record', '!=', '@')->get();
        $this->getStorage()->put(
            $this->recordsFile,
            $this->parseRecords($records)
        );
    }

    public function generateHosts()
    {
        $hosts = Record::with('domain')->where('record', '=', '@')->get();
        if (!$this->getStorage()->exists($this->addnHostsFile)) {
            $addnHostsParser = new AddnHostsParser();
            $this->getStorage()->put(
                $this->addnHostsFile,
                $addnHostsParser->parse($this->hostsFile)
            );
        }
        $this->getStorage()->put(
            $this->hostsFile,
            $this->parseHosts($hosts)
        );
    }

    public function generateResolvers()
    {
        /** @var Configure $config */
        $config = Configure::where('name', $this->nameserverKey)->first();
        $nameservers = collect($config ? json_decode($config->content) : []);
        if (!$this->getStorage()->exists($this->resolvFile)) {
            $resolvFileParser = new ResolvFileParser();
            $this->getStorage()->put(
                $this->resolvFile,
                $resolvFileParser->parse($this->nameserverFile)
            );
        }
        $this->getStorage()->put(
            $this->nameserverFile,
            $this->parseNameservers($nameservers)
        );
    }
}
