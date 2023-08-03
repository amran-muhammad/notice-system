<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Mail\SendToken;
use Illuminate\Support\Str;
use Mail;
use DB;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if ($user->status == 'Pending') {
                $success = false;
                $message = "You are not approved yet by admin!";
            } else {
                if (Auth::attempt($credentials)) {
                    $success = true;
                    $message = "User login successfully";
                } else {
                    $success = false;
                    $message = "Entered Wrong Password!";
                }
            }
        } else {
            $success = false;
            $message = "Entered Wrong Email!";
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);
    }


    public function register(Request $request)
    {
        try {
            $exist = User::where('email',$request->email)->first();
            if($exist){
                $success = false;
                $message = "Email is already exist";
            }
            else if(!(filter_var($request->email, FILTER_VALIDATE_EMAIL))) {
                $success = false;
                $message = "Invalid email!";
            }
            else{
                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->type = $request->type;
                $user->student_id = $request->student_id;
                $user->course = $request->course;
                $user->department = $request->department;
                $user->save();

                $success = true;
                $message = "User register successfully";
            }
            
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);
    }


    public function logout()
    {
        try {
            Session::flush();
            $success = true;
            $message = "Logout successfully";
        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = $ex->getMessage();
        }

        $response = [
            'success' => $success,
            'message' => $message
        ];

        return response()->json($response);
    }
    public function get_all_teacher(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $teachers = array();
            if($request->department == 'All'){
                $teachers = User::where('type', 'Teacher')->get();
            }
            else $teachers = User::where('type', 'Teacher')->where('department',$request->department)->get();
            return response()->json([
                'data' => $teachers
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }
    public function get_all_teacher_chat(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $adminId = $user->id;

        $teachers = User::where('type', 'Teacher')
            ->select('users.*')
            ->leftJoin('chats', function ($join) use ($adminId) {
                $join->on(function ($query) {
                        $query->where('chats.sender', '=', DB::raw('users.id'))
                            ->orWhere('chats.receiver', '=', DB::raw('users.id'));
                    })
                    ->where(function ($query) use ($adminId) {
                        $query->where('chats.sender', '=', $adminId)
                            ->orWhere('chats.receiver', '=', $adminId);
                    });
            })
        ->orderBy('chats.created_at', 'desc')
        ->distinct()
        ->get();
            return response()->json([
                'data' => $teachers
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }
 
    public function get_all_student(Request $request)
    {
        $user = Auth::user();

        if ($user && $user->type == 'Admin') {
            $teachers = User::where('type', 'Student')->get();
            return response()->json([
                'data' => $teachers
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }
    public function create_new_student(Request $request)
    {
        $user = Auth::user();

        if ($user && $user->type == 'Admin') {
            $student = new User();
            $student->name = $request->name;
            $student->email = $request->email;
            $student->password = Hash::make($request->password);
            $student->type = 'Student';
            $student->student_id = $request->student_id;
            $student->status = $request->status;
            $student->department = $request->department;
            $student->save();
            return response()->json([
                'data' => $student
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }
    public function create_new_teacher(Request $request)
    {
        $user = Auth::user();

        if ($user && $user->type == 'Admin') {
            $teacher = new User();
            $teacher->name = $request->name;
            $teacher->email = $request->email;
            $teacher->image = $request->image;
            $teacher->password = Hash::make($request->password);
            $teacher->type = 'Teacher';
            $teacher->course = $request->course;
            $teacher->department = $request->department;
            $teacher->status = $request->status;
            $teacher->save();
            return response()->json([
                'data' => $teacher
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }
    public function update_user(Request $request)
    {
        $user = Auth::user();
        $object_user = array();
        if (isset($request->name)) {
            $object_user['name'] = $request->name;
        }
        if (isset($request->email)) {
            $object_user['email'] = $request->email;
        }
        if (isset($request->image)) {
            $object_user['image'] = $request->image;
        }
        if (isset($request->department)) {
            $object_user['department'] = $request->department;
        }
        if (isset($request->status)) {
            $object_user['status'] = $request->status;
        }
        if (isset($request->course)) {
            $object_user['course'] = $request->course;
        }
        
        if (isset($request->student_id)) {
            $object_user['student_id'] = $request->student_id;
        }
       
        if (isset($request->type)) {
            $object_user['type'] = $request->type;
        }

        $teacher = User::where('id', $request->id)->first();
        if ($user && $user->type == 'Admin') {
            $teacher->update($object_user);
            return response()->json([
                'data' => $teacher
            ]);
        } else if ($user && $request->id == $user->id) {
            $teacher->update($object_user);
            return response()->json([
                'data' => $teacher
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }

    public function update_user_password(Request $request){
        $response = array();
        $response_code = 200;
        $response["status"] = false;
        if(isset($request->all()["email"])){
            $user = User::where('email',$request->all()["email"])->first();
            if($user){
                if (Hash::check($request->all()['old_password'], $user->password)) {
                    $password = Hash::make($request->all()['new_password']);
                    User::where('email',$request->all()["email"])->update(['password'=>$password]);
                    
                    $data = true;
                }else{
                    $data = false;
                }
                
            }else{
                $data = false;
            }  
        }else{
            $data = false;
        }
        return response()->json([
            'data' => $data
        ]);
    }
    public function find_a_user(Request $request)
    {
        $user = Auth::user();

        if ($user && $user->type == 'Admin') {
            $data = array();
            if ($request->type == 'Student') {
                $data = User::where(function ($query) use ($request) {
                    $query->where('type', '=', $request->type);
                })->where(function ($query) use ($request) {
                    $query->where('name', '=', $request->search)
                        ->orWhere('student_id', '=', $request->search)
                        ->orWhere('email', '=', $request->search);
                })->get();
            } else if ($request->type == 'Teacher') {
                $data = User::where(function ($query) use ($request) {
                    $query->where('type', '=', $request->type)->where('department',$request->department);
                })->where(function ($query) use ($request) {
                    $query->where('name', '=', $request->search)
                        ->orWhere('email', '=', $request->search);
                })->get();
            }

            return response()->json([
                'data' => $data
            ]);
        }
    }

    public function delete_user(Request $request)
    {
        $user = Auth::user();
        if ($user && $user->type == 'Admin') {
                User::where('id', $request->id)->delete();
                return response()->json([
                    'data' => true
                ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }

    public function send_verification_code(Request $request){
        if(isset($request->all()["email"])){
            $user = User::where('email',$request->all()["email"])->first();
            if($user){
                $random = Str::random(6);
                // Send this $random to the email 
                $details = [
                    'random' => $random
                ];
                // Send email
                Mail::to($request->all()['email'])->send(new SendToken($details));
                PasswordReset::where('email',$request->all()['email'])->delete();
                PasswordReset::insert([
                    'email'=> $request->all()['email'],
                    'token'=> $random
                ]);
                return response()->json([
                    'success' => true
                ],200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Wrong email entered!'
                ],200);
            }  
        }
        else{
            return response()->json([
                'success' => false,
            ],401);
        } 
    }
    public function check_verification_code(Request $request){
        if(isset($request->all()["email"])){
            $user = PasswordReset::where('email',$request->all()["email"])->where('token',$request->all()["code"])->first();
            if($user){
                return response()->json([
                    'success' => true,
                ],200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Wrong code entered!'
                ],401);
            }  
        }
    }
    public function set_new_password(Request $request){
        if(isset($request->all()["email"])){
            $user = User::where('email',$request->all()["email"])->first();
            if($user){
                    $password = Hash::make($request->all()['password']);
                    User::where('email',$request->all()["email"])->update(['password'=>$password]);
                    return response()->json([
                        'success' => true,
                    ],200);
            }else{
                return response()->json([
                    'success' => false,
                    'message' => 'Password reset fail, try again!'
                ],401);
            }  
        }else{
            return response()->json([
                'success' => false,
            ],401);
        }
    }
}
