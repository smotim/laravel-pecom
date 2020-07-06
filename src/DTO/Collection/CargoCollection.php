<?php

declare(strict_types=1);

namespace SergeevPasha\Pecom\DTO\Collection;

use SergeevPasha\Pecom\DTO\Cargo;
use Spatie\DataTransferObject\DataTransferObjectCollection;

final class CargoCollection extends DataTransferObjectCollection
{
    public function current(): Cargo
    {
        return parent::current();
    }

    /**
     * @param array<mixed> $data
     *
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new static(
            array_map(fn($item) => Cargo::fromArray($item), $data)
        );
    }
}
