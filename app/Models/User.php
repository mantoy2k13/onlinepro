<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\User.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $points
 * @property string $skype_id
 * @property int $year_of_birth
 * @property string $gender
 * @property string $living_country_code
 * @property int $living_city_id
 * @property string $locale
 * @property int $last_notification_id
 * @property int $profile_image_id
 * @property int $status
 * @property string $validation_code
 * @property \Carbon\Carbon $deleted_at
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \App\Models\Image $profileImage
 * @property-read \App\Models\Province $homeProvince
 * @property-read \App\Models\Country $nationalityCountry
 * @property-read \App\Models\Country $livingCountry
 * @property-read \App\Models\City $livingCity
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePoints($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereSkypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereYearOfBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereLivingCountryCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereLivingCityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereLocale($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereLastNotificationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereProfileImageId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereValidationCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @property-read \App\Models\UserServiceAuthentication $userServicesAuthentications
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User withoutTrashed()
 */
class User extends AuthenticatableBase
{
    use SoftDeletes;
    const STATUS_NOT_VALIDATED = 0;
    const STATUS_VALIDATED     = 1;

    const STATUS_USER_CONFIRMED     = 'confirmed';
    const STATUS_USER_NOT_CONFIRMED = 'not_confirmed';
    const STATUS_USER_DELETED       = 'deleted';
    const STATUS_USER_ALL           = 'all';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table     = 'users';

    protected $presenter = \App\Presenters\UserPresenter::class;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'locale',
        'remember_token',
        'profile_image_id',
        'last_notification_id',
        'skype_id',
        'year_of_birth',
        'gender',
        'living_country_code',
        'living_city_id',
        'points',
        'status',
        'validation_code',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token', 'facebook_token'];

    protected $dates  = ['deleted_at'];

    public function profileImage()
    {
        return $this->belongsTo(\App\Models\Image::class, 'profile_image_id', 'id');
    }

    public function homeProvince()
    {
        return $this->belongsTo(\App\Models\Province::class, 'home_province_id', 'id');
    }

    public function nationalityCountry()
    {
        return $this->belongsTo(\App\Models\Country::class, 'nationality_country_code', 'code');
    }

    public function livingCountry()
    {
        return $this->belongsTo(\App\Models\Country::class, 'living_country_code', 'code');
    }

    public function livingCity()
    {
        return $this->belongsTo(\App\Models\City::class, 'living_city_id', 'id');
    }

    public function userServicesAuthentications()
    {
        return $this->belongsTo(\App\Models\UserServiceAuthentication::class, 'id', 'user_id');
    }

    /*
     * API Presentation
     */

    public function toAPIArray()
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
        ];
    }
}
