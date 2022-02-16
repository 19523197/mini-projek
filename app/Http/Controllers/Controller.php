<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use UIIGateway\Castle\Utility\Translation;

class Controller extends BaseController
{
    protected function responseCreated(
        string $entity,
        $message = ':entity berhasil ditambahkan.',
        $replace = []
    ) {
        return response()->json([
            'info' => __($message, array_merge(
                ['entity' => Translation::transEntity($entity)],
                $replace
            ))
        ], 201);
    }

    protected function responseUpdated(
        string $entity,
        $message = ':entity berhasil diperbarui.',
        $replace = []
    ) {
        return response()->json([
            'info' => __($message, array_merge(
                ['entity' => Translation::transEntity($entity)],
                $replace
            ))
        ]);
    }

    protected function responseDeleted(
        string $entity,
        $message = ':entity berhasil dihapus.',
        $replace = []
    ) {
        return response()->json([
            'info' => __($message, array_merge(
                ['entity' => Translation::transEntity($entity)],
                $replace
            ))
        ]);
    }
}
