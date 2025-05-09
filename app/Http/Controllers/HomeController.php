<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Accident;
use App\Citizen;
use App\Involve;
use App\Item;
use App\Rescuer;

class HomeController extends Controller
{

    public function index()
    {
        $date = date('Y-m-d',strtotime('-1 days'));

        $accidents_c = count(Accident::where('created_at','>=',$date)->get());
        $involves_c = count(Involve::where('created_at','>=',$date)->get());
        $items_c = count(Item::where('created_at','>=',$date)->get());
        $rescuers_c = count(Rescuer::where('created_at','>=',$date)->get());
        $citizens_c =count(Citizen::where('created_at','>=',$date)->get());

        $total_c = $accidents_c + $involves_c + $items_c + $rescuers_c + $citizens_c;

        $data_c = array(
            'accidents' => $accidents_c,
            'involves' => $involves_c,
            'items' => $items_c,
            'rescuers' => $rescuers_c,
            'citizens' => $citizens_c,
            'total' => $total_c
        );


        $accidents_u = count(Accident::where('updated_at','>=',$date)->get());
        $involves_u = count(Involve::where('updated_at','>=',$date)->get());
        $items_u = count(Item::where('updated_at','>=',$date)->get());
        $rescuers_u = count(Rescuer::where('updated_at','>=',$date)->get());
        $citizens_u =count(Citizen::where('updated_at','>=',$date)->get());

        $total_u = $accidents_u + $involves_u + $items_u + $rescuers_u + $citizens_u;

        $data_u = array(
            'accidents' => $accidents_u,
            'involves' => $involves_u,
            'items' => $items_u,
            'rescuers' => $rescuers_u,
            'citizens' => $citizens_u,
            'total' => $total_u
        );


        return view('home')->with('data_c',$data_c)->with('data_u',$data_u);
    }
}
