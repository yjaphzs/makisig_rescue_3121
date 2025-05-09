<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Item;
use App\Citizen;
use DB;

class ItemsController extends Controller
{
    public function index()
    {
        return view('items');
    }

    public function fetchdata(Request $request){
        $id = $request->input('id');
        $item = Item::find($id);
        $output = array(
            'ownerID' => $item->owner,
            'items' => $item->items,
            'remarks' => $item->remarks
        );

        echo json_encode($output);
    }

    public function postdata(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'owner' => 'required',
            'items' => 'required'
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
                $item = new Item([
                    'owner' => $request->get('ownerID'),
                    'items' => $request->get('items'),
                    'remarks' => $request->get('remarks')
                ]);

                $item->save();
                $success_output = 'Data Inserted';
            }

            if($request->get('button_action') == 'update'){
                $item = Item::find($request->get('item_id'));
                $item->owner = $request->get('ownerID');
                $item->items = $request->get('items');
                $item->remarks = $request->get('remarks');

                $item->save();
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
        $item = Item::find($request->input('id'));
        if($item->delete()){
             echo 'Data deleted';
        }

    }

    public function massremove(Request $request){
        $item_array = $request->input('id');
        $item = Item::whereIn('id', $item_array);
        if($item->delete()){
            echo 'deleted';
        }
    }

    public function getdata(Request $request){
        $query = $request->get('query');
        $orderBy = $request->get('orderBy');
        $data = Item::where('owner','like','%'.$query.'%')
                ->orWhere('items','like','%'.$query.'%')
                ->orWhere('remarks','like','%'.$query.'%')
                ->orderby($orderBy,'asc')
                ->paginate(10);
        $data2 = Citizen::all();
        return view('items_data', compact('data'))->with('data2',$data2);
    }

    public function persons(Request $request){
        $query = $request->get('query');
        $data = Citizen::where('last_name','like','%'.$query.'%')
                ->orWhere('first_name','like','%'.$query.'%')
                ->orWhere('middle_initial','like','%'.$query.'%')
                ->orWhere('gender','like','%'.$query.'%')
                ->orWhere('barangay','like','%'.$query.'%')
                ->get();
        return view('owners', compact('data'));
    }

    public function getName(Request $request){
        $id = json_decode($request->get('id'));
        //$citizen = Citizen::find("21");
        //echo $citizen;
        $citizen = Citizen::find($id);
        $output = $citizen->first_name.' '.$citizen->last_name;

        $data = $output;
        echo json_encode($data);
    }
}
