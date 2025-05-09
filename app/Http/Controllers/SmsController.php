<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Kreait\Firebase;
use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;
use Kreait\Firebase\Database;

class SmsController extends Controller
{
    public function index(){
        return view('messages');
    }

    public function sendSMS(Request $request){
        $basic  = new \Nexmo\Client\Credentials\Basic('3b2b3f83', 'xDBN7D8l6guqM0bO');
        $client = new \Nexmo\Client($basic);

        $phone_number = $request->input('phone_number');
        $message = $request->input('message');

        $phone_number = ltrim($phone_number, $phone_number[0]);

        $phone_number = '+63'.$phone_number;

        $sms = $client->message()->send([
            'to' => $phone_number,
            'from' => 'MK3121',
            'text' => $message
        ]);

        echo "success";
    }

     public function allSMS(Request $request){
        $basic  = new \Nexmo\Client\Credentials\Basic('3b2b3f83', 'xDBN7D8l6guqM0bO');
        $client = new \Nexmo\Client($basic);

        $phones = $request->input("phone");
        $message = $request->input("message");
        $phones_array = explode(",",$phones);

        foreach($phones_array as $phone){
            $sms = $client->message()->send([
                'to' => $phone,
                'from' => 'MK3121',
                'text' => $message
            ]);
        }
    }
    
    public function sendPushNotification(){
        
        $to = "f_NIkhXkLwA:APA91bGvPx__VwW6buYpLsUv1hhv2hSR1fX9m7fVULHIGHpvvcAjQOpgDhEM-myPxnl9AKaKcvyn1Lboftm-1bTZTVeCpLavrbBhZ8bR16zvpiF2af7CVagYxRL6cfm1QxEL-V3t4whk";
        $data = array(
            'body' => 'Emergency marker has been set!'
        );
        
        $apiKey = 'AIzaSyC9JxPxs96oI_QlEGKnVjS8fmVnL6QkoYk';
        $fields = array( 'to' => $to, 'notification'  => $data );
    
        $headers = array( 'Authorization: key='.$apiKey, 'Content-Type: application/json');
    
        $url = 'https://fcm.googleapis.com/fcm/send';
    
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url);
        curl_setopt( $ch, CURLOPT_POST, true);
        curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
    
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt( $ch, CURLOPT_POSTFIELDS, json_encode($fields));
    
        $result = curl_exec($ch);
        curl_close($ch);
        print_r(json_decode($result, true));
    }
    
    /*
    public function getphones(Request $request){
        $serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/mk3121.json');
        $firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->withDatabaseUri('https://makisigrescue3121.firebaseio.com/')
            ->create();

        $database = $firebase->getDatabase();
        $newPost = $database->getReference('Phones')->getChild("Phone");

        $key = $newPost->push()->getKey();

        echo "<pre>";
        print_r($newPost->getvalue());

        $array = array($newPost->getvalue());
        $json = json_encode($array);
        echo $json;
    }*/
}
