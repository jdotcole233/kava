<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use App\Models\Insurer;
use App\Models\Insurer_address;
use App\Models\Insurer_associate;
use App\Models\Reinsurer;
use App\Models\Reinsurer_representative;
use App\Models\Reinsurers_address;
use App\Models\User;
use Illuminate\Support\Carbon;

use Illuminate\Http\Request;

class UploadControllerIns extends Controller
{
    public function uploadDocuments()
    {
        // Read directory and json files
        $directories = glob(getcwd() . "\\Data\\*");
        $structure = [];

        Log::info("interesting " . json_encode($directories));

        $entities = ['insurer'];

        foreach ($entities as $entity) {
            echo "Importing insurers\n";
            for ($count = 0; $count < count($directories); $count++) {
                $files = glob($directories[$count] . DIRECTORY_SEPARATOR . "{$entity}.json");
                Log::info("handling ". basename($directories[$count]));
                // Log::info("files files " . json_encode($files));
                $timeStarted = Carbon::now();
                echo "importing list for ".  basename($directories[$count]) . "\n";
                echo "Started at: " . $timeStarted . "\n";


                for ($filePos = 0; $filePos < count($files); $filePos++) {
                    $jsonContent = file_get_contents($files[$filePos]);
                    $decodedJson = json_decode($jsonContent, true);

                    foreach ($decodedJson as $data) {
                        Log::info(json_encode($data));
                        $currentInsurer = explode(" ", strtolower($data['insurer_company_name']))[0];
                        Log::info("name " . $currentInsurer);
                        $insurer = $this->filterInsurer(Insurer::all(), $currentInsurer);

                        // ->filter(function ($insurer) use ($currentInsurer) {
                        //     return Str::contains(strtolower($insurer->insurer_company_name), $currentInsurer);
                        // });

                        // Log::info("insurer " . json_encode($insurer));

                        if (!empty($insurer)) {
                            Log::info("checking insurer");
                            $address = $insurer->insurer_address;
                            $associates = $insurer->insurer_associates;

                            if (!$address) {
                                $insurerRet = $this->findNextEntity($count, count($directories), $directories, $currentInsurer);
                                $address->suburb = $insurerRet['suburb'];
                                $address->street = $insurerRet['street'];
                                $address->region = $insurerRet['region'];
                                $address->country = $insurerRet['country'];
                                $address->insurersinsurer_id = $insurer->insurer_id;
                                $address->save();
                            }
                            // echo json_encode($data);
                            $attached_assoc = $data['associates'];
                            Log::info("{$currentInsurer} => ". json_encode($attached_assoc));
                            
                            $this->addAssociates($attached_assoc, $insurer, $currentInsurer);
                          
                        } else {
                            $insurerCreated = Insurer::create(collect($data)
                                ->except('insurer_id', 'addresss', 'delete_status',  'asscocates', 'created_at', 'updated_at')->all());
                            Insurer_address::create(collect($data['address'])
                                ->except('insurer_address_id', 'insurersinsurer_id', 'created_at', 'delete_status', 'updated_at')->all() + [
                                    'insurersinsurer_id' => $insurerCreated->insurer_id
                                ]);

                            // $associates = $data['associates'];
                            Log::alert("some ". json_encode(array_key_exists('associates', $data)));
                            if (array_key_exists('associates', $data) && count($data['associates']) > 0) {
                                // add associates
                                $this->addAssociates($data['associates'], $insurerCreated, $currentInsurer);
                            } else {
                                $insurer = $this->findNextEntity($count, count($directories), $directories, $currentInsurer);
                                if (!empty($insurer)) {
                                    $this->addAssociates($insurer['associates'], $insurerCreated, $currentInsurer);
                                }
                            }
                        }
                    }
                }
                $timeEnded = Carbon::now();
                echo "Ending at: " . $timeEnded . "\n";
                echo "Total time: " . $timeEnded->diffInSeconds($timeStarted) . "\n";
            }
        }

        echo "Completed";
        return;
    }

    private function findNextEntity($count, $totalSize, $directories, $currentInsurer)
    {
        $insurer = [];
        // Log::info("files " . json_encode($directories));

        for ($next = $count + 1; $next < $totalSize; $next++) {
            Log::info("Looking in the next ". json_encode($directories[$next]));
            $jsonContent = file_get_contents($directories[$next] . DIRECTORY_SEPARATOR . 'insurer.json');
            $decodedJson = collect(json_decode($jsonContent, true));
            $insurer = $this->filterInsurer($decodedJson, $currentInsurer);
        }

        return $insurer;
    }

    private function filterInsurer($collection, $currentInsurer)
    {
        Log::info("Finding ". $currentInsurer);
        return $collection->filter(function ($insurer) use ($currentInsurer) {
            return Str::contains(strtolower($insurer['insurer_company_name']), $currentInsurer);
        })->first();
    }

    private function addAssociates($associates, $insurerCreated, $currentInsurer)
    {
        Log::info("adding associates for ". json_encode($currentInsurer));
        // . " " . json_encode($insurerCreated)
        if (!empty($associates))
        {
            foreach ($associates as $associate) {

                $assoc_found = Insurer_associate::all()->filter(function ($assoc) use ($associate) {
                    $fullname = $assoc['assoc_first_name'] . " " . $assoc['assoc_last_name'];
                    $fullname = trim($fullname);
    
                    $gottenFullname = $associate['assoc_first_name'] . " " . $associate['assoc_last_name'];
                    $gottenFullname = trim($gottenFullname);
    
                    return $fullname == $gottenFullname;
                });
    
                Log::info("associate found when adding associate ". json_encode($assoc_found));
    
                // if (!$assoc_found) {
                    $associateCreated = Insurer_associate::create(collect($associate)->except(
                        'insurer_associate_id',
                        'insurersinsurer_id',
                        'delete_status',
                        'created_at',
                        'updated_at'
                    )->all() + [
                        'insurersinsurer_id' => $insurerCreated->insurer_id
                    ]);
        
                    // create login credentials
                    $email = $associateCreated->assoc_email;
                    Log::info("finding email ". $email);

                    $found = User::where('email', $email)->first();

                    Log::info("Found ". json_encode($found));

                    if (empty($found))
                    {
                        Log::info("Creating user ". $email);
                        User::create([
                            'email' => $associate['assoc_email'],
                            'clientable_id' => $associateCreated->insurer_associate_id,
                            'clientable_type' => "App\\Models\\Insurer_associate",
                            'password' => Hash::make($currentInsurer . "kava")
                        ]);
                    }
                    
                // }
                
            }

        }
        
    }
}
