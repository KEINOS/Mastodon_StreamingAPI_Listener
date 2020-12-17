<?php

declare(strict_types=1);

namespace KEINOS\Tests;

use KEINOS\MSTDN_TOOLS\Listener\Listener;
use KEINOS\MSTDN_TOOLS\Config\Config;

final class TreatWarningAsExceptionTest extends TestCase
{
    public function testTriggerWarningAsException()
    {
        $listener = new Listener([
            'url_host' => 'https://qiitadon.com/'
        ]);
        $this->expectException(\ErrorException::class);
        trigger_error('MyWarning', \E_USER_WARNING);
    }

    public function testTriggerErrorButPassThrough()
    {
        $listener = new Listener([
            'url_host' => 'https://qiitadon.com/'
        ]);
        $this->expectException(\ErrorException::class);
        trigger_error('MyWarning', \E_USER_WARNING);
    }

    /**
     * @doesNotPerformAssertions
     */
    public function testErrorReportingAsZero()
    {
        $listener = new Listener([
            'url_host' => 'https://qiitadon.com/'
        ]);
        error_reporting(0);
        trigger_error('MyWarning', \E_USER_WARNING);
    }
}
