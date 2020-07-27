<?php

declare(strict_types=1);

namespace KEINOS\Tests;

use KEINOS\MSTDN_TOOLS\Listener\Listener;
use KEINOS\MSTDN_TOOLS\Config\Config;

final class GenerateRequestApiStreamingTest extends TestCase
{
    public function testMinimumSettings()
    {
        $conf = [
            'url_host' => 'https://qiitadon.com/'
        ];
        $listener = new Listener($conf);
        $config   = new Config($conf);

        $reflected_listener = new \ReflectionMethod($listener, 'generateRequestApiStreaming');
        $reflected_listener->setAccessible(true);

        $actual = $reflected_listener->invokeArgs($listener, [$config]);
        $expect = implode("\r\n", [
            'GET /api/v1/streaming/public HTTP/1.1',
            'Host: qiitadon.com',
            'User-Agent: MSTDN_TOOLS/1.0 mastodon-streaming-api-listener',
            '',
            '',
        ]);

        $this->assertSame($expect, $actual);
    }

    public function testStreamTypeAsLocal()
    {
        $conf = [
            'url_host' => 'https://qiitadon.com/',
            'type_stream' => 'local',
        ];
        $listener = new Listener($conf);
        $config   = new Config($conf);

        $reflected_listener = new \ReflectionMethod($listener, 'generateRequestApiStreaming');
        $reflected_listener->setAccessible(true);

        $actual = $reflected_listener->invokeArgs($listener, [$config]);
        $expect = implode("\r\n", [
            'GET /api/v1/streaming/public/local HTTP/1.1',
            'Host: qiitadon.com',
            'User-Agent: MSTDN_TOOLS/1.0 mastodon-streaming-api-listener',
            '',
            '',
        ]);

        $this->assertSame($expect, $actual);
    }

    public function testUnexpectedUrl()
    {
        $conf = [
            'url_host' => 'https://qiitadon.com/'
        ];
        $listener = new Listener($conf);

        $reflected_listener = new \ReflectionMethod($listener, 'generateRequestApiStreaming');
        $reflected_listener->setAccessible(true);

        $stub_conf = $this->createMock(Config::class);
        $stub_conf->method('getUrlHost')->willReturn('hoge');

        $this->expectException(\Exception::class);
        $reflected_listener->invoke($listener, $stub_conf);
    }
}
