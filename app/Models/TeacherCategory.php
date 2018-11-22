<?php
namespace App\Models;

/**
 * App\Models\TeacherCategory.
 *
 * @property int $id
 * @property int $teacher_id
 * @property int $category_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Teacher $teacher
 * @property-read \App\Models\Category $category
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherCategory whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherCategory whereTeacherId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TeacherCategory extends Base
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'teacher_categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teacher_id',
        'category_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden    = [];

    protected $dates     = [];

    protected $presenter = \App\Presenters\TeacherCategoryPresenter::class;

    // Relations
    public function teacher()
    {
        return $this->belongsTo(\App\Models\Teacher::class, 'teacher_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id', 'id');
    }

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'          => $this->id,
            'teacher_id'  => $this->teacher_id,
            'category_id' => $this->category_id,
        ];
    }
}
