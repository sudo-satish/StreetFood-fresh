<?php

namespace App\Models\Expense;

use Illuminate\Database\Eloquent\Model;

class expense_type_m extends Model
{
    protected $table = 'expense_type_m';
    protected $fillable = [
       'name', 'description'
    ];
}
