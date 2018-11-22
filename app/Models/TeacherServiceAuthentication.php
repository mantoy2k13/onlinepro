<?php
namespace App\Models;

/**
 * App\Models\TeacherServiceAuthentication.
 *
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $email
 * @property string $service
 * @property int $service_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherServiceAuthentication whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherServiceAuthentication whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherServiceAuthentication whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherServiceAuthentication whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherServiceAuthentication whereService($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherServiceAuthentication whereServiceId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherServiceAuthentication whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\TeacherServiceAuthentication whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TeacherServiceAuthentication extends Base
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'teacher_service_authentications';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'email',
        'service',
        'service_id',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    protected $dates  = [];

    protected $presenter = \App\Presenters\TeacherServiceAuthenticationPresenter::class;

    // Relations

    // Utility Functions

    /*
     * API Presentation
     */
    public function toAPIArray()
    {
        return [
            'id'         => $this->id,
            'user_id'    => $this->user_id,
            'name'       => $this->name,
            'email'      => $this->email,
            'service'    => $this->service,
            'service_id' => $this->service_id,
        ];
    }
}
