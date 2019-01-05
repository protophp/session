<?php

namespace Proto\Session\Driver;

use Proto\Session\SessionInterface;
use Proto\Session\SessionManagerInterface;

abstract class DriverAbstract implements DriverInterface
{
    final public function setup(SessionManagerInterface $manager)
    {
        $manager->on('create', [$this, 'onCreate']);
        $manager->on('recover', [$this, 'onRecover']);
        $manager->on('update', [$this, 'onUpdate']);
        $manager->on('clean', [$this, 'onClean']);
        $manager->on('destroy', [$this, 'onDestroy']);

        $manager->on('duplicate-check', [$this, 'isDuplicateKey']);

        $this->init();
    }

    abstract protected function init();

    abstract public function isDuplicateKey(string $key, bool $isDuplicate = null);

    abstract public function onCreate(SessionInterface $session);

    abstract public function onRecover(string $key, SessionManagerInterface $manager, SessionInterface &$session = null);

    abstract public function onUpdate(SessionInterface $session, string $name);

    abstract public function onClean(SessionInterface $session);

    abstract public function onDestroy(SessionInterface $session);
}