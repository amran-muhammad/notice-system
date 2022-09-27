<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\Event;
use App\Models\Complain;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class NoticeController extends Controller
{
    public function get_notices(Request $request)
    {
        $user = Auth::user();

        $data = array();
        if ($user) {
            $data = Notice::where('department_name', null)->orderBy('id','DESC')->get();
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
    public function get_events(Request $request)
    {
        $user = Auth::user();

        $data = array();
        if ($user) {
            $data = Event::orderBy('id','DESC')->get();
        }
        
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
            
            Complain::where('id', $request->id)->delete();
            
            return response()->json([
                'data' => true
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
}
