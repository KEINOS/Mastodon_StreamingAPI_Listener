<?php

/**
 * This file is part of the keinos/mastodon-streaming-api-listener package.
 *
 * - Authors, copyright, license, usage and etc.:
 *   - See: https://github.com/KEINOS/Mastodon_StreamingAPI_Listener/
 */

declare(strict_types=1);

namespace KEINOS\MSTDN_TOOLS\Listener;

use KEINOS\MSTDN_TOOLS\Config\Config;
use KEINOS\MSTDN_TOOLS\Parser\Parser;

class ListenerProtectedMethods
{
    use PropertiesTrait;

    protected const NAME_USERAGENT_DEFAULT  = 'MSTDN_TOOLS/1.0 mastodon-streaming-api-listener';
    protected const CRLF = "\r\n";

    /**
     * @param  resource $socket
     * @return void
     */
    protected function closeSocket($socket): void
    {
        fclose($socket);
    }

    /**
     * @param  string $name_method
     * @return void|string
     */
    protected function echoOnDebug(string $name_method)
    {
        if ($this->getModeDebug()) {
            echo trim($name_method) . PHP_EOL;
        }
    }

    /**
     * generateRequestApiStreamingPublic
     *
     * @param  Config $conf
     * @return string
     * @throws \Exception
     */
    protected function generateRequestApiStreamingPublic(Config $conf): string
    {
        $method   = 'GET';
        $endpoint = $conf->getEndpointApiStreamingPublic();
        $url_host = $conf->getUrlHost();

        $host = parse_url($url_host, \PHP_URL_HOST);
        if (null === $host) {
            $msg = 'Config error. Name of the URL does not contain a valid host.';
            throw new \Exception($msg);
        }
        $user_agent = self::NAME_USERAGENT_DEFAULT;
        $req = [
            "{$method} {$endpoint} HTTP/1.1",
            "Host: {$host}",
            "User-Agent: {$user_agent}",
        ];

        // The request must contain 2 extra blank lines
        $req = implode(self::CRLF, $req) . self::CRLF . self::CRLF;

        return $req;
    }

    /**
     * Read/buffer lines of chunked event as one.
     *
     * @param  resource $socket
     * @param  Parser   $parser
     * @return string Event data in JSON format.
     */
    protected function getEventAsJson($socket, $parser): string
    {
        $read = false;
        while ($read === false) {
            $line = strval(fgets($socket));
            $read = $parser->parse($line);
        }

        return strval($read);
    }

    /**
     * @param  Config $conf
     * @return false|resource
     * @throws \Exception
     */
    protected function openSocket(Config $conf)
    {
        try {
            $uri_websocket = $conf->getUriStreamingApi();

            $host = parse_url($uri_websocket, \PHP_URL_HOST) ?: '';
            $port = parse_url($uri_websocket, \PHP_URL_PORT) ?: 443;

            $hostname = 'ssl://' . $host;
            $errno    = 0;
            $errstr   = '';
            $timeout  = 10; // seconds

            return fsockopen($hostname, intval($port), $errno, $errstr, $timeout);
        } catch (\Exception $e) {
            $msg = 'Failed to open socket. ' . PHP_EOL
                 . ' - Error message: {$errstr} ({$errno})' . PHP_EOL
                 . ' - ' . trim($e->getMessage()) . PHP_EOL;
            throw new \Exception($msg);
        }
    }

    /**
     * This will treat warnings as ErrorException. Note that this WILL NOT take effect
     * if the error reporting level is 0(zero).
     *
     * @return void
     */
    protected function treatWarningAsException(): void
    {
        set_error_handler(function (int $errno, string $errstr, string $errfile, int $errline) {
            if (0 === error_reporting()) {
                return false; // Return false to do nothing.
            }

            // Error handler throws \ErrorException even warnings.
            throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
        });
    }
}
