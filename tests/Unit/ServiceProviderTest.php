<?php

declare(strict_types=1);

namespace SergeevPasha\Pecom\Tests\Unit;

use SergeevPasha\Pecom\Tests\TestCase;
use SergeevPasha\Pecom\Providers\PecomServiceProvider;

class ServiceProviderTest extends TestCase
{
    public function testServiceProvider(): void
    {
        $service = new PecomServiceProvider($this->app);
        $this->assertNull($service->register());
        $this->assertNull($service->boot());
    }
}
