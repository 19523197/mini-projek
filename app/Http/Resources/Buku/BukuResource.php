<?php

namespace App\Http\Resources\Buku;

use UIIGateway\Castle\Http\Resources\Resource;

class BukuResource extends Resource
{
    public function toArray($request)
    {
        /**
         * You can customize resource to show mapped data. Use this function to declare the data you want to throw.
         * $this refer to the data you throw into this resource.
         * Format: 'variableKey' => 'variableValue'
         * Example: 'nama_dosen_dengan_gelar' => $this->gelar_depan.' '.$this->nama_dosen.' '.$this->gelar_belakang
         */
        return [
            'id' => $this->information->id,
            'title' => $this->information->title,
            'cover_url' => $this->information->cover_url,
            'summary' => $this->information->summary,
            'category' => $this->information->category,
            'author' => $this->information->author,
            'price' => $this->information->price,

        ];
    }
}
