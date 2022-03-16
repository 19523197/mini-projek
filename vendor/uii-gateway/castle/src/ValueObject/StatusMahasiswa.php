<?php

namespace UIIGateway\Castle\ValueObject;

use UIIGateway\Castle\Base\Enum;

final class StatusMahasiswa extends Enum
{
    const AKTIF = 'A';
    const NON_AKTIF = 'B';
    const CUTI = 'C';
    const DROP_OUT = 'D';
    const KELUAR = 'K';
    const LULUS = 'L';
    const MENINGGAL = 'M';
    const OUT = 'O';
    const PASSING_OUT = 'P';
    const UNDUR_DIRI = 'U';
    const PERINGATAN_DO = '3';
}
