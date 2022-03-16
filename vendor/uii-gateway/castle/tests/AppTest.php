<?php

namespace UIIGateway\Castle\Tests;

use UIIGateway\Castle\ValueObject\StatusMahasiswa;

class AppTest extends TestCase
{
    public function testExample()
    {
        $this->assertSame(
            StatusMahasiswa::getDescription(StatusMahasiswa::PERINGATAN_DO),
            __('castle::enums.' . StatusMahasiswa::class . '.3')
        );
    }
}
