<?php

namespace USession;

use USession\Exception\USessionException;

class USession implements USessionInterface
{
    /**
     * @var USessionManagerInterface
     */
    private $manager;
    private $key;
    private $data;
    private $destroyed;

    public function __construct(USessionManagerInterface $sessionManager, string $key)
    {
        $this->manager = $sessionManager;
        $this->key = $key;
        $this->destroyed = false;
    }

    public function set(string $name, $value): USessionInterface
    {
        if ($this->destroyed === true)
            return $this;

        $this->data[$name] = $value;
        $this->manager->emit('update', [$this, $name]);
        return $this;
    }

    public function get(string $name)
    {
        if ($this->destroyed === true)
            return null;

        return $this->data[$name];
    }

    public function is(string $name): bool
    {
        if ($this->destroyed === true)
            return false;

        return isset($this->data[$name]);
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getUniqueName(): string
    {
        do {
            try {
                $key = random_bytes($this->manager->getOpt(USessionManagerInterface::OPT_SESSION_KEY_LENGTH));
            } catch (\Exception $e) {
                throw new USessionException($e->getMessage(), USessionException::ERR_RANDOM_BYTES);
            }
        } while (isset($this->SESSION[$key]));

        return $key;
    }

    public function clean(): USessionInterface
    {
        $this->data = [];
        $this->manager->emit('clean', [$this]);
        return $this;
    }


    public function destroy(): void
    {
        $this->clean();
        $this->destroyed = true;
        $this->manager->emit('destroy', [$this]);
    }
}