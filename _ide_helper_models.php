<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\ContohModel
 *
 * @property string $id
 * @property string $id_organisasi
 * @property int $flag_delete
 * @property string $uuid
 * @property \Illuminate\Support\Carbon $tgl_input
 * @property \Illuminate\Support\Carbon $tgl_update
 * @property int $flag_aktif
 * @property-read mixed $contoh_aksesor
 * @property-read \App\Models\Organisasi $organisasi
 * @method static \Illuminate\Database\Eloquent\Builder|ContohModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContohModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|ContohModel on($connection=null)
 * @method static \Illuminate\Database\Query\Builder|ContohModel onlyActive()
 * @method static \Illuminate\Database\Query\Builder|ContohModel onlyInactive()
 * @method static \Illuminate\Database\Query\Builder|ContohModel onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|ContohModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContohModel whereFlagAktif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContohModel whereFlagDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContohModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContohModel whereIdOrganisasi($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContohModel whereTglInput($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContohModel whereTglUpdate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContohModel whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|ContohModel with($relations)
 * @method static \Illuminate\Database\Query\Builder|ContohModel withTrashed()
 * @method static \Illuminate\Database\Query\Builder|ContohModel withoutInactive()
 * @method static \Illuminate\Database\Query\Builder|ContohModel withoutTrashed()
 */
	class ContohModel extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Organisasi
 *
 * @property string $id
 * @property string $uuid
 * @property int $flag_aktif
 * @property int $flag_delete
 * @property-read \Illuminate\Database\Eloquent\Collection|Organisasi[] $anak
 * @property-read int|null $anak_count
 * @property-read mixed $nama_lengkap
 * @property-read mixed $nama_lokalisasi
 * @property-read mixed $nama_organisasi
 * @property-read Organisasi $induk
 * @method static \Illuminate\Database\Eloquent\Builder|Organisasi fakultas()
 * @method static \Illuminate\Database\Eloquent\Builder|Organisasi fakultasAtauProdi()
 * @method static \Illuminate\Database\Eloquent\Builder|Organisasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organisasi newQuery()
 * @method static \Illuminate\Database\Query\Builder|Organisasi on($connection=null)
 * @method static \Illuminate\Database\Query\Builder|Organisasi onlyActive()
 * @method static \Illuminate\Database\Query\Builder|Organisasi onlyInactive()
 * @method static \Illuminate\Database\Query\Builder|Organisasi onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Organisasi prodi()
 * @method static \Illuminate\Database\Eloquent\Builder|Organisasi query()
 * @method static \Illuminate\Database\Eloquent\Builder|Organisasi whereFlagAktif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organisasi whereFlagDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organisasi whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organisasi whereUuid($value)
 * @method static \Illuminate\Database\Query\Builder|Organisasi with($relations)
 * @method static \Illuminate\Database\Query\Builder|Organisasi withTrashed()
 * @method static \Illuminate\Database\Query\Builder|Organisasi withoutInactive()
 * @method static \Illuminate\Database\Query\Builder|Organisasi withoutTrashed()
 */
	class Organisasi extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User on($connection=null)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Query\Builder|User with($relations)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\Authenticatable, \Illuminate\Contracts\Auth\Access\Authorizable {}
}

