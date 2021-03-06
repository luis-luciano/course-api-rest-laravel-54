<?php

namespace App;

use App\Transformers\UserTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verification_token',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'verification_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_admin' => 'boolean',
        'verified' => 'boolean',
    ];

    public $transformer = UserTransformer::class;

    /**
     * Generate random token
     * @return string
     */
    public function generateVerificationToken()
    {
        if (empty($this->verification_token)) {
            $this->verified = false;
            $this->verification_token = str_random(40);
        }

        return $this;
    }

    /**
     * [createDefault description]
     * @param  array  $data
     * @return \App\User $user | null
     */
    public static function createDefault(array $data)
    {
        $user = new static($data);
        $user->generateVerificationToken();

        // for default set as non-administrator and not verified
        $user->is_admin = false;

        return $user->save() ? $user : null;
    }

    // Mutators -----------------------------------------------------------------------------

    public function setNameAttribute($name)
    {
        $this->attributes['name'] = strtolower($name);
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);

        return $this;
    }

    // End Mutators -------------------------------------------------------------------------

    // Accesors -----------------------------------------------------------------------------

    public function getNameAttribute($value)
    {
        return ucwords($value);
    }

    public function getEmailChangedAttribute()
    {
        return $this->isDirty('email');
    }

    // End Accessors  ----------------------------------------------------------------------
}
