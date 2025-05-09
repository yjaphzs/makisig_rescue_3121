<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
//use Illuminate\Support\Collection;
use App\Support\Collection;


class MobileUsersController extends Controller
{
    public function index()
    {
        return view('mobile-users');
    }

    public function getdata(Request $request)
    {
        //$results = '{"pr":{"code":"1"},"ac":[[{"icon":"web","action":"link","url":"asd"}]]}';
        $data = (array)json_decode($request->get("data"), true);
        //$data = json_decode($results);
        $collection = (new Collection($data))->paginate(20);

        //$name = $data[0]["name"];
        //$length = count($data);

        //Pass data to view
        //return view('search2', $data);
        return view("search2")->with('collection',$collection);
        //echo "<pre>";
        //print_r($name." ".$length);
        //print_r($collection);
    }
}
