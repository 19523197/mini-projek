# UII Gateway Castle

#### _Kumpulan utilitas untuk microservice berbasis Lumen di BSI UII_

[![UII Gateway Logo](https://gateway-dev.uii.ac.id/assets/images/loader/loader.gif)](https://gateway-dev.uii.ac.id/assets/images/loader/loader.gif)

UII Gateway Castle Lumen merupakan _package_ yang menyimpan berbagai utilitas untuk memudahkan pekerjaan Anda dalam membangun servis menggunakan framework Lumen.

## Memulai

Untuk memulai menggunakan _package_ ini, pastikan Anda menggunakan _package_ ini hanya untuk aplikasi dengan _environment_ yang ada di BSI (_package_ ini mungkin tidak bisa berjalan jika berbeda _environment_). 

Pastikan Anda sudah melakukan instalasi [boilerplate lumen BSI](https://gitlab-cloud.uii.ac.id/uii-gateway/backend/svc-boilerplate-lumen). Jika Anda belum melakukan instalasi boilerplate tersebut, silakan ikuti langkah instalasi boilerplate tersebut sesuai dengan [dokumentasi instalasi boilerplate](https://gitlab-cloud.uii.ac.id/uii-gateway/backend/svc-boilerplate-lumen/blob/develop/README.md).

Perlu diperhatikan, _package_ ini akan berjalan lancar untuk _project_ baru. Jika Anda ingin menggunakan pada _existing project_, diperlukan konfigurasi khusus agar _package_ ini dapat berjalan dengan baik.

## Instalasi

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
        "uii-gateway/castle": "^1.0.0"
    },
}
```

3. Tambahkan script berikut pada file **bootstrap/app.php** jika belum ada.
``` php
$app->register(UIIGateway\Castle\ServiceProvider::class);
``` 

4. Lakukan installasi composer dengan cara
```sh
composer update
```

5. Jika proses composer update sudah selesai, maka pada folder vendor sudah tersedia **uii-gateway/castle** (vendor/uii-gateway)

## Cara Penggunaan

Pada _package_ ini beberapa shared utility yang dapat Anda manfaatkan. Untuk saat ini, ketersediaan utilitas tersebut seperti yang dapat Anda lihat pada list fitur:

- Sanitize. [(Lihat cara penggunaannya disini.)](https://gitlab-cloud.uii.ac.id/uii-gateway/backend/castle/blob/develop/documentation/Sanitize.md)
- Bilingual. [(Lihat cara penggunaannya disini.)](https://gitlab-cloud.uii.ac.id/uii-gateway/backend/castle/blob/develop/documentation/Bilingual.md)

Untuk menggunakan masing masing utilitas tersebut, silakan baca dokumentasi yang sudah disediakan. Klik saja pada masing-masing fitur di atas.

## Pengembang

* Nabil Muhammad Firdaus <211232629@uii.ac.id>
* Bamasatya H <bamasatyaproject@gmail.com>
