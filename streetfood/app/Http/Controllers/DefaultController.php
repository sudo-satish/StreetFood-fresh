<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DefaultController extends Controller{

    public $response;
    public $error;
    public $messge;
    public function __construct() {
        $this->response = array();
        $this->error = '';
        $this->message = '';
        $this->response['error'] = $this->error;
        $this->response['message'] = $this->message;

        $this->dbClassName = 'App\Member';
        $this->resourceName = 'members';
        //$this->resourceVariabl = 'member';
        //$this->memberObj = $member;
        $this->validateFldArr = [
            'name' => 'required',
            'email' => 'required',
        ];
        $this->includeAccountMiddleware = true;

    }

    public function index() {
        //dd(Member);
        //var_dump(Member); exit;
        //$dbObj = new $this->dbClassName();
        $resourceName = $this->resourceName;
       $members = $this->dbClassName::latest()->paginate(10);
       return view($this->resourceName.'.index',compact('members','resourceName'))
           ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create() {
       $resourceName = $this->resourceName;
        return view($this->resourceName.'.create', compact('resourceName'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request)  {
       $resourceName = $this->resourceName;
       request()->validate($this->validateFldArr);
        $this->dbClassName::create($request->all());
       return redirect()->route($this->resourceName.'.index', compact('resourceName'))
                       ->with('success','Member created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        $resourceName = $this->resourceName;
        $dbObj = new $this->dbClassName();
        $member =  $dbObj->find($id);
        //$member = $this->memberObj->find($var);
        return view($this->resourceName.'.show',compact('member', 'resourceName'));
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
        $member =  $dbObj->find($id);
        return view($this->resourceName.'.edit',compact('member', 'resourceName'));
    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id) {
       $resourceName = $this->resourceName;
       $dbObj = new $this->dbClassName();
       $member =  $dbObj->find($id);
       request()->validate($this->validateFldArr);
       $member->update($request->all());
       return redirect()->route($this->resourceName.'.index', compact('resourceName'))
                       ->with('success','Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        if($this->includeAccountMiddleware) {
            $this->middleware('account');
        }
        $resourceName = $this->resourceName;
        $dbObj = new $this->dbClassName();
        $dbObj::destroy($id);
        return redirect()->route($this->resourceName.'.index', compact('resourceName'))
                        ->with('success','Deleted successfully');
    }

}
