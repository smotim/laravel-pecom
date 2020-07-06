<?php

declare(strict_types=1);

namespace SergeevPasha\Pecom\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PecomQueryCityRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<mixed>
     */
    public function rules(): array
    {
        return [
            'query' => ['required', 'string'],
        ];
    }
}
