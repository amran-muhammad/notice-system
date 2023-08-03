<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\Event;
use App\Models\Chat;
use App\Models\Complain;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;


class NoticeController extends Controller
{
    public function get_home_data(Request $request)
    {
        $notice = Notice::where('department_name', null)->orderBy('id','DESC')->limit(1)->get();
        $teacher = User::where('type', 'TEACHER')->orderBy('id','DESC')->limit(3)->get();  
        return response()->json([
            'notice' => $notice,
            'teacher' => $teacher
        ]);
    }
    public function get_notices(Request $request)
    {
        $user = Auth::user();

        if($user && $user->type != 'Student' ){
            $data = Notice::where('department_name', null)->orderBy('id','DESC')->get();  
        }
        else{
            $data = Notice::where('department_name', null)->where('status', 'Approved')->orderBy('id','DESC')->get();  
        }
        return response()->json([
            'data' => $data
        ]);
    }
    public function get_complains(Request $request)
    {
        $user = Auth::user();

        $data = array();
        if ($user) {
            $data = Complain::orderBy('id','DESC')->get();
        }
        
        return response()->json([
            'data' => $data
        ]);
    }
    public function get_complains_count(Request $request)
    {
        $data = Complain::count();
        $notification = false;
        if($request->old_total < $data){
            $notification = true;
        }
        return response()->json([
            'data' => $notification,
            'new_total' => $data
        ]);
    }
    public function get_events(Request $request)
    {
        $data = array();
        $data = Event::orderBy('id','DESC')->get();
        return response()->json([
            'data' => $data
        ]);
    }
    public function search_notices(Request $request)
    {
        $user = Auth::user();

        $data = array();
        if ($user) {
            $search_data = $request->all();
            $search_obj = array();
            if(isset($search_data['department_name'])){
               $search_obj['department_name'] = $search_data['department_name'];
            }
            if(isset($search_data['class_name'])){
               $search_obj['class_name'] = $search_data['class_name'];
            }
            if(isset($search_data['section'])){
               $search_obj['section'] = $search_data['section'];
            }
            $data = Notice::where($search_obj)->orderBy('id','DESC')->get();
        }
        
        return response()->json([
            'data' => $data
        ]);
    }
    public function search_complains(Request $request)
    {
        $user = Auth::user();

        $data = array();
        if ($user) {
            $search_data = $request->all();
            $search_obj = array();
            if(isset($search_data['type'])){
               $search_obj['type'] = $search_data['type'];
            }
            if($search_data['type']=='All'){
                $data = Complain::orderBy('id','DESC')->get();
            }
            else{
                $data = Complain::where($search_obj)->orderBy('id','DESC')->get();
            }
        }
        
        return response()->json([
            'data' => $data
        ]);
    }

    public function create_notice(Request $request)
    {
        $user = Auth::user();

        if ($user && ($user->type == 'Admin' || $user->type == 'Teacher')) {
            $form = new Notice();
            $form->title = $request->title;
            $form->department_name = $request->department_name;
            $form->class_name = $request->class_name;
            $form->section = $request->section;
            $form->image = $request->image;
            $form->user_id = $user->id;
            $form->save();
            return response()->json([
                'data' => $form
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }
    public function create_complain(Request $request)
    {
        $user = Auth::user();

        if ($user && $user->type == 'Student') {
            $form = new Complain();
            $form->complain = $request->complain;
            $form->type = $request->type;
            $form->save();
            return response()->json([
                'data' => $form
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }
    public function create_event(Request $request)
    {
        $user = Auth::user();

        if ($user && ($user->type == 'Admin')) {
            $form = new Event();
            $form->title = $request->title;
            $form->description = $request->description;
            $form->start_date = $request->start_date;
            $form->end_date = $request->end_date;
            $form->image = $request->image;
            $form->save();
            return response()->json([
                'data' => $form
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }

    public function file_upload(Request $request){
        $image = $request->file('old_file');
        $fileName = time().'.'.$image->getClientOriginalExtension();
    
        $image->move(public_path('uploads/notices'), $fileName);
        return response()->json([
            'msg' => 'Resume is uploaded succuessfully',
            'data' => '/'.'uploads/notices'.'/'.$fileName
        ],200);
    }
    public function teacher_file_upload(Request $request){
        $image = $request->file('old_file');
        $fileName = time().'.'.$image->getClientOriginalExtension();
    
        $image->move(public_path('uploads/teacher'), $fileName);
        return response()->json([
            'msg' => 'Resume is uploaded succuessfully',
            'data' => '/'.'uploads/teacher'.'/'.$fileName
        ],200);
    }
    public function event_file_upload(Request $request){
        $image = $request->file('old_file');
        $fileName = time().'.'.$image->getClientOriginalExtension();
    
        $image->move(public_path('uploads/events'), $fileName);
        return response()->json([
            'msg' => 'Resume is uploaded succuessfully',
            'data' => '/'.'uploads/events'.'/'.$fileName
        ],200);
    }

    public function update_notice(Request $request)
    {
        $user = Auth::user();

        if ($user && ($user->type == 'Admin' || $user->type == 'Teacher')) {
            $exist = Notice::where('id', $request->id)->first();
            $form = array();
            $form['title'] = $request->title;
            $form['department_name'] = $request->department_name;
            $form['class_name'] = $request->class_name;
            $form['section'] = $request->section;
            $form['image'] = $request->image;
            $exist->update($form);
            return response()->json([
                'data' => $exist
            ]);
            
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }
    public function update_notice_status(Request $request)
    {
        $user = Auth::user();

        if ($user && ($user->type == 'Admin')) {
            $form = array();
            $form['status'] = $request->status;
            $exist = Notice::where('id', $request->id)->update($form);
            $exist = Notice::where('id', $request->id)->first();
            return response()->json([
                'data' => $exist
            ]);
            
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }
    public function update_event(Request $request)
    {
        $user = Auth::user();

        if ($user && ($user->type == 'Admin')) {
            $exist = Event::where('id', $request->id)->first();
            $form = array();
            $form['title'] = $request->title;
            $form['description'] = $request->description;
            $form['start_date'] = $request->start_date;
            $form['end_date'] = $request->end_date;
            $form['image'] = $request->image;
            $exist->update($form);
            return response()->json([
                'data' => $exist
            ]);
            
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }
    public function update_complain(Request $request)
    {
        $user = Auth::user();

        if ($user && ($user->type == 'Admin')) {
            $exist = Complain::where('id', $request->id)->first();
            $form = array();
            $form['answer'] = $request->answer;
            $exist->update($form);
            return response()->json([
                'data' => $exist
            ]);
            
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }

    public function delete_notice(Request $request)
    {
        $user = Auth::user();
        if ($user && ($user->type == 'Admin' || $user->type == 'Teacher')) {
            if ($user->type == 'Teacher') {
                Notice::where('user_id', $user->id)->where('id', $request->id)->delete();
            } else if ($user->type == 'Admin') {
                Notice::where('id', $request->id)->delete();
            }
            return response()->json([
                'data' => true
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }
    public function delete_event(Request $request)
    {
        $user = Auth::user();
        if ($user && $user->type == 'Admin'){
            
            Event::where('id', $request->id)->delete();
            
            return response()->json([
                'data' => true
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }
    public function delete_complain(Request $request)
    {
        $user = Auth::user();
        if ($user && $user->type == 'Admin'){
            
            $data = Complain::where('id', $request->id)->delete();
            
            return response()->json([
                'data' => $data
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }

    public function get_all_notice_for_dashboard(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $teachers = Notice::with('user_details')->get();
            return response()->json([
                'data' => $teachers
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }

    public function find_a_user(Request $request)
    {
        $user = Auth::user();
        $data = array();
        if ($user) {
            if ($request->search == 'All') {
                $data = Notice::with('user_details')->get();
            } else {
                $data = Notice::with('user_details')->where('user_id', '=', $request->search)->orWhere('department', '=', $request->search)->get();
            }
            return response()->json([
                'data' => $data
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }

    public function create_chat(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $form = new Chat();
            $form->message = $request->message;
            if($request->receiver == "Admin"){
                $admin = User::where("type","Admin")->first(); 
                $form->receiver = $admin->id;
            }
            else $form->receiver = $request->receiver;
            $form->sender = $user->id;
            $form->save();
            return response()->json([
                'data' => $form
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }
    

    public function get_chat(Request $request)
    {
        $user = Auth::user();
        $teacher1Id = $user->id;
        $admin = User::where("type","Admin")->first();
        $adminId = $admin->id;
        if ($user) {
            $data = Chat::where(function ($query) use ($adminId, $teacher1Id) {
                $query->where('sender', $adminId)->where('receiver', $teacher1Id);
            })
            ->orWhere(function ($query) use ($adminId, $teacher1Id) {
                $query->where('sender', $teacher1Id)->where('receiver', $adminId);
            })
            ->get();
            return response()->json([
                'data' => $data
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }
    public function get_chat_admin(Request $request)
    {
        $user = Auth::user();
        $adminId = $user->id;
        if($request->teacher){
            $teacher1Id = $request->teacher;
        }else{

            $teacher = User::where('type', 'Teacher')
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
            ->first();
           $teacher1Id = $teacher->id; 
        }
        if ($user) {
            $data = Chat::where(function ($query) use ($adminId, $teacher1Id) {
                $query->where('sender', $adminId)->where('receiver', $teacher1Id);
            })
            ->orWhere(function ($query) use ($adminId, $teacher1Id) {
                $query->where('sender', $teacher1Id)->where('receiver', $adminId);
            })
            ->get();
            return response()->json([
                'data' => $data
            ]);
        } else {
            return response()->json([
                'data' => false
            ]);
        }
    }
}
