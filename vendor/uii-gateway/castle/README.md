# UII Gateway Castle

#### _"Kumpulan utilitas untuk microservice berbasis Lumen di BSI UII"_

[![UII Gateway Logo](https://gateway-dev.uii.ac.id/assets/images/loader/loader.gif)](https://gateway-dev.uii.ac.id/assets/images/loader/loader.gif)

UII Gateway Castle Lumen merupakan package/library yang menyimpan berbagai utilitas untuk memudahkan pekerjaan Anda dalam membangun aplikasi/website menggunakan framework Lumen.

## Features

- [Sanitize](https://gitlab-cloud.uii.ac.id/uii-gateway/backend/castle/blob/develop/documentation/Sanitize.md)
- [Bilingual](https://gitlab-cloud.uii.ac.id/uii-gateway/backend/castle/blob/develop/documentation/Bilingual.md)

## Tech

Bekerja dengan baik untuk framework Lumen

[![Lumen Logo](https://fiverr-res.cloudinary.com/images/t_main1,q_auto,f_auto,q_auto,f_auto/gigs/136508568/original/28a8514e644289bb301085a61e844b0fe0e8ecc4/create-rest-api-in-lumen-laravel-or-custom-php-4737.png)](https://fiverr-res.cloudinary.com/images/t_main1,q_auto,f_auto,q_auto,f_auto/gigs/136508568/original/28a8514e644289bb301085a61e844b0fe0e8ecc4/create-rest-api-in-lumen-laravel-or-custom-php-4737.png)

## Get Started

Untuk memulai menggunakan library ini, pastikan Anda menggunakan package/library ini hanya untuk aplikasi dengan environment yang ada di BSI (Package/library ini mungkin tidak bisa berjalan jika berbeda environment). 

Pastikan Anda sudah melakukan clone repository [boilerplate lumen BSI.](https://gitlab-cloud.uii.ac.id/uii-gateway/backend/svc-boilerplate-lumen) Jika Anda belum clone repositori boilerplate tersebut, silakan ikuti langkah installasi boilerplate tersebut sesuai dengan [dokumentasi cara instal boilerplate.](https://gitlab-cloud.uii.ac.id/uii-gateway/backend/svc-boilerplate-lumen/blob/develop/README.md)

Perlu diperhatikan, packages ini akan berjalan lancar untuk existing project. Jika Anda ingin mengimplementasikan pada project yang sudah berjalan, diperlukan konfigurasi khusus agar packages ini dapat berjalan dengan lancar.

## Installation

1. Pastikan Anda sudah membuka folder boilerplate (yang telah Anda clone) pada text editor milik Anda.

2. Tambahkan script berikut pada object **repositories** dan **require** yang ada pada file **composer.json**
``` json
{
  "repositories": [
        {
            "type": "git",
            "url": "git@gitlab-cloud.uii.ac.id:uii-gateway/backend/castle.git"
        }
    ],
    "require": {
        "uii-gateway/castle": "^0.0.1"
    },
}
```

3. Tambahkan script berikut pada file **bootstrap/app.php** jika belum ada.
``` php
$app->register(UIIGateway\Castle\ServiceProvider::class);
``` 

4. Lakukan installasi/update composer dengan cara
```sh
composer update
```

5. Jika proses composer update sudah selesai, maka pada folder vendor sudah tersedia **uii-gateway/castle** (vendor/uii-gateway)

## How to use

Pada package/library ini beberapa shared utility yang dapat Anda manfaatkan. Untuk saat ini, ketersediaan utilitas tersebut seperti yang dapat Anda lihat pada list Features baru terdapat:

- Sanitize. [(Lihat cara penggunaannya disini.)](https://gitlab-cloud.uii.ac.id/uii-gateway/backend/castle/blob/develop/documentation/Sanitize.md)
- Bilingual. [(Lihat cara penggunaannya disini.)](https://gitlab-cloud.uii.ac.id/uii-gateway/backend/castle/blob/develop/documentation/Bilingual.md)

Untuk menggunakan masing masing utilitas tersebut silakan baca dokumentasi yang sudah disediakan. Klik saja pada features diatas yang ingin Anda gunakan utilitasnya.

## Maintainers

* Bamasatya H <201232636@uii.ac.id>
* Nabil Muhammad Firdaus <211232629@uii.ac.id>
* Hibbatur Rizqo Widodo <21005119@uii.ac.id>
