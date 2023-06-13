<?php

namespace App\Http\Controllers\Office\Employees;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Office\Employees\Employees;
use App\Models\Office\Permission\Module;
use App\Models\Office\Permission\Permission;
use App\Models\Office\Permission\ModelPermission;
use DB;
use App\Models\Office\Employees\EmployeesLogin;
use App\User;
use App\PermissionUser;
use App\LocationModule;
use App\Models\Office\Shop\Shop;
use Illuminate\Support\Facades\Hash;

class EmployeesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employees::with('usersInfo')->get();
        $module = Module::all();
        // dd($employees);
        return view("office.employees.index",compact('employees','module'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       // dd($request);
        $request->validate([
              'first_name'=>'required',
              'last_name'=>'required',
              'phone_number'=>'required',
              'username' => ['required', 'string', 'max:255'],
              'email' => ['nullable', 'string', 'max:255', 'unique:users'],
              'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $data =   $this->validation($request);

        $data['user_id'] = $this->accountcreate($request);

          Employees::create($data);

        // dd($userLogin['password']);
        return back()->with('success','added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee = Employees::find($id);
        $request->validate([
              'first_name'=>'required',
              'last_name'=>'required',
              'phone_number'=>'required',
              'username' => ['required', 'string', 'max:255'],
              'email' => ['nullable', 'string', 'max:255', 'unique:users,email,'.$id],
              'password' => ['nullable', 'string', 'min:8','confirmed'],
        ]);
        $data =   $this->validation($request);
        $this->accountcreate($request,$employee->user_id);

        // dd($request);
        // $data = $request->validate([
        //         'first_name'=>'required',
        //         'last_name'=>'required',
        //         'phone_number'=>'required'
        // ]);
        // $data['gender'] = $request->gender;
        // $data['email'] = $request->email;
        // $data['address_1'] = $request->address_1;
        // $data['address_2'] = $request->address_2;
        // $data['city'] = $request->city;
        // $data['state'] = $request->state;
        // $data['postcode'] = $request->postcode;
        // $data['country'] = $request->country;
        // $data['comments'] = $request->comments;

        $employee->update($data);
        return back()->with('success','Update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function sendMessage()
    {
        print_r($_POST);
    }

    public function validation($request){
          
          $data['first_name'] = $request->first_name;
          $data['last_name'] = $request->last_name;
          $data['phone_number'] = $request->phone_number;
          $data['gender'] = $request->gender;
          $data['email'] = $request->email;
          $data['address_1'] = $request->address_1;
          $data['address_2'] = $request->address_2;
          $data['city'] = $request->city;
          $data['state'] = $request->state;
          $data['postcode'] = $request->postcode;
          $data['country'] = $request->country;
          $data['comments'] = $request->comments;

         return $data;
    }

    public function accountcreate($request,$id=null){

       $userLogin['name'] = $request->username;
       $userLogin['email'] = $request->email;
       // $userLogin['language'] = $request->language;
        if($id != ""){
            if($request->password !=''){
                $userLogin['password'] = Hash::make($request->password);
            }

            $emLogin = User::find($id)->update($userLogin);
            // return $emLogin;
        }else{
            if($request->password !=''){
                $userLogin['password'] = Hash::make($request->password);
            }

            $emLogin = User::create($userLogin)->id;

        }
        return $emLogin;

           

    }

    public function getPermission($id){
        $data = Permission::with(['module'])->where('moule_id',$id)->get();
        return view('office.employees.show_permission',compact('data'));
    }

    public function permissions_show($id){       
        $data = Permission::with(['module'])->get(); 
        $per = PermissionUser::where('user_id',$id)->get();
        $ids = array();
        foreach($per as $Per){
            $ids[] = $Per->permission_id;
        }
        return view('office.employees.permission.index',compact('data','id','ids'));
    }

    public function get_model_permission(Request $request){
        $user_id = $request->user_id;
        $id = $request->id;
        $per = PermissionUser::where('user_id',$user_id)->get();
        $ids = array();
        foreach($per as $Per){
            $ids[] = $Per->permission_id;
        }

        $data = Permission::with(['module'])->where('moule_id',$id)->get();
        return view('office.employees.permission.show_permission',compact('data','id','user_id','ids'));
    }

    public function give_permission(Request $request){
        // return $request->all();
        $per_id = $request->permission_id;
        $user_id = $request->user_id;
        $model_id = $request->model_id;
        ModelPermission::where(['module_id' =>$model_id,'location_id'=>$user_id])->delete();        

        $user = User::find($user_id);
        $user->syncPermissions($per_id);         
        // $count = 0;
        // while(count($per_id) > $count){
        //     $perm = Permission::find($per_id[$count]);
        //     $data['module_id'] = $perm->moule_id;
        //     $data['location_id'] = $user_id;
        //     $data['permission_id'] = $per_id[$count];
        //     ModelPermission::create($data);     
        //     $count++;
        // }

        return 'Done';         
    }

    public function location_permission($id){
        $module = LocationModule::all();
        // dd($module);
        $data = Shop::all();
        return view('office.employees.permission.show_store',compact('module','data','id'));
    }

    public function getShop(Request $request){
        $module_id = $request->id;
        $user_id = $request->user_id;
        $data = Shop::all();
        $permissions = ModelPermission::where(['module_id'=>$module_id,'location_id'=>$user_id])->get();
        $ids = [];

        foreach ($permissions as $prms) {
            $ids[] = $prms->permission_id;
        }
        return view('office.employees.permission.all_store_list',compact('data','ids','user_id'));
    }

    public function give_shop_permission(Request $request){
        $user_id = $request->user_id;
        $ids = $request->ids;
        $model_id = $request->model_id;
        ModelPermission::where(['module_id'=>$model_id,'location_id'=>$user_id])->delete();
        $count = 0;
        while(count($ids) > $count) {
            ModelPermission::create(['module_id'=>$model_id,'location_id'=>$user_id,'permission_id'=>$ids[$count]]);
            $count++;
        }
        return 'Done';
    }
}
