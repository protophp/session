<?php

namespace USession;

use USession\Exception\USessionException;

interface USessionInterface
{
    /**
     * Instance a new session
     *
     * @event create
     * @param USessionManagerInterface $sessionManager
     * @param string $key
     */
    public function __construct(USessionManagerInterface $sessionManager, string $key);

    /**
     * Set new data
     * @event update
     * @param string $name
     * @param mixed $value Set value null to remove it
     * @return USessionInterface
     */
    public function set(string $name, $value): USessionInterface;

    /**
     * Get data
     * @param string $name
     * @return mixed NULL returned if the $name is not exists or session destroyed.
     */
    public function get(string $name);

    /**
     * Is data exists
     * @param string $name
     * @return bool
     */
    public function is(string $name): bool;

    /**
     * Get session's key
     * @return string
     */
    public function getKey(): string;

    /**
     * Generate unique name in this session
     * @return string
     * @throws USessionException
     */
    public function getUniqueName(): string;

    /**
     * Clean session
     * @event clean
     * @return USessionInterface
     */
    public function clean(): USessionInterface;

    /**
     * Destroy session
     * @event destroy
     * @return void
     */
    public function destroy(): void;
}