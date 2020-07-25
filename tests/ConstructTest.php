<?php

declare(strict_types=1);

namespace KEINOS\Tests;

use KEINOS\MSTDN_TOOLS\Listener\Listener;

final class ConstructTest extends TestCase
{
    public function testBasicUsage()
    {
        $conf = [
            'url_host' => 'https://qiitadon.com/',
            'flag_mode_debug' => false,
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
}
