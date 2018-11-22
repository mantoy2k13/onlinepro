<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Category.
 *
 * @property int $id
 * @property string $name_ja
 * @property string $name_en
 * @property string $slug
 * @property int $image_id
 * @property string $description_ja
 * @property string $description_en
 * @property int $order
 * @property \Carbon\Carbon $deleted_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Teacher[] $teachers
 * @property-read \App\Models\Image $image
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereNameJa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereNameEn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereSlug($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereImageId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereDescriptionJa($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereDescriptionEn($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Category withoutTrashed()
 */
class Category extends Base
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_ja',
        'name_en',
        'slug',
        'image_id',
        'description_ja',
        'description_en',
        'order',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden    = [];

    protected $dates     = ['deleted_at'];

    protected $presenter = \App\Presenters\CategoryPresenter::class;

    // Relations
    public function teachers()
    {
        return $this->belongsToMany(
            \App\Models\Teacher::class,
            \App\Models\TeacherCategory::getTableName(),
            'teacher_id',
            'category_id'
        );
    }

    public function image()
    {
        return $this->belongsTo('App\Models\Image', 'image_id', 'id');
    }

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'   => $this->id,
            'name' => $this->present()->name,
        ];
    }
}
