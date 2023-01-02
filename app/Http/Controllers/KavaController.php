<?php

namespace App\Http\Controllers;

use App\Utilities\KavaUtility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KavaController extends Controller
{
    public function generateClosings($id)
    {
        //decode data
        $parsed = json_decode(base64_decode($id), true);
        /**
         * offer id alias _id
         * reinsurer_id alias _id_me
         * broker
         * 
         */
        $broker_enpoint =  KavaUtility::getEnpoint($parsed['broker']);

        $data = json_encode([
            'offer_id' => $parsed['_id'],
            'reinsurer_id' => $parsed['_id_me']
        ]);

        $broker_enpoint = $broker_enpoint . 'generate_closing_slip/' . base64_encode($data);
        $response =  Http::get($broker_enpoint, $data);

        if (!$response->ok()) {
            return "Error" . $response->status();
        }

        return $response->body();
    }


    public function treatyCreditNotes($id)
    {
        //decode data
        $parsed = json_decode(base64_decode($id), true);
        info("parsed ". json_encode($parsed));
        /**
         * 
         * surplus => {"participant_id":"424","treaty_account_id":"115","type":0,"emp_id":"11","broker": "KEK", "treaty_type": "PROPORTIONAL"}
         * xl => {"participant_id":"1395","limit":"200000","layer":1,"uuid":"b53badf6-db08-46bf-a6eb-9f1239958e44",
         * "m_and_d_premium":360000,"total_participation_percentage":40,"installment_type":"2","broker": "KEK", "treaty_type": "NONPROPORTIONAL"}
         */
        $broker_enpoint =  KavaUtility::getEnpoint($parsed['broker']);

        //format data
        if (strcmp($parsed['treaty_type'], 'PROPORTIONAL') == 0)
        {
            $data = json_encode([
                'participant_id' => $parsed['participant_id'],
                'treaty_account_id' => $parsed['treaty_account_id'],
                'type' => 0,
                'emp_id' => 1
            ]);
            $uri = "generate_treaty_credit_note/";
        } 
        else
        {
            $data = json_encode([
                'participant_id' => $parsed['participant_id'],
                'limit' => $parsed['limit'],
                'layer' => $parsed['layer'],
                'uuid' => $parsed['uuid'],
                'm_and_d_premium' => $parsed['m_and_d_premium'],
                'total_participation_percentage' => $parsed['total_participation_percentage'],
                'installment_type' => $parsed['installment_type'],
            ]);
            $uri = "treaty_np_credit_note/";

        }

        $broker_enpoint = $broker_enpoint . $uri . base64_encode($data);
        $response =  Http::get($broker_enpoint);

        if (!$response->ok()) {
            return "Error" . $response->status();
        }

        return $response->body();
    }
}
