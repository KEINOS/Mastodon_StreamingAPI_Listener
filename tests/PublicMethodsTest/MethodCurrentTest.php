<?php

declare(strict_types=1);

namespace KEINOS\Tests;

use KEINOS\MSTDN_TOOLS\Listener\Listener;

final class MethodCurrentTest extends TestCase
{
    public function testBasicUsage()
    {
        $conf = [
            'url_host' => 'https://qiitadon.com/'
        ];
        $stub_listener = $this->getMockBuilder(Listener::class)
                              ->setMethods(['getEventAsJson'])
                              ->setConstructorArgs([$conf])
                              ->getMock();
        $stub_listener->method('getEventAsJson')
                      ->willReturn('{"event":"hoge","payload":"fuga"}');

        $expect = '["fuga"]';
        $actual = $stub_listener->current();
        $this->assertSame($expect, $actual);
    }

    public function testMissingEvent()
    {
        $conf = [
            'url_host' => 'https://qiitadon.com/'
        ];
        $stub_listener = $this->getMockBuilder(Listener::class)
                              ->setMethods(['getEventAsJson'])
                              ->setConstructorArgs([$conf])
                              ->getMock();
        $stub_listener->method('getEventAsJson')
                      ->willReturn('{"payload":"fuga"}');

        $expect = '';
        $actual = $stub_listener->current();
        $this->assertSame($expect, $actual);
    }

    public function testMissingPayload()
    {
        $conf = [
            'url_host' => 'https://qiitadon.com/'
        ];
        $stub_listener = $this->getMockBuilder(Listener::class)
                              ->setMethods(['getEventAsJson'])
                              ->setConstructorArgs([$conf])
                              ->getMock();
        $stub_listener->method('getEventAsJson')
                      ->willReturn('{"event":"hoge"}');

        $expect = '';
        $actual = $stub_listener->current();
        $this->assertSame($expect, $actual);
    }
}
