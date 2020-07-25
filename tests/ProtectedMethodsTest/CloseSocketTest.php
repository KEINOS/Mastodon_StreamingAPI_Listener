<?php

declare(strict_types=1);

namespace KEINOS\Tests;

use KEINOS\MSTDN_TOOLS\Listener\Listener;
use KEINOS\MSTDN_TOOLS\Config\Config;

final class CloseSocketTest extends TestCase
{
    public function testInvalidUrl()
    {
        // Instantiate
        $conf = [
            'url_host' => 'https://qiitadon.com/'
        ];
        $listener = new Listener($conf);

        // Get resource from instance
        $reflection_class = new \ReflectionClass('\KEINOS\MSTDN_TOOLS\Listener\Listener');
        $reflection_property = $reflection_class->getProperty('socket');
        $reflection_property->setAccessible(true);
        $resource = $reflection_property->getValue($listener);

        // Check if it's a resource
        $this->assertSame('resource', gettype($resource));

        // Close socket
        $reflected_listener = new \ReflectionMethod($listener, 'closeSocket');
        $reflected_listener->setAccessible(true);
        $reflected_listener->invoke($listener, $resource);

        // Check if it's closed
        $result = $reflection_property->getValue($listener);
        $this->assertTrue('resource' !== gettype($result));
    }
}
