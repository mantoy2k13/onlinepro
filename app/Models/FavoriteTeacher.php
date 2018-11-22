<?php
namespace App\Models;

/**
 * App\Models\FavoriteTeacher.
 *
 * @property int $id
 * @property int $user_id
 * @property int $teacher_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Teacher $teacher
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FavoriteTeacher whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FavoriteTeacher whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FavoriteTeacher whereTeacherId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FavoriteTeacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\FavoriteTeacher whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class FavoriteTeacher extends Base
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'favorite_teachers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'teacher_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = [];

    protected $presenter = \App\Presenters\FavoriteTeacherPresenter::class;

    // Relations
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(\App\Models\Teacher::class, 'teacher_id', 'id');
    }

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'teacher_id' => $this->teacher_id,
        ];
    }
}
