<?php
namespace App\Models;

/**
 * App\Models\PurchaseLog.
 *
 * @property int $id
 * @property int $user_id
 * @property string $purchase_method_type
 * @property int $point_amount
 * @property string $point_expired_at
 * @property int $remaining_point_amount
 * @property string $purchase_info
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PurchaseLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PurchaseLog whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PurchaseLog wherePurchaseMethodType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PurchaseLog wherePointAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PurchaseLog wherePointExpiredAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PurchaseLog whereRemainingPointAmount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PurchaseLog wherePurchaseInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PurchaseLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\PurchaseLog whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @property-read \App\Models\PurchaseLog $purchasePaypal
 */
class PurchaseLog extends Base
{
    const PURCHASE_TYPE_PAYPAL   = 'paypal';
    const PURCHASE_TYPE_BY_ADMIN = 'by_admin';

    const PURCHASE_PACKAGE_PAYPAL_LIGHT   = 15;
    const PURCHASE_PACKAGE_PAYPAL_BASIC   = 30;
    const PURCHASE_PACKAGE_PAYPAL_PREMIUM = 60;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'purchase_logs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'purchase_method_type',
        'point_amount',
        'purchase_info',
        'point_expired_at',
        'remaining_point_amount',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = [];

    protected $presenter = \App\Presenters\PurchaseLogPresenter::class;

    // Relations
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function purchasePaypal()
    {
        return $this->belongsTo(\App\Models\PurchaseLog::class, 'id');
    }

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'                     => $this->id,
            'user_id'                => $this->user_id,
            'purchase_method_type'   => $this->purchase_method_type,
            'point_amount'           => $this->point_amount,
            'point_expired_at'       => $this->point_expired_at,
            'remaining_point_amount' => $this->remaining_point_amount,
            'purchase_info'          => $this->purchase_info,
        ];
    }
}
