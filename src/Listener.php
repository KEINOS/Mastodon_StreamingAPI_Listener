<?php

/**
 * This file is the main class of the keinos/mastodon-streaming-api-listener package.
 *
 * - Reference of the public methods of this class to use:
 *   - See: ./ListenerInterface.php
 *
 * - Authors, copyright, license, usage and etc.:
 *   - See: https://github.com/KEINOS/Mastodon_StreamingAPI_Listener/
 */

declare(strict_types=1);

namespace KEINOS\MSTDN_TOOLS\Listener;

use KEINOS\MSTDN_TOOLS\Config\Config;
use KEINOS\MSTDN_TOOLS\Parser\Parser;

/**
 * @phpstan-implements \Iterator<string,mixed>
 */
class Listener extends ListenerProtectedMethods implements \Iterator, ListenerInterface
{
    use PropertiesTrait; // Getter/setter of the properties

    /** @var Config */
    protected $conf;
    /** @var Parser */
    protected $parser;
    /** @var resource */
    protected $socket;

    protected const ASSOC_AS_ARRAY = true; // Associate return as array in json_decode
    protected const MODE_DEBUG_DEFAULT = false;
    protected const TIMEOUT_REQUEST_DEFAULT = 10; // seconds
    protected const TYPE_STREAM_DEFAULT = 'public';

    public function __construct(array $conf)
    {
        $this->treatWarningAsException();

        // Set debug mode. Listener class original conf.
        $flag_mode_debug = self::MODE_DEBUG_DEFAULT;
        if (isset($conf['flag_mode_debug'])) {
            $flag_mode_debug = (false !== $conf['flag_mode_debug']);
        }
        $this->setModeAsDebug($flag_mode_debug);

        // Set stream type. Defines which endpoint to use whether 'local' or 'public'.
        $type_stream = self::TYPE_STREAM_DEFAULT;
        if (isset($conf['type_stream'])) {
            $type_stream = strval($conf['type_stream']);
        }
        $this->setTypeStream($type_stream);

        $this->setNameEvent('');
        $this->setDataPayload('');

        $this->conf   = new Config($conf);
        $this->parser = new Parser();
        $fp = $this->openSocket($this->conf);
        if (! is_resource($fp)) {
            $msg = 'Failed to open socket. ' . PHP_EOL;
            throw new \Exception($msg);
        }
        $this->socket = $fp;
    }

    /**
     * @codeCoverageIgnore
     */
    public function __destruct()
    {
        $this->closeSocket($this->socket);
    }

    public function current(): string
    {
        $read  = $this->getEventAsJson($this->socket, $this->parser);
        $event = (array) json_decode($read, self::ASSOC_AS_ARRAY);

        if (! isset($event['event'])) {
            return '';
        }
        if (! isset($event['payload'])) {
            return '';
        }
        $event_name    = strval($event['event']);
        $event_payload = json_encode((array) $event['payload']) ?: '';

        // Set event name as a iteration key and event data(payload) as a value.
        $this->setNameEvent($event_name);
        $this->setDataPayload($event_payload);

        return $this->getDataPayload();
    }

    public function key(): string
    {
        return $this->getNameEvent();
    }

    public function next(): void
    {
        $this->setNameEvent('');
        $this->setDataPayload('');
    }

    public function rewind(): void
    {
        // Prepare request header
        $req = $this->generateRequestApiStreaming($this->conf);

        // Send GET request
        fwrite($this->socket, $req);
    }

    public function valid(): bool
    {
        if (is_resource($this->socket) && (! feof($this->socket)) && ("resource" === gettype($this->socket))) {
            return true;
        }

        return false;
    }
}
