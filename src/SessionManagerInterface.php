<?php

namespace Proto\Session;

use Evenement\EventEmitterInterface;
use Opt\OptInterface;
use Proto\Session\Exception\SessionException;

/**
 * USession Events:
 * @event create [USession $session] The session created.
 * @event recover [string $key, USessionManager $manager, USession &$session = null] The session recovered by key.
 * @event update [USession $session, string $name] The session's data updated.
 * @event clean [USession $session] The session cleaned
 * @event destroy [USession $session] The session destroyed.
 *
 * @event duplicate-check [string $binaryKey] Check key is unique in all storage.
 *
 * @package USession
 */
interface SessionManagerInterface extends EventEmitterInterface, OptInterface
{
    /**
     * Length of session's key, default is 32
     */
    const OPT_SESSION_KEY_LENGTH = 0;

    /**
     * Length of unique name, default is 16
     */
    const OPT_UNIQUE_NAME_LENGTH = 1;

    /**
     * Start session
     * @param string|null $key
     * @return SessionInterface
     * @throws SessionException
     */
    public function start(string $key = null): SessionInterface;
}