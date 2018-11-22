<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\City.
 *
 * @property int $id
 * @property string $name_en
 * @property string $name_ja
 * @property string $country_code
 * @property int $order
 * @property string $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Country $country
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereNameEn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereNameJa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereCountryCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\City withoutTrashed()
 */
class City extends Base
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_en',
        'name_ja',
        'country_code',
        'order',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden    = [];

    protected $dates     = [];

    protected $presenter = \App\Presenters\CityPresenter::class;

    // Relations
    public function country()
    {
        return $this->belongsTo(\App\Models\Country::class, 'country_code', 'code');
    }

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'           => $this->id,
            'name_en'      => $this->name_en,
            'name_ja'      => $this->name_ja,
            'country_code' => $this->country_code,
            'order'        => $this->order,
        ];
    }
}
