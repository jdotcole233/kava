<?php

namespace App\Http\Controllers;

use App\Insurer;
use App\Insurer_address;
use App\Insurer_associate;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class UploadController
{
    public function uploadDocuments ()
    {
        // Read directory and json files
        $directories = glob(getcwd() . "\\Data\\*");
        $structure = [];

        $entities = ['insurer'];

        foreach ($entities as $entity)
        {
            for ($count = 0; $count < count($directories); $count++)
            {
                $files = glob($directories[$count] . DIRECTORY_SEPARATOR . "{$entity}.json");
                Log::info(basename($directories[$count]));
                for ($filePos = 0; $filePos < count($files); $filePos++)
                {
                    $jsonContent = file_get_contents($files[$filePos]);
                    $decodedJson = json_decode($jsonContent, true);

                    foreach ($decodedJson as $data)
                    {
                        Log::info(json_encode($data));
                        $currentInsurer = explode(" ", strtolower($data['insurer_company_name']))[0];
                        Log::info("name ". $currentInsurer);
                        $insurer = $this->filterInsurer(Insurer::all(), $currentInsurer);
                        
                        // ->filter(function ($insurer) use ($currentInsurer) {
                        //     return Str::contains(strtolower($insurer->insurer_company_name), $currentInsurer);
                        // });

                        Log::info("insurer ". json_encode($insurer));

                        if ($insurer)
                        {
                                $address = $insurer->insurer_address;
                                $associates = $insurer->insurer_associates;

                                if (!$address)
                                {
                                    $insurer = $this->findNextEntity($count, count($directories), $files, $currentInsurer);
                                    $address->suburb = $insurer['suburb'];
                                    $address->street = $insurer['street'];
                                    $address->region = $insurer['region'];
                                    $address->country = $insurer['country'];
                                    $address->insurersinsurer_id = $insurer['insurer_id'];
                                    $address->save();
                                }

                                $allassociates = Insurer_associate::all();



                        }
                        else
                        {
                            $insurerCreated = Insurer::create(collect($data)->except('insurer_id', 'addresss', 'delete_status',  'asscocates', 'created_at', 'updated_at'));
                            Insurer_address::create(collect($data['address'])
                            ->except('insurer_address_id', 'insurersinsurer_id', 'created_at','delete_status', 'updated_at')->all() + [
                                'insurersinsurer_id' => $insurerCreated->insurer_id
                            ]);
                            
                            $associates = $data['associates'];
                            if (count($associates) > 0)
                            {
                                // add associates
                                $this->addAssociates($associates, $insurerCreated, $currentInsurer);
                            } 
                            else 
                            {
                                $insurer = $this->findNextEntity($count, count($directories), $files, $currentInsurer);
                                $this->addAssociates($insurer['associates'], $insurerCreated, $currentInsurer);
                            }
                        }

                    }

                }
            }
        }
    
    }

    private function findNextEntity ($count, $totalSize, $files, $currentInsurer)
    {
        $insurer = [];

        for ($next = $count + 1; $next < $totalSize; $next++)
        {
            $jsonContent1 = file_get_contents($files[$next]);
            $decodedJson1 = collect(json_decode($jsonContent1, true));
            $insurer = $this->filterInsurer($decodedJson1, $currentInsurer);
        }

        return $insurer;
    }

    private function filterInsurer ($collection, $currentInsurer)
    {
        return $collection->filter(function ($insurer) use ($currentInsurer) {
            return Str::contains(strtolower($insurer->insurer_company_name), $currentInsurer);
        });
    }

    private function addAssociates ($associates, $insurerCreated, $currentInsurer)
    {
        foreach ($associates as $associate)
        {
            $associateCreated = Insurer_associate::create(collect($associate)->except('insurer_associate_id', 'insurersinsurer_id',
                'delete_statusdelete_status', 'created_at', 'updated_at')->all() + [
                'insurersinsurer_id' => $insurerCreated->insurer_id
                ]);

                // create login credentials
                User::create([
                'email' => $associate->assoc_email,
                'clientable_id' => $associateCreated,
                'clientable_type' => "App\\Mode\\Insurer_associate",
                'password' => Hash::make($currentInsurer."kava")
                ]);
        }
    }

    
}