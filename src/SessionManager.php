<?php

namespace Proto\Session;

use Evenement\EventEmitter;
use Opt\OptTrait;
use Proto\Session\Exception\SessionException;

class SessionManager extends EventEmitter implements SessionManagerInterface
{
    use OptTrait;

    private $SESSION;

    public function __construct()
    {
        // Default options
        $this->setOpt(self::OPT_SESSION_KEY_LENGTH, 32);
        $this->setOpt(self::OPT_UNIQUE_NAME_LENGTH, 16);
    }

    public function start(string $key = null): SessionInterface
    {
        if (!isset($key)) {
            $session = new Session($this, $this->getUniqueKey());
            $this->emit('create', [$session]);
            return $session;
        }

        if (!isset($this->SESSION[$key])) {

            // Ask from storage handler for it.
            $session = null;
            $this->emit('recover', [$key, $this, &$session]);

            if (!($session instanceof SessionInterface))
                throw new SessionException(null, SessionException::ERR_INVALID_SESSION_KEY);

            return $session;
        }

        return $this->SESSION[$key];
    }

    public function is(string $key): bool
    {
        if (isset($this->SESSION[$key]))
            return true;

        // Ask from storage handler for it.
        $session = null;
        $this->emit('recover', [$key, $this, &$session]);

        if ($session !== null && $session instanceof SessionInterface)
            return true;

        return false;
    }

    /**
     * Generate unique key
     * @return string
     * @throws SessionException
     */
    private function getUniqueKey(): string
    {
        do {
            try {
                $isDuplicate = null;
                $key = random_bytes($this->getOpt(self::OPT_SESSION_KEY_LENGTH));

                // Ask for duplicate key from storage
                $this->emit('duplicate-check', [$key, &$isDuplicate]);

            } catch (\Exception $e) {
                throw new SessionException($e->getMessage(), SessionException::ERR_RANDOM_BYTES);
            }
        } while (isset($this->SESSION[$key]) || $isDuplicate === true);

        return $key;
    }
}