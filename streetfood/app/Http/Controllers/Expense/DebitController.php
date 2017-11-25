<?php

namespace App\Http\Controllers\Expense;

use Illuminate\Http\Request;
//use App\Http\Controllers\Controller;
use App\Http\Controllers\DefaultController;
use App\User;
use App\Models\Expense\credit_t;
use App\Models\Expense\expense_type_m;

class DebitController extends DefaultController
{
    public function __construct() {
        parent::__construct();
        $this->dbClassName = 'App\Models\Expense\debit_t';
        $this->resourceName = 'expense.debit';
        //$this->resourceVariabl = 'post';
        //$this->memberObj = $member;
        //$this->middleware('account')->only('edit');
        $this->middleware('admin')->only('destroy');
        $this->validateFldArr = [
            'spent_by_user_id' => 'required',
            'amount' => 'required',
            'expense_type_id' => 'required',
        ];
        //$usersList = User::where('account_access','Y')->orderby('id','desc')->pluck('username','id')->toArray();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $resourceName = $this->resourceName;
        $usersList = User::where('account_access','Y')->orderby('id','desc')->pluck('username','id')->toArray();
        $expenseType = expense_type_m::all()->pluck('name','id')->toArray();
        return view($this->resourceName.'.create', compact('resourceName', 'usersList', 'expenseType'));
     }

     /**
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function edit($id) {
         $resourceName = $this->resourceName;
         $dbObj = new $this->dbClassName();
         //$sum = $dbObj->sum('amount')->toArray();
         //dd($sum);
         $member =  $dbObj->find($id);
         $usersList = User::where('account_access','Y')->orderby('id','desc')->pluck('username','id')->toArray();
         $expenseType = expense_type_m::all()->pluck('name','id')->toArray();
         return view($this->resourceName.'.edit',compact('member', 'resourceName', 'usersList', 'expenseType'));
     }

     public function index() {
         //dd(Member);
         //var_dump(Member); exit;
         //$dbObj = new $this->dbClassName();
         //$debit = new $this->dbClassName();
         //$result = $debit->find(1);
        // dd($result->user->name);
        //DB::select('select amount from student (name) values(?)',[$name]);
        //$credit = DB::select('SELECT SUM(amount) sum FROM credit_t');
        //$debit = DB::select('SELECT SUM(amount) sum FROM debit_t');
        $debit = $this->dbClassName::all()->sum('amount');
        $credit = credit_t::all()->sum('amount');
        //echo $debit .'/'.$credit; exit;
        $chartData = array(array('label' => 'Credit', 'value' => $credit), array('label' => 'Debit', 'value' => $debit));
        //print_r($chartData);
        $debitTlbObj = new $this->dbClassName();
        $resourceName = $this->resourceName;
        $members = $this->dbClassName::latest()->paginate(2);
        //dd($members->user->name);
        return view($this->resourceName.'.index',compact('members','resourceName', 'chartData'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }
}
