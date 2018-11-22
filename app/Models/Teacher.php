<?php
namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * App\Models\Teacher.
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $skype_id
 * @property string $rating
 * @property string $locale
 * @property int $last_notification_id
 * @property int $profile_image_id
 * @property int $status
 * @property int $year_of_birth
 * @property string $gender
 * @property string $living_country_code
 * @property int $living_city_id
 * @property \Carbon\Carbon $living_start_date
 * @property string $self_introduction
 * @property string $introduction_from_admin
 * @property string $hobby
 * @property string $nationality_country_code
 * @property int $home_province_id
 * @property string $bank_account_info
 * @property \Carbon\Carbon $deleted_at
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Personality[] $personalities
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Lesson[] $lessons
 * @property-read \App\Models\Image $profileImage
 * @property-read \App\Models\Province $homeProvince
 * @property-read \App\Models\Country $nationalityCountry
 * @property-read \App\Models\Country $livingCountry
 * @property-read \App\Models\City $livingCity
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Review[] $reviews
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\TimeSlot[] $timeSlots
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\FavoriteTeacher[] $favorites
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereSkypeId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereRating($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereLocale($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereLastNotificationId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereProfileImageId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereYearOfBirth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereGender($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereLivingCountryCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereLivingCityId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereLivingStartDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereSelfIntroduction($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereIntroductionFromAdmin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereHobby($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereNationalityCountryCode($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereHomeProvinceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereBankAccountInfo($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher whereUpdatedAt($value)
 * @mixin \Eloquent
 *
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Teacher withoutTrashed()
 */
class Teacher extends AuthenticatableBase
{
    use SoftDeletes;

    const STATUS_TEACHER_DELETED = 'deleted';
    const STATUS_TEACHER_ALL     = 'all';
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'teachers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'skype_id',
        'rating',
        'locale',
        'last_notification_id',
        'profile_image_id',
        'year_of_birth',
        'gender',
        'status',
        'living_country_code',
        'living_city_id',
        'living_start_date',
        'self_introduction',
        'introduction_from_admin',
        'hobby',
        'nationality_country_code',
        'home_province_id',
        'bank_account_info',
        'remember_token',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = ['deleted_at', 'living_start_date'];

    protected $presenter = \App\Presenters\TeacherPresenter::class;

    // Relations

    public function personalities()
    {
        return $this->belongsToMany(\App\Models\Personality::class, \App\Models\TeacherPersonality::getTableName(), 'teacher_id', 'personality_id');
    }

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

    public function reviews()
    {
        return $this->hasMany(\App\Models\Review::class, 'teacher_id', 'id');
    }

    public function timeSlots()
    {
        return $this->hasMany(\App\Models\TimeSlot::class, 'teacher_id', 'id');
    }

    public function favorites()
    {
        return $this->hasMany(\App\Models\FavoriteTeacher::class, 'teacher_id', 'id');
    }

    public function lessons()
    {
        return $this->hasMany(\App\Models\TeacherLesson::class, 'teacher_id', 'id');
    }

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'                       => $this->id,
            'name'                     => $this->name,
            'email'                    => $this->email,
            'password'                 => $this->password,
            'skype_id'                 => $this->skype_id,
            'rating'                   => $this->rating,
            'locale'                   => $this->locale,
            'last_notification_id'     => $this->last_notification_id,
            'profile_image_id'         => $this->profile_image_id,
            'year_of_birth'            => $this->year_of_birth,
            'gender'                   => $this->gender,
            'living_country_code'      => $this->living_country_code,
            'living_start_date'        => $this->living_start_date,
            'self_introduction'        => $this->self_introduction,
            'introduction_from_admin'  => $this->introduction_from_admin,
            'hobby'                    => $this->hobby,
            'nationality_country_code' => $this->nationality_country_code,
            'home_province_id'         => $this->home_province_id,
            'bank_account_info'        => $this->bank_account_info,
            'living_city_id'           => $this->living_city_id,
            'remember_token'           => $this->remember_token,
        ];
    }
}
