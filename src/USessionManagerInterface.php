<?php

namespace USession;

use Evenement\EventEmitterInterface;
use USession\Exception\USessionException;

interface USessionManagerInterface extends EventEmitterInterface
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
     * Set options
     * @param int $opt
     * @param $value
     * @return USessionManagerInterface
     */
    public function setOpt(int $opt, $value): USessionManagerInterface;

    /**
     * Get options
     * @param int $opt
     * @return mixed
     */
    public function getOpt(int $opt);

    /**
     * Start session
     * @param string|null $key
     * @return USessionInterface
     * @throws USessionException
     */
    public function start(string $key = null): USessionInterface;
}