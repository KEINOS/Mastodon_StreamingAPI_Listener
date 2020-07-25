<?php

/**
 * This file is part of the keinos/mastodon-streaming-api-listener package.
 *
 * - Authors, copyright, license, usage and etc.:
 *   - See: https://github.com/KEINOS/Mastodon_StreamingAPI_Listener/
 */

declare(strict_types=1);

namespace KEINOS\MSTDN_TOOLS\Listener;

/**
 * Interface to use \KEINOS\MSTDN_TOOLS\Config class.
 *
 * Describe and define public classes here as a user manual/reference.
 */
interface ListenerInterface
{
    /**
     * Checks the host name and the port of the Mastodon Streaming API server-sent
     * messages then opens the socket to the server.
     *
     * @param  array<string,mixed> $conf
     */
    public function __construct(array $conf);

    /**
     * Close the socket and unset the handler.
     *
     * @return void
     */
    public function __destruct();

    /**
     * Returns the current event data (payload) as a value of the iteration.
     *
     * @return string
     */
    public function current(): string;

    /**
     * Returns the current event name as a key of the iteration.
     *
     * @return string
     */
    public function key(): string;

    /**
     * Resets the current event name and data before receiving the next event.
     *
     * @return void
     */
    public function next(): void;

    /**
     * Requests API to send messages.
     *
     * This is called once when the object was called from the iterator, such
     * as "for", "while", "foreach" loop.
     *
     * @return void
     */
    public function rewind(): void;

    /**
     * Checks if the socket is still open.
     *
     * @return bool   True if the socket is open.
     */
    public function valid(): bool;
}
