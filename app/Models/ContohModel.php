<?php

namespace App\Models;

use App\Treasures\Database\HasRelationships;
use App\Treasures\Illuminate\Activable;
use App\Treasures\Illuminate\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ContohModel extends Model
{
    use Activable,
        SoftDeletes,
        HasRelationships;

    protected $table = 'contoh';

    protected $guarded = [];

    public $incrementing = false;

    const CREATED_AT = 'tgl_input';

    const UPDATED_AT = 'tgl_update';

    protected $casts = [
        'id' => 'string', // required when column type is BIGINT,
        'id_organisasi' => 'string',
    ];

    protected $appends = [
        'contoh_aksesor',
    ];

    public function getContohAksesorAttribute($value)
    {
        return 'contoh';
    }

    public function organisasi()
    {
        return $this->belongsTo(Organisasi::class, 'id_organisasi');
    }
}
