<?php

namespace USession\Tests;

use PHPUnit\Framework\TestCase;
use USession\USessionManager;

class USessionTest extends TestCase
{
    /**
     * @throws \USession\Exception\USessionException
     */
    public function testUSession()
    {
        $manager = new USessionManager();
        $session = $manager->start();

        $this->assertEquals($manager->getOpt(USessionManager::OPT_SESSION_KEY_LENGTH), strlen($session->getKey()));
        $this->assertEquals($manager->getOpt(USessionManager::OPT_UNIQUE_NAME_LENGTH), strlen($session->getUniqueName()));

        // No exists data
        $this->assertFalse($session->is('sample'));
        $this->assertNull($session->get('sample'));

        // Add data
        $session->set('sample', 'TEST');
        $session->set('std', new \stdClass());
        $this->assertSame('TEST', $session->get('sample'));
        $this->assertTrue($session->get('std') instanceof \stdClass);

        $cSession = clone $session;

        ////////////////////////////
        /// Clean cloned session ///
        ////////////////////////////
        $cSession->clean();
        $this->assertFalse($cSession->is('sample'));
        $this->assertNull($cSession->get('sample'));

        // Add data
        $session->set('sample', 'TEST');
        $this->assertSame('TEST', $session->get('sample'));

        ////////////////////////
        /// Destroy session! ///
        ////////////////////////
        $session->destroy();

        // Data must be cleaned
        $this->assertFalse($cSession->is('sample'));
        $this->assertNull($session->get('sample'));

        // Data can't be added when the session destroyed.
        $session->set('sample', 'TEST');
        $this->assertFalse($session->is('sample'));
        $this->assertNull($session->get('sample'));
    }
}