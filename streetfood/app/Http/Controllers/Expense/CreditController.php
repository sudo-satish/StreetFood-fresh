<?php

namespace App\Http\Controllers\Expense;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Expense\credit_t;
use App\Http\Controllers\DefaultController;

use App\User;

class CreditController extends DefaultController
{
    public function __construct() {
        parent::__construct();
        $this->middleware('account');
        $this->dbClassName = 'App\Models\Expense\credit_t';
        $this->resourceName = 'expense.credit';
        //$this->resourceVariabl = 'post';
        //$this->memberObj = $member;
        //$this->middleware('account')->only('edit');
        $this->middleware('admin')->only('destroy');
        $this->validateFldArr = [
            'borrowed_from_user_id' => 'required',
            'amount' => 'required',
            'date' => 'required',
            'purpose' => 'required',
        ];
        //$usersList = User::where('account_access','Y')->orderby('id','desc')->pluck('username','id')->toArray();

    }

    public function index() {

        $usersList = User::where('account_access','Y')->orderby('id','desc')->pluck('username','id')->toArray();
        $creditTblObj = credit_t::find(1);
        //$userName = $creditTblObj->user->username;
        //$bor = $creditTblObj->borrowedFrom->username;

        //echo 'User :=> '. $userName. '<br>'.'Borrowed From :=>'.$bor;
        //$creditTblObj = new credit_t;
       /* foreach($userList as $index => $name) {
                echo 'ID : '.$index
        }*/
        $resourceName = $this->resourceName;
        $members = $this->dbClassName::latest()->paginate(2);
        //dd($members->user->name);
        return view($this->resourceName.'.index',compact('members','resourceName', 'creditTblObj', 'usersList'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
        //return view('expense/credit/index',compact('usersList', 'creditTblObj'));
    }

    public function edit($id) {
        $resourceName = $this->resourceName;
        $dbObj = new $this->dbClassName();
        $member =  $dbObj->find($id);
        $usersList = User::where('account_access','Y')->orderby('id','desc')->pluck('username','id')->toArray();
        return view($this->resourceName.'.edit',compact('member', 'resourceName', 'usersList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create() {
        //$usersList = User::where('account_access','Y')->orderby('id','desc')->pluck('username','id')->toArray();
        $resourceName = $this->resourceName;
        $usersList = User::where('account_access','Y')->orderby('id','desc')->pluck('username','id')->toArray();
        return view($this->resourceName.'.create', compact('resourceName', 'usersList'));
     }

     public function store(Request $request)  {
         $resourceName = $this->resourceName;
         request()->validate($this->validateFldArr);
         $request->user_id = Auth::id();
         $all = $request->all();
         $all['user_id'] = Auth::id();
        //var_dump();
        // var_dump($all); exit;
          $this->dbClassName::create($all);
         return redirect()->route($this->resourceName.'.index', compact('resourceName'))
                         ->with('success','Member created successfully');
     }


    /*
    public function save(Request $request) {


        if(!empty($request->id)) {
            $creditTblObj = credit_t::find($request->id);
        } else {
            $creditTblObj = new credit_t();
        }
        $creditTblObj->user_id = Auth::id();
        $creditTblObj->borrowed_from_user_id = $request->borrowed_from_user_id;
        $creditTblObj->amount = $request->amount;
        $creditTblObj->date = $request->date;
        $creditTblObj->purpose = $request->purpose;
        $creditTblObj->other_note = $request->other_note;

        $creditTblObj->save();
    }

    public function edit(Request $request, $option) {
        dd($option);
        $creditTblObj = new credit_t();
        $creditTblObj->user_id = Auth::id();
        $creditTblObj->borrowed_from_user_id = $request->borrowed_from_user_id;
        $creditTblObj->amount = $request->amount;
        $creditTblObj->date = $request->date;
        $creditTblObj->purpose = $request->purpose;
        $creditTblObj->other_note = $request->other_note;

        $creditTblObj->save();
    }
    public function histroy(Request $request, $option) {
        return true;
    }

    public function show(credit_t $id) {
        return view('expense.credit.show', compact('id'));
    }

    public function store(Request $request) {
        $input = $request->all();

        credit_t::create($input);

        return redirect()->back();
    }
    */
}
