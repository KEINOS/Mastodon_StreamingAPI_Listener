<?php

declare(strict_types=1);

namespace KEINOS\Tests;

use KEINOS\MSTDN_TOOLS\Listener\Listener;

final class EchoOnDebugTest extends TestCase
{
    public function testDebugModeOn()
    {
        $conf = [
            'url_host'   => 'https://qiitadon.com/',
            'flag_mode_debug' => true,
        ];
        $listener = new Listener($conf);

        $method_protected = new \ReflectionMethod($listener, 'echoOnDebug');
        $method_protected->setAccessible(true);
        $dummy = hash('md5', strval(mt_rand()));

        $expect = $dummy . PHP_EOL;
        $this->expectOutputString($expect);
        $method_protected->invokeArgs($listener, [$dummy]);
    }

    public function testDebugModeOff()
    {
        $conf = [
            'url_host' => 'https://qiitadon.com/'
        ];
        $listener = new Listener($conf);

        $method_protected = new \ReflectionMethod($listener, 'echoOnDebug');
        $method_protected->setAccessible(true);
        $dummy = hash('md5', strval(mt_rand()));

        $expect = '';
        $this->expectOutputString($expect);
        $method_protected->invokeArgs($listener, [$dummy]);
    }
}
