<?php
namespace App\Models;

/**
 * App\Models\PointLog.
 *
 * @property int $id
 * @property int $user_id
 * @property int $point_amount
 * @property string $type
 * @property string $description
 * @property int $booking_id
 * @property int $purchase_log_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PointLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PointLog whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PointLog wherePointAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PointLog whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PointLog whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PointLog whereBookingId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PointLog wherePurchaseLogId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PointLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PointLog whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @property-read \App\Models\PurchaseLog $purchaseLog
 */
class PointLog extends Base
{
    const TYPE_BOOKING      = 'booking';
    const TYPE_REFUND       = 'refund';
    const TYPE_EXPIRED      = 'expired';
    const TYPE_PURCHASE     = 'purchase';
    const TYPE_BONUS        = 'bonus';
    const TYPE_DEDUCTED     = 'deducted';
    const TYPE_BONUS_SIGNUP = 'bonus_signup';

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'point_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'point_amount',
        'type',
        'description',
        'booking_id',
        'purchase_log_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden    = [];

    protected $dates     = [];

    protected $presenter = \App\Presenters\PointLogPresenter::class;

    // Relations
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function purchaseLog()
    {
        return $this->belongsTo(\App\Models\PurchaseLog::class, 'purchase_log_id', 'id');
    }

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'              => $this->id,
            'user_id'         => $this->user_id,
            'point_amount'    => $this->point_amount,
            'type'            => $this->type,
            'description'     => $this->description,
            'booking_id'      => $this->booking_id,
            'purchase_log_id' => $this->purchase_log_id,
        ];
    }
}
