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
     * @var string|null
     */
    public ?string $derivalTerminalName;

    /**
     * @var string|null
     */
    public ?string $arrivalTerminalName;

    /**
     * @var string|null
     */
    public ?string $derivalApiTerminalId;

    /**
     * @var string|null
     */
    public ?string $arrivalApiTerminalId;

    /**
     * @var string|null
     */
    public ?string $derivalAddressLine;

    /**
     * @var string|null
     */
    public ?string $arrivalAddressLine;

    /**
     * @var bool|null
     */
    public ?bool $derivalIsTerminal;

    /**
     * @var bool|null
     */
    public ?bool $arrivalIsTerminal;

    /**
     * @var float|null
     */
    public ?float $price;

    /**
     * @var string|null
     */
    public ?string $deliveryType;

    /**
     * @var int|null
     */
    public ?int $deliveryDays;

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
        $derivalTerminalName    = $sender['branchInfo']['name'] ?? null;
        $derivalApiTerminalId   = isset($sender['branchInfo']['id'])
            ? (string) $sender['branchInfo']['id']
            : (isset($sender['branchInfo']['bitrixId']) ? (string) $sender['branchInfo']['bitrixId'] : null);

        $arrivalCity            = $receiver['branch']['city'] ?? null;
        $arrivalTerminalAddress = $receiver['branch']['address'] ?? null;
        $arrivalTerminalName    = $receiver['branch']['name'] ?? null;
        $arrivalApiTerminalId   = isset($receiver['branch']['id'])
            ? (string) $receiver['branch']['id']
            : (isset($receiver['branch']['bitrixId']) ? (string) $receiver['branch']['bitrixId'] : null);

        // intakeAddress present only when door pickup was ordered
        $intakeAddress     = $sender['intakeAddress'] ?? null;
        $derivalIsTerminal = !empty($sender) ? empty($intakeAddress) : null;
        $arrivalIsTerminal = !empty($receiver) ? !empty($receiver['branch']) : null;

        $price        = isset($services['sum']) ? (float) $services['sum'] : null;
        $deliveryType = $info['typeOfTransportation'] ?? null;
        $deliveryDays = ($startDate && $receiveDate)
            ? (int) $startDate->diffInDays($receiveDate)
            : null;

        return new self([
            'status'                 => $status,
            'link'                   => $link,
            'startDate'              => $startDate,
            'receiveDate'            => $receiveDate,
            'derivalCity'            => $derivalCity,
            'derivalTerminalAddress' => $derivalTerminalAddress,
            'derivalTerminalName'    => $derivalTerminalName,
            'derivalApiTerminalId'   => $derivalApiTerminalId,
            'derivalAddressLine'     => $intakeAddress ?: $derivalTerminalAddress,
            'derivalIsTerminal'      => $derivalIsTerminal,
            'arrivalCity'            => $arrivalCity,
            'arrivalTerminalAddress' => $arrivalTerminalAddress,
            'arrivalTerminalName'    => $arrivalTerminalName,
            'arrivalApiTerminalId'   => $arrivalApiTerminalId,
            'arrivalAddressLine'     => $arrivalTerminalAddress,
            'arrivalIsTerminal'      => $arrivalIsTerminal,
            'price'                  => $price,
            'deliveryType'           => $deliveryType,
            'deliveryDays'           => $deliveryDays,
        ]);
    }
}
