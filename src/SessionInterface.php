<?php

namespace Proto\Session;

use Proto\Session\Exception\SessionException;

interface SessionInterface
{
    /**
     * Instance a new session
     *
     * @event create
     * @param SessionManagerInterface $sessionManager
     * @param string $key
     */
    public function __construct(SessionManagerInterface $sessionManager, string $key);

    /**
     * Set new data
     * @event update
     * @param string $name
     * @param mixed $value Set value null to remove it
     * @return SessionInterface
     */
    public function set(string $name, $value): SessionInterface;

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
     * Get session's key in binary
     * @return string
     */
    public function getKey(): string;

    /**
     * Get session's key in hexadecimal
     * @return string
     */
    public function getHexKey(): string;

    /**
     * Generate unique name in this session
     * @return string
     * @throws SessionException
     */
    public function getUniqueName(): string;

    /**
     * Clean session
     * @event clean
     * @return SessionInterface
     */
    public function clean(): SessionInterface;

    /**
     * Destroy session
     * @event destroy
     * @return void
     */
    public function destroy();
}