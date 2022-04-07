<?php

namespace UIIGateway\Castle\ValueObject;

use UIIGateway\Castle\Base\Enum;

final class StatusMahasiswa extends Enum
{
    public const AKTIF = 'A';
    public const NON_AKTIF = 'B';
    public const CUTI = 'C';
    public const DROP_OUT = 'D';
    public const KELUAR = 'K';
    public const LULUS = 'L';
    public const MENINGGAL = 'M';
    public const OUT = 'O';
    public const PASSING_OUT = 'P';
    public const UNDUR_DIRI = 'U';
    public const PERINGATAN_DO = '3';

    public static function getLocalizationkey(): string
    {
        return 'castle::enums.' . StatusMahasiswa::class;
    }
}
