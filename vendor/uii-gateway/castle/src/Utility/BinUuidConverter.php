<?php

namespace UIIGateway\Castle\Utility;

use Throwable;
use UIIGateway\Castle\Exceptions\BinaryToUuidException;
use UIIGateway\Castle\Exceptions\UuidToBinaryException;

class BinUuidConverter
{
    public static function binToUuid(string $value)
    {
        try {
            return join(
                '-',
                unpack("H8time_low/H4time_mid/H4time_hi/H4clock_seq_hi/H12clock_seq_low", $value)
            );
        } catch (Throwable $e) {
            throw new BinaryToUuidException();
        }
    }

    public static function uuidToBin(string $value)
    {
        try {
            return pack("H*", str_replace('-', '', $value));
        } catch (Throwable $e) {
            throw new UuidToBinaryException();
        }
    }
}
