<?php

namespace Proto\Session\Tests;

use PHPUnit\Framework\TestCase;
use Proto\Session\SessionManager;

class SessionTest extends TestCase
{
    /**
     * @throws \Proto\Session\Exception\SessionException
     */
    public function testUSession()
    {
        $manager = new SessionManager();
        $session = $manager->start();

        $this->assertEquals($manager->getOpt(SessionManager::OPT_SESSION_KEY_LENGTH), strlen($session->getKey()));
        $this->assertEquals($manager->getOpt(SessionManager::OPT_UNIQUE_NAME_LENGTH), strlen($session->getUniqueName()));

        // No exists data
        $this->assertFalse($session->is('sample'));
        $this->assertNull($session->get('sample'));
        $this->assertEquals(500, $session->get('sample', 500));     // default test

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