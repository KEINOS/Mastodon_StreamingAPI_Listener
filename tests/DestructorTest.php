<?php

declare(strict_types=1);

namespace KEINOS\Tests;

use KEINOS\MSTDN_TOOLS\Listener\Listener;

final class DestructorTest extends TestCase
{
    public function testDestruct()
    {
        $conf = [
            'url_host' => 'https://qiitadon.com/'
        ];
        $listener = new Listener($conf);
        unset($listener);

        $this->assertFalse(isset($listener));
    }
}
