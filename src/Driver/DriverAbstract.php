<?php

namespace USession\Driver;

use USession\USessionInterface;
use USession\USessionManagerInterface;

abstract class DriverAbstract implements DriverInterface
{
    final public function setup(USessionManagerInterface $manager)
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

    abstract public function onCreate(USessionInterface $session);

    abstract public function onRecover(string $key, USessionManagerInterface $manager, USessionInterface &$session = null);

    abstract public function onUpdate(USessionInterface $session, string $name);

    abstract public function onClean(USessionInterface $session);

    abstract public function onDestroy(USessionInterface $session);
}