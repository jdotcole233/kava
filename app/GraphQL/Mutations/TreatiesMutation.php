<?php

namespace App\GraphQL\Mutations;

use App\Utilities\KavaUtility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class TreatiesMutation
{
   public function fetchTreatiesForBroker($root, array $args)
   {
     $broker_endpoint = KavaUtility::getEnpoint($args['broker']);
     $auth = Auth::user()->clientable->reinsurer;
     $re_company_name = $auth->re_company_name;
     $data['re_company_name'] = $re_company_name;
 
     $response = Http::withHeaders([
        'accept' => 'application/json'
     ])->post($broker_endpoint. "api/treaties", $data);

     if (!$response->ok())
     {
        info("Something went wrong");
         return  json_encode([
             'error' => "Server error",
             'message' => "Something went wrong",
             'status' => 500
         ]);
     }

     $response = $response->json()['data'];
     return $response;
   } 
}