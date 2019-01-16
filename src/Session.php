<?php

namespace Proto\Session;

use Proto\Session\Exception\SessionException;

class Session implements SessionInterface
{
    /**
     * @var SessionManagerInterface
     */
    private $manager;
    private $key;
    private $hexKey;
    private $data = [];
    private $destroyed = false;

    public function __construct(SessionManagerInterface $sessionManager, string $key)
    {
        $this->key = $key;
        $this->hexKey = bin2hex($key);
        $this->manager = $sessionManager;
    }

    public function set(string $name, $value): SessionInterface
    {
        if ($this->destroyed === true)
            return $this;

        $this->data[$name] = $value;
        $this->manager->emit('update', [$this, $name]);
        return $this;
    }

    public function get(string $name, $default = null)
    {
        if ($this->destroyed === true || !$this->is($name))
            return $default;

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

    public function getHexKey(): string
    {
        return $this->hexKey;
    }

    public function getUniqueName(): string
    {
        do {
            try {
                $key = random_bytes($this->manager->getOpt(SessionManagerInterface::OPT_UNIQUE_NAME_LENGTH));
            } catch (\Exception $e) {
                throw new SessionException($e->getMessage(), SessionException::ERR_RANDOM_BYTES);
            }
        } while (isset($this->SESSION[$key]));

        return $key;
    }

    public function clean(): SessionInterface
    {
        $this->data = [];
        $this->manager->emit('clean', [$this]);
        return $this;
    }

    public function destroy()
    {
        $this->clean();
        $this->destroyed = true;
        $this->manager->emit('destroy', [$this]);
    }
}