<?php

declare(strict_types=1);

namespace SergeevPasha\Pecom\Tests\Feature\Controllers;

use Mockery;
use Illuminate\Http\JsonResponse;
use SergeevPasha\Pecom\Tests\TestCase;
use SergeevPasha\Pecom\Libraries\PecomClient;
use SergeevPasha\Pecom\Http\Controllers\PecomController;
use SergeevPasha\Pecom\Http\Requests\PecomQueryCityRequest;
use SergeevPasha\Pecom\Http\Requests\PecomCalculatePriceRequest;

class PecomControllerTest extends TestCase
{
    /**
     * Default Response.
     *
     * @var array
     */
    protected array $defaultResponse = ['text'];

    /**
     * Controller.
     *
     * @var \SergeevPasha\Pecom\Http\Controllers\PecomController
     */
    protected PecomController $controller;

    /**
     * Set Up requirements.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $client = Mockery::mock(PecomClient::class);
        $client->shouldReceive('findCity')->andReturn($this->defaultResponse);
        $client->shouldReceive('getCityTerminals')->andReturn($this->defaultResponse);
        $client->shouldReceive('getPrice')->andReturn($this->defaultResponse);
        $this->app->instance(PecomClient::class, $client);
        $this->controller = $this->app->make(PecomController::class);
    }

    public function testQueryCity()
    {
        $request = new PecomQueryCityRequest([
            'query'        => 'string',
        ]);
        $method = $this->controller->queryCity($request);
        $this->assertInstanceOf(JsonResponse::class, $method);
    }

    public function testGetCityTerminals()
    {
        $method = $this->controller->getCityTerminals(1);
        $this->assertInstanceOf(JsonResponse::class, $method);
    }

    public function testCalculateDeliveryPrice()
    {
        $request = new PecomCalculatePriceRequest([
            'arrival_city_id'                 => '1',
            'derival_city_id'                 => '2',
            'pay_date'                        => '2020-10-10',
            'arrival_address'                 => '1',
            'derival_address'                 => '0',
            'cargo'                           => [
                [
                    'length'                  => '1',
                    'width'                   => '1',
                    'height'                  => '1',
                    'weight'                  => '1',
                    'volume'                  => '0.5',
                    'max_size'                => '1',
                    'total_sealing_positions' => '1'
                ]
            ]
        ]);
        $method = $this->controller->calculateDeliveryPrice($request);
        $this->assertInstanceOf(JsonResponse::class, $method);
    }

    public function testCalculateDeliveryPriceWithService()
    {
        $request = new PecomCalculatePriceRequest([
            'arrival_city_id'  => '1',
            'derival_city_id'  => '2',
            'pay_date'         => '2020-10-10',
            'arrival_address'  => '1',
            'derival_address'  => '0',
            'derival_service'  => [
                'enabled'      => 'true',
                'floor'        => '1',
                'distance'     => '10',
                'elevator'     => 'true',
            ],
            'arrival_service'  => [
                'enabled'      => 'true',
                'floor'        => '1',
                'distance'     => '10',
                'elevator'     => 'true',
            ],
            'cargo'            => [
                [
                    'length'   => '1',
                    'width'    => '1',
                    'height'   => '1',
                    'weight'   => '1',
                    'volume'   => '0.5',
                    'max_size' => '1'
                ]
            ]
        ]);
        $method = $this->controller->calculateDeliveryPrice($request);
        $this->assertInstanceOf(JsonResponse::class, $method);
    }
}
