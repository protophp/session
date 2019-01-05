<?php

namespace Proto\Session\Driver;

use Proto\Session\SessionInterface;
use Proto\Session\SessionManagerInterface;

interface DriverInterface
{
    /**
     * Setup storage
     * @param SessionManagerInterface $manager
     * @return mixed
     */
    public function setup(SessionManagerInterface $manager);

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
     * @param SessionInterface $session
     * @return void
     */
    public function onCreate(SessionInterface $session);

    /**
     * Trigger on 'recover' event
     *
     * IMPORTANT: Recovered session must be set to $session reference variable.
     * Performance note: If $session was instance of USessionInterface method must skipped.
     *
     * @param string $key
     * @param SessionManagerInterface $manager
     * @param SessionInterface|null $session
     * @return void
     */
    public function onRecover(string $key, SessionManagerInterface $manager, SessionInterface &$session = null);

    /**
     * Trigger on 'update' event
     * @param SessionInterface $session
     * @param string $name
     * @return void
     */
    public function onUpdate(SessionInterface $session, string $name);

    /**
     * Trigger on 'clean' event
     * @param SessionInterface $session
     * @return void
     */
    public function onClean(SessionInterface $session);

    /**
     * Trigger on 'destroy' event
     * @param SessionInterface $session
     * @return void
     */
    public function onDestroy(SessionInterface $session);
}