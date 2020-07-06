<?php

declare(strict_types=1);

namespace SergeevPasha\Pecom\Http\Controllers;

use Illuminate\Http\JsonResponse;
use SergeevPasha\Pecom\DTO\Delivery;
use SergeevPasha\Pecom\Libraries\PecomClient;
use SergeevPasha\Pecom\Http\Requests\PecomQueryCityRequest;
use SergeevPasha\Pecom\Http\Requests\PecomCalculatePriceRequest;

class PecomController
{
    /**
     * Pecom Client Instance.
     *
     * @var \SergeevPasha\Pecom\Libraries\PecomClient
     */
    private $client;

    public function __construct(PecomClient $client)
    {
        $this->client = $client;
    }
    
    /**
     * Query City.
     *
     * @param \SergeevPasha\Pecom\Http\Requests\PecomQueryCityRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function queryCity(PecomQueryCityRequest $request): JsonResponse
    {
        $data['data'] = $this->client->findCity($request->query('query'));
        return response()->json($data);
    }
     
    /**
     * Get city terminals.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCityTerminals(int $city): JsonResponse
    {
        $data['data'] = $this->client->getCityTerminals($city);
        return response()->json($data);
    }
    
    /**
     * Calculate delivery.
     *
     * @param \SergeevPasha\Pecom\Http\Requests\PecomCalculatePriceRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function calculateDeliveryPrice(PecomCalculatePriceRequest $request): JsonResponse
    {
        $data = $this->client->getPrice(Delivery::fromArray($request->all()));
        return response()->json($data);
    }
}
