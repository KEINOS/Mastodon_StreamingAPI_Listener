<?php

declare(strict_types=1);

namespace KEINOS\Tests;

use KEINOS\MSTDN_TOOLS\Listener\Listener;
use KEINOS\MSTDN_TOOLS\Config\Config;

final class OpenSocketTest extends TestCase
{
    public function testInvalidUrl()
    {
        $conf = [
            'url_host' => 'https://qiitadon.com/'
        ];
        $listener = new Listener($conf);

        $reflected_listener = new \ReflectionMethod($listener, 'openSocket');
        $reflected_listener->setAccessible(true);

        $stub_conf = $this->createMock(Config::class);
        $stub_conf->method('getUriStreamingApi')->willReturn('hoge');

        $this->expectException(\Exception::class);
        $resource = $reflected_listener->invoke($listener, $stub_conf);
    }
}
