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

class ListenerProtectedMethods
{
    use PropertiesTrait;

    protected const NAME_USERAGENT_DEFAULT  = 'MSTDN_TOOLS/1.0 mastodon-streaming-api-listener';
    protected const CRLF = "\r\n";

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
     * @param  Config $conf
     * @return resource
     * @throws \Exception
     */
    protected function openSocket(Config $conf)
    {
        $uri_websocket = $conf->getUriStreamingApi();
        $host = parse_url($uri_websocket, \PHP_URL_HOST) ?: '';
        $port = parse_url($uri_websocket, \PHP_URL_PORT) ?: 443;
        if (! empty($host)) {
            $hostname = 'ssl://' . $host;
            $timeout  = 10; // seconds
            $errno    = '';
            $errstr   = '';

            $fp = fsockopen($hostname, $port, $errno, $errstr, $timeout);
            if (! $fp) {
                $msg = "Failed to open socket. Error message: {$errstr} ({$errno})";
                throw new \Exception($msg);
            }

            return $fp;
        }

        throw new \Exception();
    }

    protected function treatWarningAsException(): void
    {
        set_error_handler(function (int $errno, string $errstr, string $errfile, int $errline, array $errcontext) {
            if (0 === error_reporting()) {
                return false;
            }

            throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
        });
    }
}
