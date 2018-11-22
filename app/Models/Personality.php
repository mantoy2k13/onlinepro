<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Personality.
 *
 * @property int $id
 * @property string $name_en
 * @property string $name_ja
 * @property string $name_vi
 * @property string $name_zh
 * @property string $name_ru
 * @property string $name_ko
 * @property int $order
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Personality whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Personality whereNameEn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Personality whereNameJa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Personality whereNameVi($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Personality whereNameZh($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Personality whereNameRu($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Personality whereNameKo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Personality whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Personality whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Personality whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Personality whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Personality onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Personality withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Personality withoutTrashed()
 */
class Personality extends Base
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'personalities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_en',
        'name_ja',
        'name_vi',
        'name_zh',
        'name_ru',
        'name_ko',
        'order',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden    = [];

    protected $dates     = ['deleted_at'];

    protected $presenter = \App\Presenters\PersonalityPresenter::class;

    // Relations

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'      => $this->id,
            'name_en' => $this->name_en,
            'name_ja' => $this->name_ja,
            'name_vi' => $this->name_vi,
            'name_zh' => $this->name_zh,
            'name_ru' => $this->name_ru,
            'name_ko' => $this->name_ko,
            'order'   => $this->order,
        ];
    }
}
