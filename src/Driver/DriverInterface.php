<?php

namespace USession\Driver;

use USession\USessionInterface;
use USession\USessionManagerInterface;

interface DriverInterface
{
    /**
     * Setup storage
     * @param USessionManagerInterface $manager
     * @return mixed
     */
    public function setup(USessionManagerInterface $manager);

    /**
     * Check binary key is duplicate or not.
     *
     * Performance note: If $isDuplicate was true method must skipped.
     *
     * @param string $key Binary key
     * @param bool|null $isDuplicate
     * @return void
     */
    public function isDuplicateKey(string $key, bool $isDuplicate = null);

    /**
     * Trigger on 'create' event
     * @param USessionInterface $session
     * @return void
     */
    public function onCreate(USessionInterface $session);

    /**
     * Trigger on 'recover' event
     *
     * IMPORTANT: Recovered session must be set to $session reference variable.
     * Performance note: If $session was instance of USessionInterface method must skipped.
     *
     * @param string $key
     * @param USessionManagerInterface $manager
     * @param USessionInterface|null $session
     * @return void
     */
    public function onRecover(string $key, USessionManagerInterface $manager, USessionInterface &$session = null);

    /**
     * Trigger on 'update' event
     * @param USessionInterface $session
     * @param string $name
     * @return void
     */
    public function onUpdate(USessionInterface $session, string $name);

    /**
     * Trigger on 'clean' event
     * @param USessionInterface $session
     * @return void
     */
    public function onClean(USessionInterface $session);

    /**
     * Trigger on 'destroy' event
     * @param USessionInterface $session
     * @return void
     */
    public function onDestroy(USessionInterface $session);
}