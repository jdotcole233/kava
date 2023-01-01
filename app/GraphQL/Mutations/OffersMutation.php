<?php

namespace App\GraphQL\Mutations;

use App\Utilities\KavaUtility;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class OffersMutation
{
    public function fetchOffersForBroker($root, array $args)
    {
        $data_format = config()->get('kava');
        $broker_name = strtolower(trim($args['broker']));
        $brokers = array_keys($data_format);

        if (!in_array($broker_name, $brokers)) {
            return  json_encode([
                'error' => "Server error",
                'message' => "Broker not found",
                'status' => 400
            ]);
        }

        $broker_enpoint = KavaUtility::getEnpoint("");// $data_format[$broker_name];
        $auth = Auth::user()->clientable->reinsurer;
        $re_company_name = $auth->re_company_name;
        $data['re_company_name'] = $re_company_name;

        $response =  Http::withHeaders([
            'accept' => 'application/json'
        ])->post($broker_enpoint . 'api/offers', $data);

        if (!$response->ok())
        {
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
