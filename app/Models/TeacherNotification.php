<?php
namespace App\Models;

/**
 * App\Models\TeacherNotification.
 *
 * @property int $id
 * @property int $user_id
 * @property string $category_type
 * @property string $title
 * @property string $type
 * @property string $data
 * @property string $content
 * @property string $locale
 * @property bool $read
 * @property \Carbon\Carbon $sent_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Teacher $teacher
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherNotification whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherNotification whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherNotification whereCategoryType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherNotification whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherNotification whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherNotification whereData($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherNotification whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherNotification whereLocale($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherNotification whereRead($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherNotification whereSentAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherNotification whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherNotification whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TeacherNotification extends Notification
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'teacher_notifications';

    protected $presenter = \App\Presenters\TeacherNotificationPresenter::class;

    public function teacher()
    {
        return $this->belongsTo('App\Models\Teacher', 'user_id', 'id');
    }
}
