<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Citizen;
use DB;


class CitizenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('citizens');
    }
    /*
    public function getdata(){
        $citizens = Citizen::select('last_name','first_name');
        return Datatables::of($citizens)->make(true);
    }

    */

    public function fetchdata(Request $request){
        $id = $request->input('id');
        $citizen = Citizen::find($id);
        $output = array(
            'last_name' => $citizen->last_name,
            'first_name' => $citizen->first_name,
            'middle_initial' => $citizen->middle_initial,
            'gender' => $citizen->gender,
            'barangay' => $citizen->barangay
        );

        echo json_encode($output);
    }

    public function postdata(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'last_name' => 'required',
            'first_name' => 'required',
            'gender' => 'required',
            'barangay' => 'required'
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
                $citizen = new Citizen([
                    'last_name' => $request->get('last_name'),
                    'first_name' => $request->get('first_name'),
                    'middle_initial' => $request->get('middle_initial'),
                    'gender' => $request->get('gender'),
                    'barangay' => $request->get('barangay')
                ]);

                $citizen->save();
                $success_output = 'Data Inserted';
            }

            if($request->get('button_action') == 'update'){
                $citizen = Citizen::find($request->get('citizen_id'));
                $citizen->last_name = $request->get('last_name');
                $citizen->first_name = $request->get('first_name');
                $citizen->middle_initial = $request->get('middle_initial');
                $citizen->gender = $request->get('gender');
                $citizen->barangay = $request->get('barangay');

                $citizen->save();
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
        $citizen = Citizen::find($request->input('id'));
        if($citizen->delete()){
             echo 'Data deleted';
        }

    }

    public function massremove(Request $request){
        $citizen_array = $request->input('id');
        $citizen = Citizen::whereIn('id', $citizen_array);
        if($citizen->delete()){
            echo 'deleted';
        }
    }

    public function getdata(Request $request){

            $query = $request->get('query');
            $orderBy = $request->get('orderBy');
                $data = Citizen::where('last_name','like','%'.$query.'%')
                        ->orWhere('first_name','like','%'.$query.'%')
                        ->orWhere('middle_initial','like','%'.$query.'%')
                        ->orWhere('gender','like','%'.$query.'%')
                        ->orWhere('barangay','like','%'.$query.'%')
                        ->orderBy($orderBy, 'asc')
                        ->paginate(10);
                return view('records_data', compact('data'));
    }
}
