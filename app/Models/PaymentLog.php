<?php
namespace App\Models;

/**
 * App\Models\PaymentLog.
 *
 * @property int $id
 * @property int $teacher_id
 * @property string $status
 * @property int $paid_amount
 * @property string $paid_for_month
 * @property \Carbon\Carbon $paid_at
 * @property string $note
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Teacher $teacher
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentLog whereTeacherId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentLog whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentLog wherePaidAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentLog wherePaidForMonth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentLog wherePaidAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentLog whereNote($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PaymentLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class PaymentLog extends Base
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payment_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teacher_id',
        'status',
        'paid_amount',
        'paid_for_month',
        'paid_at',
        'note',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = [];

    protected $presenter = \App\Presenters\PaymentLogPresenter::class;

    // Relations
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
            'id'             => $this->id,
            'teacher_id'     => $this->teacher_id,
            'status'         => $this->status,
            'paid_amount'    => $this->paid_amount,
            'paid_for_month' => $this->paid_for_month,
            'paid_at'        => $this->paid_at,
            'note'           => $this->note,
        ];
    }
}
