# UII Gateway Boilerplate Backend Lumen

#### _"Create something valuable"_

[![UII Gateway Logo](https://gateway-dev.uii.ac.id/assets/images/loader/loader.gif)](https://gateway-dev.uii.ac.id/assets/images/loader/loader.gif)

UII Gateway Boilerplate Backend Lumen merupakan template penyusun yang memudahkan Anda dalam mengembangkan aplikasi.

## Features

- Boilerplate awal penyusun aplikasi

## Tech

Bekerja dengan baik untuk teknologi/framework Lumen dan Laravel

[![Lumen Logo](https://fiverr-res.cloudinary.com/images/t_main1,q_auto,f_auto,q_auto,f_auto/gigs/136508568/original/28a8514e644289bb301085a61e844b0fe0e8ecc4/create-rest-api-in-lumen-laravel-or-custom-php-4737.png)](https://fiverr-res.cloudinary.com/images/t_main1,q_auto,f_auto,q_auto,f_auto/gigs/136508568/original/28a8514e644289bb301085a61e844b0fe0e8ecc4/create-rest-api-in-lumen-laravel-or-custom-php-4737.png)

## Get Started

Bacalah basmallah terlebih dahulu.

## Installation

1. Silakan Anda clone repository ini terlebih dahulu. Terdapat 2 cara untuk clone, menggunakan SSH dan HTTPS, silakan pilih salah satu. Berikut script yang bisa Anda gunakan untuk clone: (PASTIKAN ANDA MENGUBAH **<NAMA_TEAM>** DAN **<NAMA_APLIKASI>** SESUAI DENGAN NAMA TIM ANDA DAN NAMA APLIKASI YANG AKAN ANDA BANGUN => Contoh: svc-academic-ras-lumen)

- Clone dengan SSH
```sh
git clone git@gitlab-cloud.uii.ac.id:uii-gateway/backend/svc-boilerplate-lumen.git svc-<NAMA_TEAM>-<NAMA_APLIKASI>-lumen
```

- Clone dengan HTTPS
```sh
git clone https://gitlab-cloud.uii.ac.id/uii-gateway/backend/svc-boilerplate-lumen.git svc-<NAMA_TEAM>-<NAMA_APLIKASI>-lumen
```

2. Tambahkan repository untuk library UII Gateway Foundation dan UII Gateway Castle pada file **composer.json** (tambahkan pada object **repositories** dan **require**). Langkah ini bersifat opsional, jika belum ada script berikut pada **composer.json**, maka Anda wajib melakukan langkah ini, namun jika sudah ada, maka silakan Anda lanjutkan ke langkah berikutnya.

```json
{
  "repositories": [
        {
            "type": "git",
            "url": "git@gitlab-cloud.uii.ac.id:uii-gateway/backend/foundation.git"
        },
        {
            "type": "git",
            "url": "git@gitlab-cloud.uii.ac.id:uii-gateway/backend/castle.git"
        }
    ],
    "require": {
        "uii-gateway/foundation": "^0.0.1",
        "uii-gateway/castle": "^0.0.1"
    },
}
```

3. Daftarkan kedua library diatas dengan cara menambahkan script berikut pada file **bootstrap/app.php**.  Langkah ini bersifat opsional, jika belum ada script berikut pada **bootstrap/app.php**, maka Anda wajib melakukan langkah ini, namun jika sudah ada, maka silakan Anda lanjutkan ke langkah berikutnya.

```php
$app->register(UIIGateway\Foundation\UIIGatewayServiceProvider::class);
$app->register(UIIGateway\Castle\ServiceProvider::class);
```

4. Lakukan installasi/update composer dengan cara:
 
```sh
composer update
```

5. Jika proses composer install sudah selesai, maka pada folder vendor sudah tersedia uii-gateway/foundation (vendor/uii-gateway)

6. Selanjutnya, silakan Anda lakukan instalasi dan konfigurasi aplikasi dengan menjalankan perintah berikut, kemudian silakan isikan sesuai dengan kebutuhan aplikasi Anda.

```sh
php artisan generate:app
```

7. Generate MVP flow (pattern untuk membuat fitur yang harus ada) dari fitur Anda dengan script berikut, kemudian silakan isikan sesuai dengan kebutuhan fitur yang akan Anda buat.

```sh
php artisan generate:mvp
```

## Another documentation may you need

- UII GATEWAY CASTLE => Akses dokumentasi Castle [disini](https://gitlab-cloud.uii.ac.id/uii-gateway/backend/castle).
- UII GATEWAY FOUNDATION => Akses dokumentasi Core [disini](https://gitlab-cloud.uii.ac.id/uii-gateway/backend/foundation).

## Maintainers

* Bamasatya H <201232636@uii.ac.id>
* Nabil Muhammad Firdaus <211232629@uii.ac.id>
* Hibbatur Rizqo Widodo <21005119@uii.ac.id>
