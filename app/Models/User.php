<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\UserStatusEnum;
use App\Enums\UserTypeEnum;
use App\Models\Campus;
use App\Models\Document;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Contracts\JWTSubject;


class User extends Authenticatable implements JWTSubject
{
    use  HasFactory,Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>;
     */
    protected $fillable = [
        'name',
        'username',
        'user_type',
        'email',
        'contact_no',
        'password',
        'address_id',
        'status',
        'emergency_contact_name',
        'emergency_contact_number',
        'birth_mark',
        'medical_conditions',
        'allergies',
        'nationality',
        'guardian_type',
        'department_id',
        'designation_id',
        'gender',
        'caste',
        'religion',
        'doj',
        'dob',
        'aadhaar_no',
        'pan_no',
        'passport_no',
        'profile_document_id',
        'language',
        'code',
        'bank_name',
        'account_holder_name',
        'bank_account_no',
        'bank_ifsc',
        'bank_branch',
        'campus_id',
        'academic_session_id',
        'academic_class_id',
        'admission_no',
        'admission_date',
        'education',
        'occupation',
        'earnings'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>;
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>;
     */
    protected $casts = [
        'username' => 'string',
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'user_type' => UserTypeEnum::class,
        'status' => UserStatusEnum::class,
    ];
    //Hello World......
    public function profile_document()
    {
        return $this->belongsTo(Document::class, 'profile_document_id');
    }
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }
    // public function address()
    // {
    //     return $this->belongsTo(Address::class);
    // }
    public function campus()
    {
        return $this->belongsTo(Campus::class);
    }
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
    public function academic_session()
    {
        return $this->belongsTo(AcademicSession::class);
    }

    public function academic_class()
    {
        return $this->belongsTo(AcademicClass::class);
    }
    // public function students()
//     {
//         return $this->belongsToMany(User::class, 'student_guardian', 'guardian_id', 'student_id');
//     }
    public function student_sessions()
    {
        return $this->hasMany(StudentSession::class, 'student_id', 'id');
    }

    // public function student_session()
    // {
    //     $allSessions=$this->hasMany(StudentSession::class, 'student_id', 'id');
    //     return $allSessions->latest();
    // }

    public function guardians()
    {
        return $this->belongsToMany(User::class, 'student_guardian', 'student_id', 'guardian_id');
    }
    protected static function boot()
    {
        parent::boot();

        // Listen for the 'creating' event to set default values before a user is created

        static::creating(function ($user) {
            $username = $user->username ?? Str::slug(static::setUnAttribute($user->attributes['name']));
            $user->attributes['username'] = $username;
            $user->attributes['user_type'] = $user->user_type ?? 'student';
            $user->attributes['password'] = $user->password ?? Hash::make('password');

        });
    }

    // protected static function setUsernameAttribute($value)
    protected static function setUnAttribute($value)
    {

        // Generate a 10-character username based on the user's name
        //allow only alphabet
        $value = preg_replace('/[^a-zA-Z0-9]+/', '', $value);
        $baseUsername = strtolower(substr(str_replace(' ', '', $value), 0, 6));

        // If the username exists, append a random number to make it unique
        do {
            // Generate a random number
            $randomNumber = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            // Append the random number to the base username
            $username = $baseUsername . $randomNumber;
            // Check if the newly generated username exists
            $count = User::where('username', $username)->count();
        } while ($count > 0); // Loop until a unique username is found

        return $username;
    }

    // Rest omitted for brevity

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
