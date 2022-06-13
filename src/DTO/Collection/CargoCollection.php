<?php

declare(strict_types=1);

namespace SergeevPasha\Pecom\DTO\Collection;

use SergeevPasha\Pecom\DTO\Cargo;
use Illuminate\Support\Collection;

class CargoCollection extends Collection
{
    /**
     * @param array $data
     *
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new static(
            array_map(fn($item) => Cargo::fromArray($item), $data)
        );
    }

    public function offsetGet($key): Cargo
    {
        return parent::offsetGet($key);
    }
}
