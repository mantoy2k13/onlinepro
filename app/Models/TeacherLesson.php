<?php
namespace App\Models;

/**
 * App\Models\TeacherLesson.
 *
 * @property int $id
 * @property int $teacher_id
 * @property int $lesson_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Teacher $teacher
 * @property-read \App\Models\Lesson $lesson
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherLesson whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherLesson whereTeacherId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherLesson whereLessonId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherLesson whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherLesson whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TeacherLesson extends Base
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'teacher_lessons';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teacher_id',
        'lesson_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = [];

    protected $presenter = \App\Presenters\TeacherLessonPresenter::class;

    // Relations
    public function teacher()
    {
        return $this->belongsTo(\App\Models\Teacher::class, 'teacher_id', 'id');
    }

    public function lesson()
    {
        return $this->belongsTo(\App\Models\Lesson::class, 'lesson_id', 'id');
    }

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'         => $this->id,
            'teacher_id' => $this->teacher_id,
            'lesson_id'  => $this->lesson_id,
        ];
    }
}
