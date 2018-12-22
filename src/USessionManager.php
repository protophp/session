<?php

namespace USession;

use Evenement\EventEmitter;
use Opt\OptTrait;
use USession\Exception\USessionException;

class USessionManager extends EventEmitter implements USessionManagerInterface
{
    use OptTrait;

    private $SESSION;

    public function __construct()
    {
        // Default options
        $this->setOpt(self::OPT_SESSION_KEY_LENGTH, 32);
        $this->setOpt(self::OPT_UNIQUE_NAME_LENGTH, 16);
    }

    public function start(string $key = null): USessionInterface
    {
        if (!isset($key))
            return new USession($this, $this->getUniqueKey());

        if (!isset($this->SESSION[$key])) {

            // Ask from storage handler for it.
            $session = null;
            $this->emit('recover', [$key, &$session]);

            if (!($session instanceof USessionInterface))
                throw new USessionException(null, USessionException::ERR_INVALID_SESSION_KEY);

            return $session;
        }

        return $this->SESSION[$key];
    }

    /**
     * Generate unique key
     * @return string
     * @throws USessionException
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
                throw new USessionException($e->getMessage(), USessionException::ERR_RANDOM_BYTES);
            }
        } while (isset($this->SESSION[$key]) || $isDuplicate === true);

        return $key;
    }
}