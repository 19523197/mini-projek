<?php

namespace App\Models;

use App\Treasures\Illuminate\Activable;
use App\Treasures\Illuminate\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ExampleModel extends Model
{
    use Activable,
        SoftDeletes;

    protected $table = 'example';

    protected $guarded = [];

    public $incrementing = false;

    const CREATED_AT = 'tgl_input';

    const UPDATED_AT = 'tgl_update';

    protected $casts = [
        'id' => 'string', // required when db type is BIGINT
    ];

    protected $appends = [
        'example_accessor',
    ];

    public function getExampleAccessorAttribute($value)
    {
        return 'example';
    }

    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class, 'id_organisasi');
    }
}
