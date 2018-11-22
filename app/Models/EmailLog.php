<?php
namespace App\Models;

/**
 * App\Models\EmailLog.
 *
 * @property int $id
 * @property int $user_id
 * @property string $old_email
 * @property string $new_email
 * @property int $status
 * @property string $validation_code
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EmailLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EmailLog whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EmailLog whereOldEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EmailLog whereNewEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EmailLog whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EmailLog whereValidationCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EmailLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\EmailLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class EmailLog extends Base
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'new_email',
        'old_email',
        'user_id',
        'status',
        'validation_code',
    ];

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'email_logs';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = ['deleted_at'];

    protected $presenter = \App\Presenters\EmailLogPresenter::class;

    // Relations
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'              => $this->id,
            'new_email'       => $this->new_email,
            'old_email'       => $this->old_email,
            'user_id'         => $this->user_id,
            'status'          => $this->status,
            'validation_code' => $this->validation_code,
        ];
    }
}
