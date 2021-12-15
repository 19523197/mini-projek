<?php

namespace App\Models;

use App\Treasures\Illuminate\Activable;
use App\Treasures\Illuminate\SoftDeletes;
use App\Treasures\Utility\TitleCase;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Organisasi extends Model
{
    use Activable,
        SoftDeletes;

    protected $table = 'organisasi';

    public $timestamps = false;

    protected $guarded = [];

    public $incrementing = false;

    protected $casts = [
        'id' => 'string',
        'id_tingkat' => 'string',
        'id_jenjang' => 'string',
        'id_perguruan_tinggi' => 'string',
    ];

    protected $appends = [
        'nama_lengkap',
        'nama_lokalisasi',
    ];

    public function anak()
    {
        return $this->hasMany(Organisasi::class, 'induk_organisasi', 'kd_organisasi');
    }

    public function semuaAnak()
    {
        return $this->anak()->with('semuaAnak');
    }

    public function induk()
    {
        return $this->belongsTo(Organisasi::class, 'induk_organisasi', 'kd_organisasi');
    }

    public function semuaInduk()
    {
        return $this->induk()->with('semuaInduk');
    }

    public function scopeFakultas(Builder $query): Builder
    {
        return $query->where(function ($q) {
            $q->where('nama_tingkat', 'Fakultas')
                ->where('induk_organisasi', 1);
        });
    }

    public function scopeProdi(Builder $query): Builder
    {
        return $query->where('nama_tingkat', 'Prodi');
    }

    public function scopeFakultasAtauProdi(Builder $query): Builder
    {
        return $query->where(function (Builder $q) {
            $q->fakultas()
                ->orWhere(function (Builder $q2) {
                    $q2->prodi();
                });
        });
    }

    public function tingkatFakultas()
    {
        return Str::lower($this->getAttribute('nama_tingkat')) === 'fakultas';
    }

    public function tingkatProdi()
    {
        return Str::lower($this->getAttribute('nama_tingkat')) === 'prodi';
    }

    public function getNamaOrganisasiAttribute($value)
    {
        if (is_null($value)) {
            return $value;
        }

        return new TitleCase($value);
    }

    public function getNamaLokalisasiAttribute()
    {
        $locale = app('translator')->getLocale();
        $value = $this->getAttribute('nama_organisasi_' . $locale);
        $shortName = $this->getAttribute('nama_singkat');

        return blank($value)
            ? $this->getAttribute('nama_organisasi')
            : (new TitleCase($value)) . (Str::endsWith($shortName, '-IP') ? ' (IP)' : '');
    }

    public function getNamaLengkapAttribute()
    {
        $name = $this->getAttribute('nama_jenjang');

        return blank($name)
            ? $this->getAttribute('nama_lokalisasi')
            : $name . ' - ' . $this->getAttribute('nama_lokalisasi');
    }
}
