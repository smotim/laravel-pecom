<?php

declare(strict_types=1);

namespace SergeevPasha\Pecom\DTO;

use Spatie\DataTransferObject\DataTransferObject;

class Cargo extends DataTransferObject
{
    /**
     * @var float
     */
    public float $length;

    /**
     * @var float
     */
    public float $width;

    /**
     * @var float
     */
    public float $height;

    /**
     * @var float
     */
    public float $weight;
    
    /**
     * @var float
     */
    public float $volume;
    
    /**
     * @var float
     */
    public float $maxSize;
    
    /**
     * @var bool
     */
    public bool $protectivePackage;

    /**
     * @var int
     */
    public int $totalSealingPositions;

    /**
     * @var bool
     */
    public bool $oversized;

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
            'length'                => (float) $data['length'],
            'width'                 => (float) $data['width'],
            'height'                => (float) $data['height'],
            'weight'                => (float) $data['weight'],
            'volume'                => (float) $data['volume'],
            'maxSize'               => (float) $data['max_size'],
            'protectivePackage'     => isset($data['protective_package']) ? (bool) $data['protective_package'] : false,
            'totalSealingPositions' => isset($data['total_sealing_positions']) ?
                                        (int) $data['total_sealing_positions'] :
                                        0,
            'oversized'             => isset($data['oversized']) ? (bool) $data['oversized'] : false,
        ]);
    }
}
