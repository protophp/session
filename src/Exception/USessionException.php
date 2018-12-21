<?php

namespace USession\Exception;

class USessionException extends \Exception
{
    const ERR_INVALID_SESSION_KEY = 100;
    const ERR_RANDOM_BYTES = 110;
}