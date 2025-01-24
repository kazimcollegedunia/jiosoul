<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function registerPage(){
        return view('auth.register');
    }

    public function register(Request $request)
    {

        $request->validate([
            'name' => 'required|string',
            'mobile_no' => 'required|string|digits:10|unique:users,mobile_no,',
            'password' => 'required|min:6',
        ]);

            $parent_id = $this->checkParentId($request->employee_id);

            $uid = $request->uid ?? null;
            if ($request->uid) {

                $user = User::where('id', $uid)->firstOrFail();

                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'mobile_no' => $request->mobile_no,
                    'password' =>$request->password,
                    'employee_id' => $user->employee_id,
                    'parent_id' => $request->parent_id,
                ]);

                $message =  "User profile updated and also password";

            } else {
                $employeeId = $this->createEmployeeID();
                $user = User::create([
                    'name' => $request->name,
                    'email' => $request->email,
                    'mobile_no' => $request->mobile_no,
                    'employee_id' => $employeeId,
                    'password' => $request->password,
                    'parent_id' => $parent_id, 
                ]);

                if (auth()->attempt(['employee_id' => $user->employee_id, 'password' => $request->password])) {
                    return Redirect::route('new.user');
                }

                $message = "User Created successfull";
            }
            return redirect()->back()->withSuccess($message);
    }

    public function changePasswordByadmin(Request $request){
        $request->validate([
            'name' => 'required|string',
            'password' => 'required|min:6',
        ]);

        $uid = $request->uid;
        // dd($uid);

        $user = User::where('id', $uid)->firstOrFail();

        $user->update([
            'name' => $request->name,
            'password' =>$request->password,
        ]);
        
        $message = "User Created successfull";
        
        return redirect()->back()->withSuccess($message);
    }

    public function updateProfile(Request $request){
        $uid = Auth::user()->id;
        // dd($request->all());
        $user = User::where('id', $uid)->firstOrFail();
        // dd($user); 

        $parent_id =  $this->_getParentId($request,$user);

        $user->update([
            'name' => Auth::user()->name,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'employee_id' => Auth::user()->employee_id,
            'parent_id' => $parent_id,
        ]);

        $message = "Details Updated";

        return redirect()->back()->withSuccess($message);
    }

    protected function _getParentId($requestData,$user){
            $parent_id = 1;
            if(isset($requestData->parent_id) && !empty($requestData->parent_id)){
                if(!empty($user) && $user->id !== 1){
                    $parent_id = $requestData->parent_id ? $requestData->parent_id : $user->parent_id;
                }
            }
            return  $parent_id;
    }

    public function userProfilePasswordUpdate(Request $request){

        $uid = Auth::user()->id;

        $user = User::where('id', $uid)->firstOrFail();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->withSuccess('password update');
    }

    public function checkParentId($parent_id){
        $parent_id = strtoupper($parent_id);
        $parentID = false;
        $parentDetails = User::where('employee_id',$parent_id)->first(); 
        if($parentDetails){
            $parentID = $parentDetails->id;
        }

        return $parentID;
    }

    public function createEmployeeID(){
        $employee_id_prefix = "JIO";
        $employee_id_number = 101;

        $user = User::orderBy('id', 'desc')->first();

        if ($user) {
            $last_employee_id_number = (int) substr($user->employee_id, strlen($employee_id_prefix));
            $employee_id_number = $last_employee_id_number + 1;
        }

        $employee_id = $employee_id_prefix . $employee_id_number;

        return $employee_id;
    }

    public function login(Request $request)
    {
        // Validate request data
        $request->validate([
            'employee_id' => 'required',
            'password' => 'required',
        ]);

        // Find the user by employee ID
        $user = User::where('employee_id', $request->employee_id)->first();

        // Check if user exists and password matches
        if ($user && $user->password == $request->password) {
            // Authenticate the user
            auth()->login($user);
            return redirect()->route('user.dashboard');
        }


        // Authentication failed
        return redirect()->back()->withErrors('Invalid credentials');
    }

     public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function userLists(){
        $users = User::paginate(10);
        return view('admin_pages.user_lists',compact('users'));
    }

    public function userStatus($type,$uid){
        $user = User::find($uid);
        $user->$type = !$user->$type;
        $user->save();

        return redirect()->back()->withErrors("User Type Updated");
    }

    public function editProfile(User $user ,$uid){
        $user = $user->find($uid);
        return view('admin_pages.user_profile',compact('user'));
    }

    public function userProfile(){
        $users = User::all();
        return view("user.profile",compact('users')); 
    }
}
