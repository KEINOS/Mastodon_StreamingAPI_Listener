<?php

declare(strict_types=1);

namespace KEINOS\Tests;

use KEINOS\MSTDN_TOOLS\Listener\Listener;

final class MethodValidTest extends TestCase
{
    public function testBasicUsage()
    {
        // Instantiate
        $conf = [
            'url_host' => 'https://qiitadon.com/'
        ];
        $listener = new Listener($conf);

        // Get opened resource from instance
        $reflection_class = new \ReflectionClass('\KEINOS\MSTDN_TOOLS\Listener\Listener');
        $reflection_property = $reflection_class->getProperty('socket');
        $reflection_property->setAccessible(true);
        $resource = $reflection_property->getValue($listener);

        // Close resource
        $reflected_method_closeSocket = new \ReflectionMethod($listener, 'closeSocket');
        $reflected_method_closeSocket->setAccessible(true);
        $reflected_method_closeSocket->invoke($listener, $resource);

        // Get Result
        $result = $listener->valid();

        $this->assertFalse($result);
    }
}
