<?php
namespace App\Models;

/**
 * App\Models\TimeSlot.
 *
 * @property int $id
 * @property int $teacher_id
 * @property \Carbon\Carbon $start_at
 * @property \Carbon\Carbon $end_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Teacher $teacher
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Booking[] $booking
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Booking[] $bookingPending
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TimeSlot whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TimeSlot whereTeacherId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TimeSlot whereStartAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TimeSlot whereEndAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TimeSlot whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TimeSlot whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TimeSlot extends Base
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'time_slots';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teacher_id',
        'start_at',
        'end_at',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = ['start_at', 'end_at'];

    protected $presenter = \App\Presenters\TimeSlotPresenter::class;

    // Relations
    public function teacher()
    {
        return $this->belongsTo(\App\Models\Teacher::class, 'teacher_id', 'id');
    }

    public function booking()
    {
        return $this->hasMany(\App\Models\Booking::class, 'time_slot_id', 'id');
    }

    public function bookingPending()
    {
        return $this->hasMany(\App\Models\Booking::class, 'time_slot_id', 'id')->where('status', Booking::TYPE_STATUS_PENDING);
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
            'start_at'   => $this->start_at,
            'end_at'     => $this->end_at,
        ];
    }
}
