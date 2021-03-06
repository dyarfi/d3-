<?php namespace App\Modules\User\Model;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Mpociot\Teamwork\Traits\UserHasTeams;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

	use Authenticatable, CanResetPassword, UserHasTeams;

	// Soft deleting a model, it is not actually removed from your database.
    use SoftDeletes;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name','username','first_name','last_name','email','avatar','image','provider_id','provider','about','attributes','password','status','current_team_id'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

    // Instead, a deleted_at timestamp is set on the record.
    protected $dates = ['deleted_at'];

    /**
	 * The attributes that should be casted to native types.
	 *
	 * @var array
	 */
	protected $casts = [
	    'attributes'  => 'object',
	    'permissions' => 'array'
	    // 'is_admin' => 'boolean',
	];

	/**
	 * A user can have many logs.
	 *
	 */
	public function logs()
	{
		return $this->hasMany('App\Modules\Blog\Model\Log','user_id');
	}

	/**
	 * A user can have many tasks.
	 *
	 */
	public function tasks()
	{
		return $this->hasMany('App\Modules\Task\Model\Task','user_id');
	}

	/**
	 * A user can have many blogs.
	 *
	 */
	public function blogs()
	{
		return $this->hasMany('App\Modules\Blog\Model\Blog','user_id');
	}

	/**
	 * A user can have one roles.
	 *
	 */
	public function roles()
	{
		//return $this->hasOne('App\Db\RoleUser');
		return $this->belongsToMany('App\Modules\User\Model\Role','role_users');

	}

	/**
	 * A user can have many teams.
	 *
	 */
	public function teams()
	{
		//return $this->hasOne('App\Db\RoleUser');
		return $this->belongsToMany('App\Modules\User\Model\Team','team_user','user_id','team_id');

	}

	// Scope query for active status field
    public function scopeActive($query) {

      return $query->where('status', 1);

    }

}
