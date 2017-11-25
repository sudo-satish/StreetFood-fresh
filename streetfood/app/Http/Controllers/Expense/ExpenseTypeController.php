<?php

namespace App\Http\Controllers\Expense;

use Illuminate\Http\Request;
use App\Http\Controllers\DefaultController;

class ExpenseTypeController extends DefaultController
{
    public function __construct() {
        parent::__construct();
        $this->dbClassName = 'App\Models\Expense\expense_type_m';
        $this->resourceName = 'expense.expense-type';
        //$this->resourceVariabl = 'post';
        //$this->memberObj = $member;
        //$this->middleware('account')->only('edit');
        $this->middleware('admin')->only('destroy');
        $this->validateFldArr = [
            'name' => 'required',
        ];
        //$usersList = User::where('account_access','Y')->orderby('id','desc')->pluck('username','id')->toArray();

    }
}
