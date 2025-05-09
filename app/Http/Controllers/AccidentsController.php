<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Accident;
use App\Citizen;
use App\Rescuer;
use DB;
use PDF;

class AccidentsController extends Controller
{
    public function index()
    {
        return view('accidents');
    }

    public function fetchdata(Request $request){
        $id = $request->input('id');
        $incident = Accident::find($id);
        $place = explode(", -",$incident->place);

        $output = array(
            'date' => $incident->date,
            'time' => $incident->time,
            'place' => $place,
            'accident' => $incident->accident,
            'involvesID' => $incident->involves,
            'remarks' => $incident->remarks,
            'respondersID' => $incident->responders
        );

        echo json_encode($output);
    }

    public function postdata(Request $request){
        $validation = Validator::make($request->all(), [
            'date' => 'required',
            'time' => 'required',
            'barangay_p' => 'required',
            'accident' => 'required',
            'involvesID' => 'required',
            'respondersID' => 'required'
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
                $place = $request->get('place').', -'.$request->get('barangay_p');
                $incident = new Accident([
                    'date' => $request->get('date'),
                    'time' => $request->get('time'),
                    'place' => $place,
                    'accident' => $request->get('accident'),
                    'involves' => $request->get('involvesID'),
                    'remarks' => $request->get('remarks'),
                    'responders' => $request->get('respondersID')
                ]);

                $incident->save();
                $success_output = 'Data Inserted';
            }

            if($request->get('button_action') == 'update'){
                $incident = Accident::find($request->get('incident_id'));
                $incident->date = $request->get('date');
                $incident->time = $request->get('time');
                $place = $request->get('place').', -'.$request->get('barangay_p');
                $incident->place = $place;
                $incident->accident = $request->get('accident');
                $incident->involves = $request->get('involvesID');
                $incident->remarks = $request->get('remarks');
                $incident->responders = $request->get('respondersID');

                $incident->save();
                $success_output = 'Data Updated';
            }

        }
        $output = array(
            'error' => $error_array,
            'success' => $success_output
        );
        echo json_encode($output);

    }

    public function getdata(Request $request){
        $query = $request->get('query');
        $orderBy = $request->get('orderBy');
        $arrange = "asc";
        
        if($orderBy == "date"){
            $arrange = "desc";
        }
        
        $data = Accident::where('date','like','%'.$query.'%')
                ->orWhere('time','like','%'.$query.'%')
                ->orWhere('place','like','%'.$query.'%')
                ->orWhere('accident','like','%'.$query.'%')
                ->orWhere('involves','like','%'.$query.'%')
                ->orWhere('remarks','like','%'.$query.'%')
                ->orWhere('responders','like','%'.$query.'%')
                ->orderBy($orderBy, $arrange)
                ->paginate(10);
        $data2 = Citizen::all();
        $data3 = Rescuer::all();

        return view('accidents_data', compact('data'))->with('data2',$data2)->with('data3',$data3);
    }

    public function persons(Request $request){
        $query = $request->get('query');
        $data = Citizen::where('last_name','like','%'.$query.'%')
                ->orWhere('first_name','like','%'.$query.'%')
                ->orWhere('middle_initial','like','%'.$query.'%')
                ->orWhere('gender','like','%'.$query.'%')
                ->orWhere('barangay','like','%'.$query.'%')
                ->orderBy('last_name','asc')
                ->get();

        return view('persons')->with('data',$data);
    }

    public function responders(Request $request){
        $query = $request->get('query');
        $data = Rescuer::where('last_name','like','%'.$query.'%')
                ->orWhere('first_name','like','%'.$query.'%')
                ->orWhere('middle_initial','like','%'.$query.'%')
                ->orWhere('gender','like','%'.$query.'%')
                ->orWhere('contact','like','%'.$query.'%')
                ->orderBy('last_name','asc')
                ->get();

        return view('responders')->with('data',$data);
    }

    public function getName(Request $request){
        $id = (array) json_decode($request->get('id'));
        $data = array();
        //$citizen = Citizen::find("21");
        //echo $citizen;

        foreach($id as $row){
            //array_push($data, $row);
            $citizen = Citizen::find($row);
            $output = array(
                'id' => $row,
                'name' => $citizen->first_name.' '.$citizen->last_name
            );
            array_push($data,$output);
        }

        echo json_encode($data);
    }

    public function getName2(Request $request){
        $id = (array) json_decode($request->get('id'));
        $data = array();
        //$citizen = Citizen::find("21");
        //echo $citizen;

        foreach($id as $row){
            //array_push($data, $row);
            $rescuer = Rescuer::find($row);
            $output = array(
                'id' => $row,
                'name' => $rescuer->first_name.' '.$rescuer->last_name
            );
            array_push($data,$output);
        }

        echo json_encode($data);
    }


    public function removedata(Request $request){
        $incident = Accident::find($request->input('id'));
        if($incident->delete()){
             echo 'Data deleted';
        }

    }

    public function massremove(Request $request){
        $incident_array = $request->input('id');
        $incident = Accident::whereIn('id', $incident_array);
        if($incident->delete()){
            echo 'deleted';
        }
    }

    public function citizendata(Request $request){
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

    public function rescuerdata(Request $request){
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

    public function generate_accidents_per_month(){
        $current = date('Y-m');

        $month = '0'.(date('m') - 1);
        $year = date('Y');

        $months = array();

        $months[0] = count(Accident::where('date','like',$year.'-01'.'%')->get());
        $months[1] = count(Accident::where('date','like',$year.'-02'.'%')->get());
        $months[2] = count(Accident::where('date','like',$year.'-03'.'%')->get());
        $months[3] = count(Accident::where('date','like',$year.'-04'.'%')->get());
        $months[4] = count(Accident::where('date','like',$year.'-05'.'%')->get());
        $months[5] = count(Accident::where('date','like',$year.'-06'.'%')->get());
        $months[6] = count(Accident::where('date','like',$year.'-07'.'%')->get());
        $months[7] = count(Accident::where('date','like',$year.'-08'.'%')->get());
        $months[8] = count(Accident::where('date','like',$year.'-09'.'%')->get());
        $months[9] = count(Accident::where('date','like',$year.'-10'.'%')->get());
        $months[10] = count(Accident::where('date','like',$year.'-11'.'%')->get());
        $months[11] = count(Accident::where('date','like',$year.'-12'.'%')->get());

        $total = 0;

        foreach($months as $month){
            $total = $total + $month;
        }

        $pdf = PDF::loadView('data_reports.accident_month',['accidents' => $months, 'year' => $year, 'total' => $total])->setPaper('a4','portrait');


        $filename = "Accidents";
        return $pdf->stream($filename.'.pdf');
        //return view('data_reports.accident_month')->with('accidents',$months)->with('year',$year)->with('total',$total);
    }

    public function generate_accidents_per_barangay(){
        //NUMBER OF ACCIDENTS PER BARANGAY's CTTIZENS
        $brgy = array("A. Pascual","Abar Ist","Abar 2nd","Bagong Sikat","Caanawan","Calaocan","Camanacsacan","Culaylay","Dizol","Kaliwanagan","Kita-Kita","Malasin","Manicla","Palestina","Parang Mangga","Villa Joson (Parilla)","Pinili","Rafael Rueda, Sr. Pob.","Ferdinand E. Marcos Pob.","Canuto Ramos Pob.","Raymundo Eugenio Pob.","Crisanto Sanchez Pob.","Porais","San Agustin","San Juan","San Mauricio","Santo Niño 1st","Santo Niño 2nd","Santo Niño 3rd","Santo Tomas","Sibut","Sinipit Bubon","Tabulac","Tayabo","Tondod","Tulat","Villa Floresca","Villa Marina");

        $year = date('Y');

        $barangays = array();
        for($i = 0; $i < 38; $i++){
            $barangays[$i] = 0;
        }

        $ids = array();
        $ctr = 0;
        $citizens = DB::select("SELECT involves FROM accidents WHERE date LIKE '$year%'");
        foreach($citizens as $citizen){
            foreach($citizen as $row){
                $row = json_decode($row);
                foreach($row as $id){
                    $ids[$ctr] = (json_decode($id)); //REMOVE REDUNDANT IN $ids :: UPCOMING
                    $ctr = $ctr + 1;
                }
            }
        }

        $citizens = array();
        $ids = array_unique($ids);
        $ctr = 0;
        $check = 0;

        for($i = 0; $i < 38; $i++){
            foreach($ids as $id){
                if(count(DB::select("SELECT * FROM citizens WHERE id = '$id' AND barangay = '$brgy[$i]'")) > 0){
                    $citizens[$i][$ctr] = DB::select("SELECT * FROM citizens WHERE id = '$id' AND barangay = '$brgy[$i]'");
                    $ctr++;
                    $check = 1;
                }
            }

            if($check == 0){
                $citizens[$i] = array();
            }
            else{
                $check = 0;
            }
            $ctr = 0;
        }

        $pdf = PDF::loadView('data_reports.accident_barangay',['citizens' => $citizens, 'barangay' => $brgy, 'year' => $year])->setPaper('a4','portrait');


        $filename = "Accidents";
        return $pdf->stream($filename.'.pdf');
    }

    public function generate_accidents_per_place(){
        ///NUMBER OF ACCIDENTS IN BARANGAY
        $brgy = array("A. Pascual","Abar Ist","Abar 2nd","Bagong Sikat","Caanawan","Calaocan","Camanacsacan","Culaylay","Dizol","Kaliwanagan","Kita-Kita","Malasin","Manicla","Palestina","Parang Mangga","Villa Joson (Parilla)","Pinili","Rafael Rueda, Sr. Pob.","Ferdinand E. Marcos Pob.","Canuto Ramos Pob.","Raymundo Eugenio Pob.","Crisanto Sanchez Pob.","Porais","San Agustin","San Juan","San Mauricio","Santo Niño 1st","Santo Niño 2nd","Santo Niño 3rd","Santo Tomas","Sibut","Sinipit Bubon","Tabulac","Tayabo","Tondod","Tulat","Villa Floresca","Villa Marina");

        $year = date('Y');

        $barangays = array();
        for($i = 0; $i < 38; $i++){
            $barangays[$i] = 0;
        }

        for($i = 0; $i < 38; $i++){
            if(count(DB::select("SELECT * FROM accidents WHERE place LIKE '%$brgy[$i]'")) > 0){
                $barangays[$i] = count(DB::select("SELECT * FROM accidents WHERE place LIKE '%$brgy[$i]'"));
            }
            else{
                $barangays[$i] = 0;
            }
        }

        $pdf = PDF::loadView('data_reports.accident_place',['barangays' => $barangays, 'brgy' => $brgy, 'year' => $year])->setPaper('a4','portrait');


        $filename = "Accidents";
        return $pdf->stream($filename.'.pdf');
    }
}
