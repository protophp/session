<?php

namespace Proto\Session\Exception;

class SessionException extends \Exception
{
    const ERR_INVALID_SESSION_KEY = 100;
    const ERR_RANDOM_BYTES = 110;
}