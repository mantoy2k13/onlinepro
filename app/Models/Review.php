<?php
namespace App\Models;

/**
 * App\Models\Review.
 *
 * @property int $id
 * @property string $target
 * @property int $user_id
 * @property int $teacher_id
 * @property int $booking_id
 * @property int $rating
 * @property string $content
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Teacher $teacher
 * @property-read \App\Models\Booking $booking
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Review whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Review whereTarget($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Review whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Review whereTeacherId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Review whereBookingId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Review whereRating($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Review whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Review whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Review whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Review extends Base
{
    const TARGET_TEACHER = 'teacher';
    const TARGET_USER    = 'user';
    const RATING_DEFAULT = 3;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'reviews';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'target',
        'user_id',
        'teacher_id',
        'booking_id',
        'rating',
        'content',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden    = [];

    protected $dates     = [];

    protected $presenter = \App\Presenters\ReviewPresenter::class;

    // Relations
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(\App\Models\Teacher::class, 'teacher_id', 'id');
    }

    public function booking()
    {
        return $this->belongsTo(\App\Models\Booking::class, 'booking_id', 'id');
    }

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'         => $this->id,
            'target'     => $this->target,
            'user_id'    => $this->user_id,
            'teacher_id' => $this->teacher_id,
            'booking_id' => $this->booking_id,
            'rating'     => $this->rating,
            'content'    => $this->content,
        ];
    }
}
