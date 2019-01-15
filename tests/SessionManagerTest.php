<?php

namespace Proto\Session\Tests;

use Proto\Session\Session;
use Proto\Session\SessionManager;

class SessionManagerTest extends \PHPUnit\Framework\TestCase
{
    public function testOpts()
    {
        $manager = new SessionManager();

        // Test defaults
        $this->assertEquals(32, $manager->getOpt(SessionManager::OPT_SESSION_KEY_LENGTH));
        $this->assertEquals(16, $manager->getOpt(SessionManager::OPT_UNIQUE_NAME_LENGTH));

        $manager->setOpt(SessionManager::OPT_SESSION_KEY_LENGTH, 64);
        $this->assertEquals(64, $manager->getOpt(SessionManager::OPT_SESSION_KEY_LENGTH));
    }

    /**
     * @throws \Proto\Session\Exception\SessionException
     */
    public function testStart()
    {
        $manager = new SessionManager();

        $session = $manager->start();
        $this->assertTrue($session instanceof Session);
    }

    /**
     * @throws \Proto\Session\Exception\SessionException
     */
    public function testIs()
    {
        $manager = new SessionManager();

        $session = $manager->start();
        $this->assertFalse($manager->is('blah blah blah'));
        $this->assertTrue($manager->is($session->getKey()));
    }

}
