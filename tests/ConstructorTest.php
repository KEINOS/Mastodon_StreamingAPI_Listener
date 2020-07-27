<?php

declare(strict_types=1);

namespace KEINOS\Tests;

use KEINOS\MSTDN_TOOLS\Listener\Listener;

final class ConstructorTest extends TestCase
{
    public function testBasicUsage()
    {
        $conf = [
            'url_host' => 'https://qiitadon.com/'
        ];
        $listener = new Listener($conf);

        $count_current = 0;
        $count_max = 3;
        foreach ($listener as $key => $value) {
            if ($count_current > $count_max) {
                break;
            }

            $result_key = (($key === 'delete') || ($key === 'update'));
            $this->assertTrue($result_key, 'Key is invalid. The key was: ' . $key);
            $result_payload = (json_encode(json_decode($value)));
            $this->assertTrue((false !== $result_payload), 'Value is invalid.');
            ++$count_current;
        }
    }

    public function testCheckDefaultStreamType()
    {
        $conf = [
            'url_host' => 'https://qiitadon.com/',
        ];
        $listener = new Listener($conf);

        $expect = 'public';
        $actual = $listener->getTypeStream();

        $this->assertSame($expect, $actual);
    }

    // This test will pass but causes 255 status error in PHP7.1 and only in PHP7.1.
    // This bug was temporary handled in line:445 @ run-test.sh
    public function testFsockopenAsFalse()
    {
        $conf = [
            'url_host' => 'https://qiitadon.com/'
        ];
        $this->expectException(\Exception::class);
        $stub_listener = $this->getMockBuilder(Listener::class)
                              ->setMethods(['openSocket'])
                              ->setConstructorArgs([$conf])
                              ->getMock();
    }

    public function testSetStreamAsEmpty()
    {
        $type_stream = '';
        $conf = [
            'url_host' => 'https://qiitadon.com/',
            'type_stream' => $type_stream,
        ];
        $this->expectException(\Exception::class);
        $listener = new Listener($conf);
    }

    public function testSetStreamTypeAsLocal()
    {
        $type_stream = 'local';
        $conf = [
            'url_host' => 'https://qiitadon.com/',
            'type_stream' => $type_stream,
        ];
        $listener = new Listener($conf);

        $expect = $type_stream;
        $actual = $listener->getTypeStream();

        $this->assertSame($expect, $actual);
    }

    public function testSetStreamTypeAsPublic()
    {
        $type_stream = 'public';
        $conf = [
            'url_host' => 'https://qiitadon.com/',
            'type_stream' => $type_stream,
        ];
        $listener = new Listener($conf);

        $expect = $type_stream;
        $actual = $listener->getTypeStream();

        $this->assertSame($expect, $actual);
    }
}
