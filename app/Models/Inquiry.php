<?php
namespace App\Models;

/**
 * App\Models\Inquiry.
 *
 * @property int $id
 * @property string $type
 * @property int $user_id
 * @property string $name
 * @property string $email
 * @property string $living_country_code
 * @property string $content
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Country $country
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquiry whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquiry whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquiry whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquiry whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquiry whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquiry whereLivingCountryCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquiry whereContent($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquiry whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Inquiry whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Inquiry extends Base
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'inquiries';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'user_id',
        'name',
        'email',
        'living_country_code',
        'content',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden    = [];

    protected $dates     = [];

    protected $presenter = \App\Presenters\InquiryPresenter::class;

    // Relations
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo(\App\Models\Country::class, 'living_country_code', 'code');
    }

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'                  => $this->id,
            'type'                => $this->type,
            'user_id'             => $this->user_id,
            'name'                => $this->name,
            'email'               => $this->email,
            'living_country_code' => $this->living_country_code,
            'content'             => $this->content,
        ];
    }
}
