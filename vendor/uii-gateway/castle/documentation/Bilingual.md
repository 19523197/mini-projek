# Bilingual

### Introduction

Bilingual merupakan utilitas yang memudahkan Anda untuk mengembalikan response sesuai dengan bahasa yang digunakan oleh akun user. Sehingga Anda hanya perlu melakukan terjemahan kedalam kamus indonesia dan inggris yang sudah disediakan, kemudian response akan dikembalikan sesuai dengan bahasa yang dipilih oleh user.

### Get Started

Pastikan Anda sudah menambahkan UII Gateway Castle kedalam project Anda melalui **composer.json**. Jika belum, silakan baca dokumentasi tentang [cara menambahkan UII Gateway Castle](https://gitlab-cloud.uii.ac.id/uii-gateway/backend/castle/blob/master/README.md) terlebih dahulu.

### How To Use

Gunakan **UIIGateway\Castle\Facades\Bilingual** pada class yang akan menggunakan bilingual.
```php
<?php

namespace ....;

..
use UIIGateway\Castle\Facades\Bilingual;
..

```

Contoh untuk penggunaan basic seperti berikut:
```php
..
Bilingual::translate('not found')->result(['data'=>'dosen']);
..
```

Anda dapat menambahkan terjemahan kedalam kamus lokal aplikasi. Tambahkan pada file **dictionary.php** (resources/lang/en/dictionary.php => untuk kamus inggris). Tambahkan di barisan **CUSTOM DICTIONARY**.
```php
<?php

return [
    ..
    ..
    
    /**
     *  Custom dictionary
     *
     *  Jika ada variable yang akan direplace gunakan :namaVariable, contoh pada 'ok'.
     */
    'dosen' => 'lecturer',
    'PIN' => 'PIN',
    'pegawai' => 'employees',
    'prodi' => 'study program',
    'organisasi' => 'organization',
    'fakultas' => 'faculty',
    'generasi' => 'generation',
    'periode' => 'periode',
    'ok' => ':data was successfully :aksi',
    'key kamus' => 'Translate here'
    ..
];

```

Tambahkan juga pada kamus indonesianya. Tambahkan pada file **dictionary.php** (resources/lang/id/dictionary.php => untuk kamus indonesia). Tambahkan di barisan **CUSTOM DICTIONARY**.
```php
<?php

return [
    ..
    ..
    
    /**
     *  Custom dictionary
     *
     *  Jika ada variable yang akan direplace gunakan :namaVariable, contoh pada 'ok'.
     */
    'dosen' => 'dosen',
    'PIN' => 'PIN',
    'pegawai' => 'pegawai',
    'prodi' => 'program studi',
    'organisasi' => 'organisasi',
    'fakultas' => 'fakultas',
    'generasi' => 'generasi',
    'periode' => 'periode',
    'ok' => 'Berhasil :aksi :data',
    'key kamus' => 'Terjemahkan disini'
    ..
];

```

### Continues Function Available

- **translate(string $kunciKamus)**. Translate berfungsi untuk mencari translasi pada kamu yang telah Anda definisikan. Sehingga pada translate ini Anda harus melemparkan key/kunci untuk mengambil hasil translasi kamu.
- **result(array $dataYangDireplace)**. Result berfungsi untuk melakukan replace variable dinamis yang telah didefinisikan pada kamus (:variable). 

### Sample Of Usage

Anda dapat melihat contoh penggunaan bilingual lainnya pada script berikut. Pada contoh ini, script ditanam pada controller **ExampleController.php**.

ExampleController.php
``` php
<?php
namespace App\Http\Controllers;

use UIIGateway\Castle\Facades\Bilingual;

class ExampleController extends Controller
{
    public function sampleFunction()
    {
        $translate1 = Bilingual::translate('dosen')->result();
        // Response:
        // Indonesia = dosen
        // Inggris = lecturer

        $translate2 = Bilingual::translate('not found')->result(['data'=>'mahasiswa']);
        // Response:
        // Indonesia = Mahasiswa tidak ditemukan
        // Inggris = Students not found

        $translate3 = Bilingual::translate('ok')->result(['data'=>'mahasiswa', 'aksi' => 'generate']);
        // Response:
        // Indonesia = Berhasil generate mahasiswa
        // Inggris = Students was successfully generate
    }
}
```
