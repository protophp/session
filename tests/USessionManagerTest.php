<?php

namespace USession\Tests;

use USession\USession;
use USession\USessionManager;

class USessionManagerTest extends \PHPUnit\Framework\TestCase
{
    public function testOpts()
    {
        $manager = new USessionManager();

        // Test defaults
        $this->assertEquals(32, $manager->getOpt(USessionManager::OPT_SESSION_KEY_LENGTH));
        $this->assertEquals(16, $manager->getOpt(USessionManager::OPT_UNIQUE_NAME_LENGTH));

        $manager->setOpt(USessionManager::OPT_SESSION_KEY_LENGTH, 64);
        $this->assertEquals(64, $manager->getOpt(USessionManager::OPT_SESSION_KEY_LENGTH));
    }

    /**
     * @throws \USession\Exception\USessionException
     */
    public function testStart()
    {
        $manager = new USessionManager();

        $session = $manager->start();
        $this->assertTrue($session instanceof USession);
    }

}
