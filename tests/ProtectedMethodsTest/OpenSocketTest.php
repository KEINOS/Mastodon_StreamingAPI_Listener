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

    public function testInvalidHost()
    {
        $conf = [
            'url_host' => 'https://qiitadon.com/'
        ];
        $listener = new Listener($conf);

        $reflected_listener = new \ReflectionMethod($listener, 'openSocket');
        $reflected_listener->setAccessible(true);

        $stub_conf  = $this->createMock(Config::class);
        $host_dummy = hash('md5', strval(mt_rand()));
        $url_dummy  = "http://${host_dummy}.com/v1/something/";
        $stub_conf->method('getUriStreamingApi')->willReturn($url_dummy);

        $this->expectException(\Exception::class);
        $resource = $reflected_listener->invoke($listener, $stub_conf);
    }
}
