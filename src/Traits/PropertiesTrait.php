<?php

/**
 * This file is part of the keinos/mastodon-streaming-api-listener package.
 *
 * - Authors, copyright, license, usage and etc.:
 *   - See: https://github.com/KEINOS/Mastodon_StreamingAPI_Listener/
 */

declare(strict_types=1);

namespace KEINOS\MSTDN_TOOLS\Listener;

trait PropertiesTrait
{
    /** @var string */
    protected $event_name = '';
    public function setNameEvent(string $event_name): void
    {
        $this->event_name = $event_name;
    }
    public function getNameEvent(): string
    {
        return $this->event_name;
    }

    /** @var string */
    protected $event_payload = '';
    public function setDataPayload(string $event_payload): void
    {
        $this->event_payload = $event_payload;
    }
    public function getDataPayload(): string
    {
        return $this->event_payload;
    }

    /** @var bool */
    protected $mode_debug = false;
    public function setModeAsDebug(bool $mode_debug): void
    {
        $this->mode_debug = $mode_debug;
    }
    public function getModeDebug(): bool
    {
        return $this->mode_debug;
    }

    /** @var string */
    protected $type_stream = '';
    /**
     * @param  string $type_stream  Excepts only "local" or "public".
     * @return void
     * @throws \Exception  Other than "local" or "public".
     */
    public function setTypeStream(string $type_stream): void
    {
        if (('local' !== $type_stream) && ('public' !== $type_stream)) {
            $msg = 'Bad stream type. Only "local" or "public" are available.' . PHP_EOL;
            throw new \Exception($msg);
        }
        $this->type_stream = $type_stream;
    }
    public function getTypeStream(): string
    {
        return $this->type_stream;
    }
}
