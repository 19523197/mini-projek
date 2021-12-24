<?php

namespace App\Http\Controllers;

use App\Treasures\Illuminate\Http\Resources\Resource;
use App\Treasures\Utility\Translation;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    protected function responseCreated(
        Resource $resource,
        string $entity,
        $message = ':entity berhasil ditambahkan.'
    ) {
        return $resource
            ->additional([
                'info' => __($message, ['entity' => Translation::transEntity($entity)])
            ])
            ->response()
            ->setStatusCode(201);
    }

    protected function responseUpdated(
        Resource $resource,
        string $entity,
        $message = ':entity berhasil diperbarui.'
    ) {
        return $resource
            ->additional([
                'info' => __($message, ['entity' => Translation::transEntity($entity)])
            ]);
    }

    protected function responseDeleted(
        string $entity,
        $message = ':entity berhasil dihapus.'
    ) {
        return response()->json([
            'info' => __($message, ['entity' => Translation::transEntity($entity)])
        ]);
    }
}
