<?php
namespace App\Models;

/**
 * App\Models\TeacherPersonality.
 *
 * @property int $id
 * @property int $teacher_id
 * @property int $personality_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Teacher $teacher
 * @property-read \App\Models\Personality $personality
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherPersonality whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherPersonality whereTeacherId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherPersonality wherePersonalityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherPersonality whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherPersonality whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TeacherPersonality extends Base
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'teacher_personalities';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teacher_id',
        'personality_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden    = [];

    protected $dates     = [];

    protected $presenter = \App\Presenters\TeacherPersonalityPresenter::class;

    // Relations
    public function teacher()
    {
        return $this->belongsTo(\App\Models\Teacher::class, 'teacher_id', 'id');
    }

    public function personality()
    {
        return $this->belongsTo(\App\Models\Personality::class, 'personality_id', 'id');
    }

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'             => $this->id,
            'teacher_id'     => $this->teacher_id,
            'personality_id' => $this->personality_id,
        ];
    }
}
