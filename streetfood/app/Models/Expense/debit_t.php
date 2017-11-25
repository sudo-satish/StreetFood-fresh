<?php

namespace App\Models\Expense;

use Illuminate\Database\Eloquent\Model;

class debit_t extends Model
{
    protected $table = 'debit_t';
    protected $fillable = [
       'spent_by_user_id', 'expense_type_id', 'amount', 'date', 'purpose', 'other_note'
    ];

    public function user()
    {
        return $this->belongsTo('App\User', 'spent_by_user_id');
        //return $this->belongsTo('App\User', 'amount');
    }
    public function expenseType() {
        return $this->belongsTo('App\Models\Expense\expense_type_m', 'expense_type_id');
    }
}
