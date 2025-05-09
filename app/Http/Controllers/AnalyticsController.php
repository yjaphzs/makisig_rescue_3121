<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Accident;
use App\Citizen;
use DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        //TOTAL NUMBER OF ACCIDENTS
        $current = date('Y-m');

        $month = date('m') - 1;
        $year = date('Y');
        if($month < 10){
            if($month == 0){
                $last = ($year-1).'-12';
            }
            else{
                $month = '0'.(date('m') - 1);
                $last = $year.'-'.$month;
            }
        }

        $last_month = Accident::where('date','like',$last.'%')->get();
        $current_month = Accident::where('date','like',$current.'%')->get();

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

        $all = array();


        for($i = 0; $i < date('m')+0; $i++){
            $all[$i] = $months[$i];
        }

        $data = [
            'current'  => count($current_month),
            'last'   => count($last_month),
            'all' => $all
        ];


        //NUMBER OF ACCIDENTS PER BARANGAY's CTTIZENS
        $brgy = array("A. Pascual","Abar Ist","Abar 2nd","Bagong Sikat","Caanawan","Calaocan","Camanacsacan","Culaylay","Dizol","Kaliwanagan","Kita-Kita","Malasin","Manicla","Palestina","Parang Mangga","Villa Joson (Parilla)","Pinili","Rafael Rueda, Sr. Pob.","Ferdinand E. Marcos Pob.","Canuto Ramos Pob.","Raymundo Eugenio Pob.","Crisanto Sanchez Pob.","Porais","San Agustin","San Juan","San Mauricio","Santo Niño 1st","Santo Niño 2nd","Santo Niño 3rd","Santo Tomas","Sibut","Sinipit Bubon","Tabulac","Tayabo","Tondod","Tulat","Villa Floresca","Villa Marina");
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


        $highest = [
            'brgy_name' => "",
            'brgy_value' => 0
        ];

        $ids = array_unique($ids);

        foreach($ids as $id){
            for($i = 0; $i < 38; $i++){
                if(count(DB::select("SELECT * FROM citizens WHERE id = '$id' AND barangay = '$brgy[$i]'")) > 0){
                    $barangays[$i] = $barangays[$i] + count(DB::select("SELECT * FROM citizens WHERE id = '$id' AND barangay = '$brgy[$i]'"));
                }

                if($barangays[$i] > $highest["brgy_value"]){
                    $highest["brgy_name"] = $brgy[$i];
                    $highest["brgy_value"] = $barangays[$i];
                }
            }
        }


        $data2 = [
            'brgy_name' => $brgy,
            'brgy_value' => $barangays,
            'highest' => $highest
        ];


        //NUMBER OF ACCIDENTS IN BARANGAY
        $barangays = array();

        $highest = [
            'brgy_name' => "",
            'brgy_value' => 0
        ];

        for($i = 0; $i < 38; $i++){
            if(count(DB::select("SELECT * FROM accidents WHERE place LIKE '%$brgy[$i]'")) > 0){
                $barangays[$i] = count(DB::select("SELECT * FROM accidents WHERE place LIKE '%$brgy[$i]'"));
            }
            else{
                $barangays[$i] = 0;
            }

            if($barangays[$i] > $highest["brgy_value"]){
                $highest["brgy_name"] = $brgy[$i];
                $highest["brgy_value"] = $barangays[$i];
            }
        }

        $data3 = [
            'brgy_name' => $brgy,
            'brgy_value' => $barangays,
            'highest' => $highest
        ];

        return view('analytics')->with('data',$data)->with('data2',$data2)->with('data3',$data3);
    }

    public function citizensBarangay(Request $request){
        $barangay = $request->input('barangay');

        $year = date('Y');
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

        foreach($ids as $id){
            if(count(DB::select("SELECT * FROM citizens WHERE id = '$id' AND barangay = '$barangay'")) > 0){
                $output = DB::select("SELECT * FROM citizens WHERE id = '$id' AND barangay = '$barangay'");
                array_push($citizens,$output);
            }
        }


        echo json_encode($citizens);
    }
}
