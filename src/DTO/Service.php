<?php

declare(strict_types=1);

namespace SergeevPasha\Pecom\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class Service extends DataTransferObject
{
    /**
     * @var bool
     */
    public bool $enabled;

    /**
     * @var int|null
     */
    public ?int $floor;

    /**
     * @var int|null
     */
    public ?int $distance;

    /**
     * @var bool
     */
    public bool $hasElevator;

    /**
     * From Array.
     *
     * @param array<mixed> $data
     *
     * @return self
     */
    public static function fromArray(array $data): self
    {
        return new self([
            'enabled'     => isset($data['enabled']) ? (bool) $data['enabled'] : false,
            'floor'       => isset($data['floor']) ? (int) $data['floor'] : null,
            'distance'    => isset($data['distance']) ? (int) $data['distance'] : null,
            'hasElevator' => isset($data['elevator']) ? (bool) $data['elevator'] : false,
        ]);
    }
}
