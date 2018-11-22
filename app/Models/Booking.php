<?php
namespace App\Models;

/**
 * App\Models\Booking.
 *
 * @property int $id
 * @property int $user_id
 * @property int $teacher_id
 * @property int $time_slot_id
 * @property int $category_id
 * @property string $message
 * @property string $status
 * @property int $payment_log_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Teacher $teacher
 * @property-read \App\Models\TimeSlot $timeSlot
 * @property-read \App\Models\Review $review
 * @property-read \App\Models\Review $reviewLogByTeacher
 * @property-read \App\Models\Category $category
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Booking whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Booking whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Booking whereTeacherId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Booking whereTimeSlotId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Booking whereCategoryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Booking whereMessage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Booking whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Booking wherePaymentLogId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Booking whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Booking whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @property-read \App\Models\PaymentLog $paymentLog
 * @property-read \App\Models\PointLog $pointLog
 * @property-read \App\Models\Review $reviewByUser
 */
class Booking extends Base
{
    const TYPE_STATUS_PENDING   = 'pending';
    const TYPE_STATUS_CANCELED  = 'canceled';
    const TYPE_STATUS_FINISHED  = 'finished';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bookings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'teacher_id',
        'time_slot_id',
        'status',
        'message',
        'category_id',
        'payment_log_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden    = [];

    protected $dates     = [];

    protected $presenter = \App\Presenters\BookingPresenter::class;

    // Relations
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function teacher()
    {
        return $this->belongsTo(\App\Models\Teacher::class, 'teacher_id', 'id');
    }

    public function timeSlot()
    {
        return $this->belongsTo(\App\Models\TimeSlot::class, 'time_slot_id', 'id');
    }

    public function review()
    {
        return $this->belongsTo(\App\Models\Review::class, 'id', 'booking_id');
    }

    public function reviewLogByTeacher()
    {
        return $this->belongsTo(\App\Models\Review::class, 'id', 'booking_id')->where('target', 'user');
    }

    public function reviewByUser()
    {
        return $this->belongsTo(\App\Models\Review::class, 'id', 'booking_id')->where('target', 'teacher');
    }

    public function category()
    {
        return $this->belongsTo(\App\Models\Category::class, 'category_id', 'id');
    }

    public function paymentLog()
    {
        return $this->belongsTo(\App\Models\PaymentLog::class, 'payment_log_id', 'id');
    }

    public function pointLog()
    {
        return $this->belongsTo(\App\Models\PointLog::class, 'id', 'booking_id');
    }

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'                  => $this->id,
            'user_id'             => $this->user_id,
            'teacher_id'          => $this->teacher_id,
            'time_slot_id'        => $this->time_slot_id,
            'status'              => $this->status,
            'message'             => $this->message,
            'category_id'         => $this->category_id,
            'payment_log_id'      => $this->payment_log_id,
        ];
    }
}
