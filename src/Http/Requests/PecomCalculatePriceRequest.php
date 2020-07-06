<?php

declare(strict_types=1);

namespace SergeevPasha\Pecom\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PecomCalculatePriceRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<mixed>
     */
    public function rules(): array
    {
        return [
            'arrival_city_id'                 => ['required', 'integer'],
            'derival_city_id'                 => ['required', 'integer'],
            'arrival_open_car'                => ['sometimes', 'required', 'boolean'],
            'derival_open_car'                => ['sometimes', 'required', 'boolean'],
            'arrival_distance_type'           => ['sometimes', 'required', 'integer'],
            'derival_distance_type'           => ['sometimes', 'required', 'integer'],
            'one_day_delivery'                => ['sometimes', 'required', 'boolean'],
            'is_shop'                         => ['sometimes', 'required', 'boolean'],
            'pay_date'                        => ['required', 'date_format:Y-m-d'],
            'require_insurance'               => ['sometimes', 'required', 'boolean'],
            'insurance_price'                 => ['sometimes', 'required', 'numeric'],
            'arrival_address'                 => ['required', 'boolean'],
            'derival_address'                 => ['required', 'boolean'],
            'arrival_service.enabled'         => ['sometimes', 'required', 'boolean'],
            'arrival_service.floor'           => ['sometimes', 'required', 'integer'],
            'arrival_service.distance'        => ['sometimes', 'required', 'integer'],
            'arrival_service.elevator'        => ['sometimes', 'required', 'boolean'],
            'derival_service.enabled'         => ['sometimes', 'required', 'boolean'],
            'derival_service.floor'           => ['sometimes', 'required', 'integer'],
            'derival_service.distance'        => ['sometimes', 'required', 'integer'],
            'derival_service.elevator'        => ['sometimes', 'required', 'boolean'],
            'cargo'                           => ['required', 'array'],
            'cargo.*.length'                  => ['required_with:cargo', 'numeric'],
            'cargo.*.width'                   => ['required_with:cargo', 'numeric'],
            'cargo.*.height'                  => ['required_with:cargo', 'numeric'],
            'cargo.*.weight'                  => ['required_with:cargo', 'numeric'],
            'cargo.*.volume'                  => ['required_with:cargo', 'numeric'],
            'cargo.*.max_size'                => ['required_with:cargo', 'numeric'],
            'cargo.*.protective_package'      => ['sometimes', 'required', 'boolean'],
            'cargo.*.total_sealing_positions' => ['sometimes', 'required', 'integer'],
            'cargo.*.oversized'               => ['sometimes', 'required', 'boolean'],
        ];
    }
}
