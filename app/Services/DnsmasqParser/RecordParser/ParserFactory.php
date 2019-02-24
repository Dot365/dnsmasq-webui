<?php
/**
 * Created by PhpStorm.
 * User: nono
 * Date: 2/24/19
 * Time: 10:53 AM
 */

namespace App\Services\DnsmasqParser\RecordParser;


use App\Services\DnsmasqParser\DnsmasqParserException;

class ParserFactory
{
    /**
     * @param string $type
     * @return ParserInterface
     * @throws DnsmasqParserException
     */
    public static function build(string $type): ParserInterface
    {
        switch ($type)
        {
            case 'a':
            case 'aaaa':
            case 'cname':
            case 'txt':
                $className = __NAMESPACE__ . '\\' . ucfirst($type) . 'Parser';
                break;
            case 'base':
            default:
                throw new DnsmasqParserException(sprintf('%s parser not found!', strtoupper($type)));
        }

        return new $className();
    }
}
