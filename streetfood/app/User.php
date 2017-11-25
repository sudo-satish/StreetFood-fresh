<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getUserType() {
      return $this->usertype;
    }
    public function getAccountAccess() {
      return $this->account_access;
    }
    public function getUserName() {
        return $this->username;
    }
    public function getUserId() {
        return $this->id;
    }

    public function debit()
    {
        return $this->hasMany('App\Models\Expense\debit_t', 'spent_by_user_id');
    }
    public function credit()
    {
        return $this->hasMany('App\Models\Expense\credit_t', 'borrowed_from_user_id');
    }

}
