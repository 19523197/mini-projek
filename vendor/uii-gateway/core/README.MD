# UII Gateway Core Lumen

#### _Core sistem dengan gaya Lumen BSI_

[![UII Gateway Logo](https://gateway-dev.uii.ac.id/assets/images/loader/loader.gif)](https://gateway-dev.uii.ac.id/assets/images/loader/loader.gif)

UII Gateway Core Lumen merupakan package/library untuk memudahkan proses installasi dan configurasi boilerplate lumen dengan gaya yang ada di Badan Sistem Informasi UII.

## Features

- Configurasi dan installasi project baru
- Installasi feature MVP (Minimum Viable Prooduct)

## Tech

Bekerja dengan baik untuk teknologi/framework Lumen dan Laravel

[![Lumen Logo](https://cdn-cjido.nitrocdn.com/OWBpPGhVFQSOSTFJpSSOzqWMqrFnKYbA/assets/static/optimized/rev-87f57cb/wp-content/uploads/2020/03/laravel-lumen.png)](https://cdn-cjido.nitrocdn.com/OWBpPGhVFQSOSTFJpSSOzqWMqrFnKYbA/assets/static/optimized/rev-87f57cb/wp-content/uploads/2020/03/laravel-lumen.png)

## Get Started

Untuk memulai menggunakan library ini, pastikan Anda menggunakan package/library ini hanya untuk aplikasi dengan environment yang ada di BSI (Package/library ini mungkin tidak bisa berjalan jika berbeda environment). 

Pastikan Anda sudah melakukan clone repository [boilerplate lumen BSI.](https://gitlab-cloud.uii.ac.id/academic/backend/svc-academic-boilerplate-lumen) Jika Anda belum clone repositori boilerplate tersebut, silakan clone dengan script dibawah (PASTIKAN ANDA MENGUBAH _**<NAMA_TEAM>**_ DAN _**<NAMA_APLIKASI>**_ SESUAI DENGAN _**NAMA TIM**_ ANDA DAN _**NAMA APLIKASI**_ YANG AKAN ANDA BANGUN => Contoh: svc-academic-ras-lumen)

Clone dengan SSH
```sh
git clone git@gitlab-cloud.uii.ac.id:academic/backend/svc-academic-boilerplate-lumen.git svc-<NAMA_TEAM>-<NAMA_APLIKASI>-lumen
```

Clone dengan HTTPS
```sh
git clone https://gitlab-cloud.uii.ac.id/academic/backend/svc-academic-boilerplate-lumen.git svc-<NAMA_TEAM>-<NAMA_APLIKASI>-lumen
```

Selain itu, **pastikan Anda sudah memiliki database beserta user database** untuk aplikasi ini baik di environment **DEVELOP, STAGGING, maupun PRODUCTION**.

## Installation

1. Pastikan Anda sudah membuka folder boilerplate (yang telah Anda clone) pada text editor milik Anda.

2. Tambahkan script berikut pada object **repositories** dan **require** yang ada pada file **composer.json**
``` json
{
  "repositories": [
        {
            "type": "git",
            "url": "git@gitlab-cloud.uii.ac.id:academic/backend/core.git"
        }
    ],
    "require": {
        "uii-gateway/core": "^1.0.3"
    },
}
```

3. Tambahkan script berikut pada file **bootstrap/app.php**
``` php
$app->register(UIIGateway\Core\UIIGatewayServiceProvider::class);
``` 

4. Lakukan installasi composer dengan cara
```sh
composer install
```

5. Jika proses composer install sudah selesai, maka pada folder vendor sudah tersedia **uii-gateway/core** (vendor/uii-gateway)


## How to use

Pada package/library ini terdapat 2 magic command dengan 2 tujuan yang berbeda, yaitu magic command untuk melakukan konfigurasi aplikasi dan magic command untuk melakukan installasi fitur MVP (Fitur dengan pattern yang harus ada).
Namun yang **harus Anda lakukan pertama adalah melakukan instalasi dan konfigurasi aplikasi**. Ikuti langkah berikut:

1. Lakukan instalasi dan konfigurasi aplikasi dengan menjalankan perintah berikut, kemudian silakan isikan sesuai dengan kebutuhan aplikasi Anda.
```sh
php artisan generate:app
```

2. Lakukan instalasi fitur MVP (pattern untuk membuat fitur yang harus ada), kemudian silakan isikan sesuai dengan kebutuhan fitur yang akan Anda buat.
```sh
php artisan generate:mvp
```

3. Proses nomor 2 dapat Anda ulangi setiap kali Anda ingin membuat fitur baru, sehingga Anda tidak perlu repot-repot membuat file dan folder secara manual.

## Maintainers

* Bamasatya H <bamasatyaproject@gmail.com>
* Nabil Muhammad Firdaus <211232629@uii.ac.id>