<?php

namespace UIIGateway\Castle\Testing;

trait TestingMixins
{
    use InteractsWithContainer;
    use InteractsWithExceptionHandling;
    use ResponseAssertion;

    protected function withHeaders(array $headers = [])
    {
        return array_merge([
            'X-App' => '0f242f7c-6883-11e8-bf86-005056806fe5',
            'X-Menu' => '31aa3c64-fbe6-11e8-b499-005056807484',
            'X-Organization' => json_encode([
                [
                    'kd_organisasi' => '52', // FTI
                    'uuid_otoritas_user_organisasi' => '95d5c210-ab0b-11ea-8c77-7eb0d4a3c7a0',
                ],
            ]),
            'X-Member' => '211232629',
            'X-University' => 1,
        ], $headers);
    }

    protected function buildUrl(string $uri, array $parameters = [])
    {
        if (! empty($parameters)) {
            $uri .= '?' . http_build_query($parameters);
        }

        return $uri;
    }
}
