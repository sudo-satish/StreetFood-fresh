<?php

namespace App\Models\Expense;

use Illuminate\Database\Eloquent\Model;

class credit_t extends Model
{   protected $table = 'credit_t';
    protected $fillable = [
        'user_id', 'borrowed_from_user_id', 'amount', 'date', 'purpose', 'other_note'
    ];

    public function borrowedFrom()
    {
        return $this->belongsTo('App\User', 'borrowed_from_user_id');
        //return $this->belongsTo('App\User', 'amount');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
        //return $this->belongsTo('App\User', 'amount');
    }
}
