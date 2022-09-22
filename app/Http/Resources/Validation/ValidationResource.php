<?php

namespace App\Http\Resources\Validation;

use UIIGateway\Castle\Http\Resources\Resource;

class ValidationResource extends Resource
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
            'variable_1' => $this->variable_1,
            'variable_2' => $this->variable_2,
            'variable_3' => $this->variable_3,
        ];
    }
}
