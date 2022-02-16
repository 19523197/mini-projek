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
 * @property-read \App\Models\Organisasi|null $organisasi
 * @method static int count($columns='*')
 * @method static \Illuminate\Database\Query\Builder|ContohModel create(array $attributes=[])
 * @method static void dd()
 * @method static \Illuminate\Database\Query\Builder|ContohModel findOrNew($id, $columns=['*'])
 * @method static \Illuminate\Database\Query\Builder|ContohModel firstOr($columns=['*'], \Closure $callback=null)
 * @method static \Illuminate\Database\Query\Builder|ContohModel firstOrCreate(array $attributes=[], array $values=[])
 * @method static \Illuminate\Database\Query\Builder|ContohModel firstOrFail($columns=['*'])
 * @method static \Illuminate\Database\Query\Builder|ContohModel firstOrNew(array $attributes=[], array $values=[])
 * @method static \Illuminate\Database\Query\Builder|ContohModel forceCreate(array $attributes)
 * @method static \Illuminate\Database\Query\Builder|ContohModel fromSub($query, $as)
 * @method static \Illuminate\Database\Query\Builder|ContohModel get($columns=['*'])
 * @method static \Illuminate\Database\Query\Builder[]|ContohModel[] getModels($columns=['*'])
 * @method static \Illuminate\Database\Query\Builder|ContohModel inRandomOrder($seed='')
 * @method static \Illuminate\Database\Query\Builder|ContohModel latest($column='created_at')
 * @method static \Illuminate\Database\Query\Builder|ContohModel limit($value)
 * @method static \Illuminate\Database\Query\Builder|ContohModel newModelInstance(array $attributes=[])
 * @method static \Illuminate\Database\Eloquent\Builder|ContohModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContohModel newQuery()
 * @method static \Illuminate\Database\Query\Builder|ContohModel offset($value)
 * @method static \Illuminate\Database\Query\Builder|ContohModel oldest($column='created_at')
 * @method static \Illuminate\Database\Query\Builder|ContohModel on($connection=null)
 * @method static \Illuminate\Database\Query\Builder|ContohModel onlyActive()
 * @method static \Illuminate\Database\Query\Builder|ContohModel onlyInactive()
 * @method static \Illuminate\Database\Query\Builder|ContohModel onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|ContohModel orWhere($column, $operator=null, $value=null)
 * @method static \Illuminate\Database\Query\Builder|ContohModel orWhereBetween($column, array $values)
 * @method static \Illuminate\Database\Query\Builder|ContohModel orWhereIn($column, $values)
 * @method static \Illuminate\Database\Query\Builder|ContohModel orWhereNotBetween($column, array $values)
 * @method static \Illuminate\Database\Query\Builder|ContohModel orWhereNotIn($column, $values)
 * @method static \Illuminate\Database\Query\Builder|ContohModel orderBy($column, $direction='asc')
 * @method static \Illuminate\Database\Query\Builder|ContohModel orderByDesc($column)
 * @method static \Illuminate\Contracts\Pagination\LengthAwarePaginator paginate($perPage=null, $columns=['*'], $pageName='page', $page=null)
 * @method static \Illuminate\Database\Eloquent\Builder|ContohModel query()
 * @method static \Illuminate\Database\Query\Builder|ContohModel skip($value)
 * @method static \Illuminate\Database\Query\Builder|ContohModel take($value)
 * @method static string toSql($value)
 * @method static \Illuminate\Database\Query\Builder|ContohModel updateOrCreate(array $attributes=[], array $values=[])
 * @method static \Illuminate\Database\Query\Builder|ContohModel where($column, $operator=null, $value=null, $boolean='and')
 * @method static \Illuminate\Database\Query\Builder|ContohModel whereBetween($column, array $values, $boolean='and', $not=false)
 * @method static \Illuminate\Database\Eloquent\Builder|ContohModel whereFlagAktif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContohModel whereFlagDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContohModel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContohModel whereIdOrganisasi($value)
 * @method static \Illuminate\Database\Query\Builder|ContohModel whereIn($column, $values, $boolean='and', $not=false)
 * @method static \Illuminate\Database\Query\Builder|ContohModel whereNotBetween($column, array $values, $boolean='and')
 * @method static \Illuminate\Database\Query\Builder|ContohModel whereNotIn($column, $values, $boolean='and')
 * @method static \Illuminate\Database\Query\Builder|ContohModel whereSub($column, $operator, \Closure $callback, $boolean)
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
 * @property-read Organisasi|null $induk
 * @method static int count($columns='*')
 * @method static \Illuminate\Database\Query\Builder|Organisasi create(array $attributes=[])
 * @method static void dd()
 * @method static \Illuminate\Database\Eloquent\Builder|Organisasi fakultas()
 * @method static \Illuminate\Database\Eloquent\Builder|Organisasi fakultasAtauProdi()
 * @method static \Illuminate\Database\Query\Builder|Organisasi findOrNew($id, $columns=['*'])
 * @method static \Illuminate\Database\Query\Builder|Organisasi firstOr($columns=['*'], \Closure $callback=null)
 * @method static \Illuminate\Database\Query\Builder|Organisasi firstOrCreate(array $attributes=[], array $values=[])
 * @method static \Illuminate\Database\Query\Builder|Organisasi firstOrFail($columns=['*'])
 * @method static \Illuminate\Database\Query\Builder|Organisasi firstOrNew(array $attributes=[], array $values=[])
 * @method static \Illuminate\Database\Query\Builder|Organisasi forceCreate(array $attributes)
 * @method static \Illuminate\Database\Query\Builder|Organisasi fromSub($query, $as)
 * @method static \Illuminate\Database\Query\Builder|Organisasi get($columns=['*'])
 * @method static \Illuminate\Database\Query\Builder[]|Organisasi[] getModels($columns=['*'])
 * @method static \Illuminate\Database\Query\Builder|Organisasi inRandomOrder($seed='')
 * @method static \Illuminate\Database\Query\Builder|Organisasi latest($column='created_at')
 * @method static \Illuminate\Database\Query\Builder|Organisasi limit($value)
 * @method static \Illuminate\Database\Query\Builder|Organisasi newModelInstance(array $attributes=[])
 * @method static \Illuminate\Database\Eloquent\Builder|Organisasi newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Organisasi newQuery()
 * @method static \Illuminate\Database\Query\Builder|Organisasi offset($value)
 * @method static \Illuminate\Database\Query\Builder|Organisasi oldest($column='created_at')
 * @method static \Illuminate\Database\Query\Builder|Organisasi on($connection=null)
 * @method static \Illuminate\Database\Query\Builder|Organisasi onlyActive()
 * @method static \Illuminate\Database\Query\Builder|Organisasi onlyInactive()
 * @method static \Illuminate\Database\Query\Builder|Organisasi onlyTrashed()
 * @method static \Illuminate\Database\Query\Builder|Organisasi orWhere($column, $operator=null, $value=null)
 * @method static \Illuminate\Database\Query\Builder|Organisasi orWhereBetween($column, array $values)
 * @method static \Illuminate\Database\Query\Builder|Organisasi orWhereIn($column, $values)
 * @method static \Illuminate\Database\Query\Builder|Organisasi orWhereNotBetween($column, array $values)
 * @method static \Illuminate\Database\Query\Builder|Organisasi orWhereNotIn($column, $values)
 * @method static \Illuminate\Database\Query\Builder|Organisasi orderBy($column, $direction='asc')
 * @method static \Illuminate\Database\Query\Builder|Organisasi orderByDesc($column)
 * @method static \Illuminate\Contracts\Pagination\LengthAwarePaginator paginate($perPage=null, $columns=['*'], $pageName='page', $page=null)
 * @method static \Illuminate\Database\Eloquent\Builder|Organisasi prodi()
 * @method static \Illuminate\Database\Eloquent\Builder|Organisasi query()
 * @method static \Illuminate\Database\Query\Builder|Organisasi skip($value)
 * @method static \Illuminate\Database\Query\Builder|Organisasi take($value)
 * @method static string toSql($value)
 * @method static \Illuminate\Database\Query\Builder|Organisasi updateOrCreate(array $attributes=[], array $values=[])
 * @method static \Illuminate\Database\Query\Builder|Organisasi where($column, $operator=null, $value=null, $boolean='and')
 * @method static \Illuminate\Database\Query\Builder|Organisasi whereBetween($column, array $values, $boolean='and', $not=false)
 * @method static \Illuminate\Database\Eloquent\Builder|Organisasi whereFlagAktif($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organisasi whereFlagDelete($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Organisasi whereId($value)
 * @method static \Illuminate\Database\Query\Builder|Organisasi whereIn($column, $values, $boolean='and', $not=false)
 * @method static \Illuminate\Database\Query\Builder|Organisasi whereNotBetween($column, array $values, $boolean='and')
 * @method static \Illuminate\Database\Query\Builder|Organisasi whereNotIn($column, $values, $boolean='and')
 * @method static \Illuminate\Database\Query\Builder|Organisasi whereSub($column, $operator, \Closure $callback, $boolean)
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
 * @method static int count($columns='*')
 * @method static \Illuminate\Database\Query\Builder|User create(array $attributes=[])
 * @method static void dd()
 * @method static \Database\Factories\UserFactory factory(...$parameters)
 * @method static \Illuminate\Database\Query\Builder|User findOrNew($id, $columns=['*'])
 * @method static \Illuminate\Database\Query\Builder|User firstOr($columns=['*'], \Closure $callback=null)
 * @method static \Illuminate\Database\Query\Builder|User firstOrCreate(array $attributes=[], array $values=[])
 * @method static \Illuminate\Database\Query\Builder|User firstOrFail($columns=['*'])
 * @method static \Illuminate\Database\Query\Builder|User firstOrNew(array $attributes=[], array $values=[])
 * @method static \Illuminate\Database\Query\Builder|User forceCreate(array $attributes)
 * @method static \Illuminate\Database\Query\Builder|User fromSub($query, $as)
 * @method static \Illuminate\Database\Query\Builder|User get($columns=['*'])
 * @method static \Illuminate\Database\Query\Builder[]|User[] getModels($columns=['*'])
 * @method static \Illuminate\Database\Query\Builder|User inRandomOrder($seed='')
 * @method static \Illuminate\Database\Query\Builder|User latest($column='created_at')
 * @method static \Illuminate\Database\Query\Builder|User limit($value)
 * @method static \Illuminate\Database\Query\Builder|User newModelInstance(array $attributes=[])
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User offset($value)
 * @method static \Illuminate\Database\Query\Builder|User oldest($column='created_at')
 * @method static \Illuminate\Database\Query\Builder|User on($connection=null)
 * @method static \Illuminate\Database\Query\Builder|User orWhere($column, $operator=null, $value=null)
 * @method static \Illuminate\Database\Query\Builder|User orWhereBetween($column, array $values)
 * @method static \Illuminate\Database\Query\Builder|User orWhereIn($column, $values)
 * @method static \Illuminate\Database\Query\Builder|User orWhereNotBetween($column, array $values)
 * @method static \Illuminate\Database\Query\Builder|User orWhereNotIn($column, $values)
 * @method static \Illuminate\Database\Query\Builder|User orderBy($column, $direction='asc')
 * @method static \Illuminate\Database\Query\Builder|User orderByDesc($column)
 * @method static \Illuminate\Contracts\Pagination\LengthAwarePaginator paginate($perPage=null, $columns=['*'], $pageName='page', $page=null)
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Query\Builder|User skip($value)
 * @method static \Illuminate\Database\Query\Builder|User take($value)
 * @method static string toSql($value)
 * @method static \Illuminate\Database\Query\Builder|User updateOrCreate(array $attributes=[], array $values=[])
 * @method static \Illuminate\Database\Query\Builder|User where($column, $operator=null, $value=null, $boolean='and')
 * @method static \Illuminate\Database\Query\Builder|User whereBetween($column, array $values, $boolean='and', $not=false)
 * @method static \Illuminate\Database\Query\Builder|User whereIn($column, $values, $boolean='and', $not=false)
 * @method static \Illuminate\Database\Query\Builder|User whereNotBetween($column, array $values, $boolean='and')
 * @method static \Illuminate\Database\Query\Builder|User whereNotIn($column, $values, $boolean='and')
 * @method static \Illuminate\Database\Query\Builder|User whereSub($column, $operator, \Closure $callback, $boolean)
 * @method static \Illuminate\Database\Query\Builder|User with($relations)
 */
	class User extends \Eloquent implements \Illuminate\Contracts\Auth\Authenticatable, \Illuminate\Contracts\Auth\Access\Authorizable {}
}

