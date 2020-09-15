<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Profile;
use App\Post;

class User extends Authenticatable
{
    protected $table = "users";

    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $touches = ['posts'];

    /*
    when user created, this will automatically fill the profile with default values.
    */
    public static function boot()
    {
        parent::boot();

        static::created(
            function ($user) {
                $user->profile()->create([
                    'biography' => "Hey there! I'm on dev-overflow", 
                    'profession' => 'Certified genius'
                ]);
            });
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function following()
    {
        return $this->belongsToMany(Profile::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
    }

    public function liked_posts()
    {
        return $this->belongsToMany(Post::class)->orderBy('created_at', 'DESC');
    }

    public function shared_posts()
    {
        return $this->belongsToMany(Post::class, 'post_user_share');
    }
}
