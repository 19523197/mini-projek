# Sanitize

### Introduction

Sanitize merupakan utilitas yang memudahkan Anda dalam proses sanitasi/filter data yang bertujuan untuk keamanan. Data sensitif akan digantikan dengan data hasil sanitasi untuk disimpan kedalam database sehingga data yang tersimpan dalam database tidak mengandung kata yang mudah untuk dilakukan inject DB.

### Get Started

Pastikan Anda sudah menambahkan UII Gateway Castle kedalam project Anda melalui **composer.json**. Jika belum, silakan baca dokumentasi tentang [cara menambahkan UII Gateway Castle](https://gitlab-cloud.uii.ac.id/uii-gateway/backend/castle/blob/master/README.md) terlebih dahulu.

### How To Use

Gunakan **UIIGateway\Castle\Utility\FuncSanitize** pada class yang akan menggunakan sanitasi data.
```php
<?php

namespace ....;

..
use UIIGateway\Castle\Utility\FuncSanitize;
..

```

Untuk melakukan **ENCODE** data, gunakan script berikut:
```php
..
FuncSanitize::entityEncode($dataYangInginDiSanitasi);
..
```

Untuk melakukan **DECODE** data, gunakan script berikut:
```php
..
FuncSanitize::entityEncode($dataYangTelahDiSanitasiInginDikembalikan);
..
```

### Sample of usage

Anda dapat melihat contoh penggunaan sanitasi ini pada script berikut. Pada contoh ini, script ditanam pada controller **ExampleController.php**.

ExampleController.php
``` php
<?php
namespace App\Http\Controllers;

use Carbon\Carbon;
use UIIGateway\Castle\Utility\FuncSanitize;

class ExampleController extends Controller
{
    public function sampleFunction()
    {
        $data = [
            'sampleData' => [
                'sampleVariable' => 'sampleValue',
                'uuid' => 'd72dc123-36d6-11ea-b4d2-7eb0d4a3c7a0',
                'dateTime' => Carbon::now()->format('Y-m-d H:i:s'),
                'courseName' => 'Matakuliah Progam & Struktur Data',
            ]
        ];

        $sanitized = (array) FuncSanitize::entityEncode((array) $data);
        $unsanitized = (array) FuncSanitize::entityDecode((array) $sanitized);

        return response()->json([
            'dataAsli' => $data,
            'dataEncodeAtauTersanitasi' => $sanitized,
            'dataDecodeAtauTidakDisanitasi' => $unsanitized
        ]);
    }
}
```

Response yang dikeluarkan
``` json
{
    "dataAsli": {
        "sampleData": {
            "sampleVariable": "sampleValue",
            "uuid": "d72dc123-36d6-11ea-b4d2-7eb0d4a3c7a0",
            "dateTime": "2022-02-21 11:04:16",
            "courseName": "Matakuliah Progam & Struktur Data"
        }
    },
    "dataEncodeAtauTersanitasi": {
        "sampleData": {
            "sampleVariable": "sampleValue",
            "uuid": "d72dc123-36d6-11ea-b4d2-7eb0d4a3c7a0",
            "dateTime": "2022-02-21 11:04:16",
            "courseName": "Matakuliah Progam &amp; Struktur Data"
        }
    },
    "dataDecodeAtauTidakDisanitasi": {
        "sampleData": {
            "sampleVariable": "sampleValue",
            "uuid": "d72dc123-36d6-11ea-b4d2-7eb0d4a3c7a0",
            "dateTime": "2022-02-21 11:04:16",
            "courseName": "Matakuliah Progam & Struktur Data"
        }
    }
}
```