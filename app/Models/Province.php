<?php
namespace App\Models;

/**
 * App\Models\Province.
 *
 * @property int $id
 * @property string $name_en
 * @property string $name_ja
 * @property string $country_code
 * @property int $order
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Country $country
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Province whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Province whereNameEn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Province whereNameJa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Province whereCountryCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Province whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Province whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Province whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Province extends Base
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'provinces';

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
    protected $hidden = [];

    protected $dates  = [];

    protected $presenter = \App\Presenters\ProvincePresenter::class;

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
