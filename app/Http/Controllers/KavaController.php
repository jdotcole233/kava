<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KavaController extends Controller
{
    public function generateClosings ($id)
    {
        //decode data
        $parsed = json_decode(base64_decode($id), true);
        /**
         * offer id alias _id
         * reinsurer_id alias _id_me
         * broker
         * 
        */

        $data_format = config()->get('kava');
        $broker_name = strtolower(trim($parsed['broker']));
        $broker_enpoint = $data_format[$broker_name];

        $data = json_encode([
            'offer_id' => $parsed['_id'],
            'reinsurer_id' => $parsed['_id_me']
        ]);

        $broker_enpoint = $broker_enpoint . 'generate_closing_slip/'. base64_encode($data);
        $response =  Http::get($broker_enpoint, $data);

        if (!$response->ok())
        {
            return "Error". $response->status();
        }

        return $response->body();
    }
}
