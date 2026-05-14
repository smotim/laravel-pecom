<?php

declare(strict_types=1);

namespace SergeevPasha\Pecom\DTO;

use Carbon\Carbon;
use Spatie\DataTransferObject\DataTransferObject;

class PecomTrack extends DataTransferObject
{
    /**
     * @var string|null
     */
    public ?string $status;

    /**
     * @var string
     */
    public string $link;

    /**
     * @var \Carbon\Carbon|null
     */
    public ?Carbon $startDate;

    /**
     * @var \Carbon\Carbon|null
     */
    public ?Carbon $receiveDate;

    /**
     * @var string|null
     */
    public ?string $derivalCity;

    /**
     * @var string|null
     */
    public ?string $derivalTerminalAddress;

    /**
     * @var string|null
     */
    public ?string $arrivalCity;

    /**
     * @var string|null
     */
    public ?string $arrivalTerminalAddress;

    /**
     * @var float|null
     */
    public ?float $price;

    /**
     * From Array.
     *
     * @param array $data
     *
     * @return self
     * @throws \Spatie\DataTransferObject\Exceptions\UnknownProperties
     */
    public static function fromArray(array $data): self
    {
        $cargo    = $data['cargos'][0] ?? [];
        $info     = $cargo['info'] ?? [];
        $sender   = $cargo['sender'] ?? [];
        $receiver = $cargo['receiver'] ?? [];
        $services = $cargo['services'] ?? [];

        $status  = $info['cargoStatus'] ?? null;
        $orderId = $cargo['cargo']['code'] ?? '';
        $link    = $orderId ? 'https://pecom.ru/services-are/order-status/?code=' . $orderId : '';

        $startDate = isset($info['takeOnStockDateTime'])
            ? Carbon::parse($info['takeOnStockDateTime'])
            : null;

        $receiveDate = isset($info['receivedByClientDateTime'])
            ? Carbon::parse($info['receivedByClientDateTime'])
            : (isset($info['giveOutDateTime'])
                ? Carbon::parse($info['giveOutDateTime'])
                : null);

        $derivalCity            = $sender['branchInfo']['city'] ?? null;
        $derivalTerminalAddress = $sender['branchInfo']['address'] ?? null;
        $arrivalCity            = $receiver['branch']['city'] ?? null;
        $arrivalTerminalAddress = $receiver['branch']['address'] ?? null;

        $price = isset($services['sum']) ? (float) $services['sum'] : null;

        return new self([
            'status'                => $status,
            'link'                  => $link,
            'startDate'             => $startDate,
            'receiveDate'           => $receiveDate,
            'derivalCity'           => $derivalCity,
            'derivalTerminalAddress' => $derivalTerminalAddress,
            'arrivalCity'           => $arrivalCity,
            'arrivalTerminalAddress' => $arrivalTerminalAddress,
            'price'                 => $price,
        ]);
    }
}
