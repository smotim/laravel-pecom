<?php

declare(strict_types=1);

namespace SergeevPasha\Pecom\Tests\Unit;

use ReflectionMethod;
use SergeevPasha\Pecom\Tests\TestCase;
use SergeevPasha\Pecom\Libraries\PecomClient;
use SergeevPasha\Pecom\DTO\Collection\CargoCollection;

class PecomClientTest extends TestCase
{
    public function testBuildCargo(): void
    {
        $cargo = CargoCollection::fromArray([
            [
                'length'   => '1',
                'width'    => '1',
                'height'   => '1',
                'weight'   => '1',
                'volume'   => '0.5',
                'max_size' => '1'
            ]
        ]);
        $expected = [
            [
                'length'                => 1,
                'width'                 => 1,
                'height'                => 1,
                'volume'                => 0.5,
                'maxSize'               => 1,
                'isHP'                  => false,
                'sealingPositionsCount' => 0,
                'weight'                => 1,
                'overSize'              => false,
            ]
        ];
        $method = new ReflectionMethod(PecomClient::class, 'buildCargo');
        $method->setAccessible(true);
        $client = new PecomClient('login', 'key');
        $result = $method->invokeArgs($client, array($cargo));
        $this->assertEqualsCanonicalizing(
            $expected,
            $result
        );
    }
}
