<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\UserChild;

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
        $uid = Auth::user()->id;
        $request->validate([
            'name' => 'required|string',
            'password' => $request->password ? 'required|min:6' : '',
        ]);

        $uid = $request->uid;
        // dd($uid);

        $user = User::where('id', $uid)->firstOrFail();
        if($request->password){
            $user->update([
                'name' => $request->name,
                'password' =>$request->password,
            ]);

            $message = "User Created successfull";

        }

        if($request->parent_id){
            self::updateParent($uid,$request->parent_id);
            $message = "User parent updated successfully";
        }

        return redirect()->back()->withSuccess($message);
    }

    public function updateProfile(Request $request) {
        $uid = Auth::user()->id;
        $user = User::where('id', $uid)->firstOrFail();
    
        $user->update([
            'name' => Auth::user()->name,
            'email' => $request->email,
            'mobile_no' => $request->mobile_no,
            'employee_id' => Auth::user()->employee_id,
            'parent_id' => $request->parent_id,
        ]);
    
        if ($request->parent_id) {
            self::updateParent($uid,$request->parent_id);
        }
    
        $message = "Details Updated";
        return redirect()->back()->withSuccess($message);
    }

    public static function updateParent($uid,$parent_id){
        $currentParentChild = UserChild::where('child_id', $uid)->first();
            
            if ($currentParentChild) {
                if ($currentParentChild->parent_id != $parent_id) {
                    $currentParentChild->delete();
    
                    $newParentChild = new UserChild;
                    $newParentChild->parent_id = $parent_id;
                    $newParentChild->child_id = $uid;
                    $newParentChild->save();
                }
            } else {
                $newParentChild = new UserChild;
                $newParentChild->parent_id = $parent_id;
                $newParentChild->child_id = $uid;
                $newParentChild->save();
            }
    }


    public function userProfilePasswordUpdate(Request $request){

        $uid = Auth::user()->id;

        $user = User::where('id', $uid)->firstOrFail();
        $user->password = $request->new_password;
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
        if (!empty($user) && $user->password == $request->password) {
            if(!$user->status){
                return redirect()->back()->withErrors('Credentials status is pending (not approve yet)');
            }

            if(!$user->is_active){
                return redirect()->back()->withErrors('You are inactive ! Please conncet with Admin');
            }

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
        $users = User::with('userParent')->paginate(10);
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
        $users = User::activeUser()->get();

        return view('admin_pages.user_profile',compact('user','users'));
    }

    public function userParentAssign(User $user ,$uid){
        $user = $user->find($uid);
        return view('admin_pages.user_profile',compact('user'));
    }

    public function userProfile(){
        $users = User::all();
        return view("user.profile",compact('users')); 
    }
}
