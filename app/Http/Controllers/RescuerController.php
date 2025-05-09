<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Rescuer;
use DB;

class RescuerController extends Controller
{
    public function index()
    {
        return view('rescuers');
    }

    public function fetchdata(Request $request){
        $id = $request->input('id');
        $rescuer = Rescuer::find($id);
        $output = array(
            'last_name' => $rescuer->last_name,
            'first_name' => $rescuer->first_name,
            'middle_initial' => $rescuer->middle_initial,
            'gender' => $rescuer->gender,
            'contact' => $rescuer->contact
        );

        echo json_encode($output);
    }

    public function postdata(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'last_name' => 'required',
            'first_name' => 'required',
            'gender' => 'required',
            'contact' => 'required'
        ]);

        $error_array = array();
        $success_output = '';
        if($validation->fails()){
            foreach($validation->messages()->getMessages() as $field_name => $messages){
                $error_array[] = $messages;
            }
        }
        else{
            if($request->get('button_action') == 'insert'){
                $rescuer = new Rescuer([
                    'last_name' => $request->get('last_name'),
                    'first_name' => $request->get('first_name'),
                    'middle_initial' => $request->get('middle_initial'),
                    'gender' => $request->get('gender'),
                    'contact' => $request->get('contact')
                ]);

                $rescuer->save();
                $success_output = 'Data Inserted';
            }

            if($request->get('button_action') == 'update'){
                $rescuer = Rescuer::find($request->get('rescuer_id'));
                $rescuer->last_name = $request->get('last_name');
                $rescuer->first_name = $request->get('first_name');
                $rescuer->middle_initial = $request->get('middle_initial');
                $rescuer->gender = $request->get('gender');
                $rescuer->contact = $request->get('contact');

                $rescuer->save();
                $success_output = 'Data Updated';
            }
        }
        $output = array(
            'error' => $error_array,
            'success' => $success_output
        );
        echo json_encode($output);
    }

    public function removedata(Request $request){
        $rescuer = Rescuer::find($request->input('id'));
        if($rescuer->delete()){
             echo 'Data deleted';
        }

    }

    public function massremove(Request $request){
        $rescuer_array = $request->input('id');
        $rescuer = Rescuer::whereIn('id', $rescuer_array);
        if($rescuer->delete()){
            echo 'deleted';
        }
    }
    public function getdata(Request $request){
        $query = $request->get('query');
        $orderBy = $request->get('orderBy');
        $data = Rescuer::where('last_name','like','%'.$query.'%')
                ->orWhere('first_name','like','%'.$query.'%')
                ->orWhere('middle_initial','like','%'.$query.'%')
                ->orWhere('gender','like','%'.$query.'%')
                ->orWhere('contact','like','%'.$query.'%')
                ->orderBy($orderBy, 'asc')
                ->paginate(10);
        return view('rescuers_data', compact('data'));
    }
}
