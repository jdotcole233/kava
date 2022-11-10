<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class UploadController
{
    public function uploadDocuments ()
    {
        // Read directory and json files
        $directories = glob(getcwd() . "\\Data\\*");
        $structure = [];

        foreach ($directories as $directory)
        {
            $nesteddirectories = glob($directory . DIRECTORY_SEPARATOR ."*");
            
            $sub = [];

            foreach ($nesteddirectories as $files)
            {
                $filename = basename($files, '.json');
                $sub = $this->filt('insurer', $files);
                $sub = $this->address($sub, 'insureraddress', $files);

                // $sub = $this->associates($sub, $filename, $files);
            }
            // array_push($structure[trim(basename($directory))], $sub);
            $structure[trim(basename($directory))] = $sub;
            // echo json_encode($sub);
        }
        
        Log::info(json_encode($structure));
        // return "Done " . json_encode($structure);

        //for each file [insurer or reinsurer]

        // return json_encode($dir);

    }

    private function filt ($key, $files)
    {
        $structure[$key] = [];
        // Log::info(basename($files, '.json'));
        // if (Str::contains($files, $key))
        if (basename($files, '.json') == $key)
        {
            $contents = $this->parse($files);
            // Log::info("contents ". json_encode($contents));
            // Log::info("here..");
            foreach ($contents as $jsonContent)
            {
                // Log::info("some ". json_encode($jsonContent));
                if (!empty($jsonContent))
                {
                    if ((!collect($structure[$key])->contains($jsonContent[$key.'_company_name']) 
                    || !collect($structure[$key])->contains($jsonContent[substr($key, 0, 2). '_company_name'])) 
                    && $jsonContent['delete_status'] == "NOT DELETED"
                    )
                    {
                        // Log::info("here1");
                        array_push($structure[$key], $jsonContent);
                    }
                }
            }
        }

        // Log::info("final ". json_encode($structure));
        return $structure;
    }

    private function address ($structure, $key, $files)
    {
        $actual = $structure[substr($key, 0, stripos($key, 'a'))];
        $spacex = [];
        Log::info("actual 1 ". json_encode($actual));

        if (basename($files, '.json') == $key)
        {
            foreach ($this->parse($files) as $add)
            {
                $insurer_id = $add[Str::plural(substr($key, 0, stripos($key, 'a'))).substr($key, 0, stripos($key, 'a'))."_id"];
                Log::info("insurer id ". $insurer_id);
                Log::info("actual ". json_encode($actual));

                $aa = collect($actual)->where('insurer_id', $insurer_id)->first();
                Log::info("aa ". json_encode($aa));
                if ($aa)
                {
                    Arr::add($aa, substr($key,stripos($key, 'a'), strlen($key) - 1), $add );
                    // array_push($aa[substr($key,stripos($key, 'a'), strlen($key) - 1)], $add);
                    array_push($spacex, $aa);
                }
            }
            // Log::info("frank ". json_encode($actual));
        }

        Log::info(" add ". json_encode($spacex));
        return $spacex;
    }

    private function associates ($structure, $key, $files)
    {
        $actual = $structure[substr($key, 0, stripos($key, 'a'))];
        if (Str::contains($files, 'associate'))
        {
            foreach ($this->parse($files) as $ass)
            {
                $basekey = Str::plural(substr($key, 0, stripos($key, 'a'))).substr($key, 0, stripos($key, 'a'))."_id";
                $insurer_id = $ass[$basekey];
                if (collect($actual)->contains($insurer_id))
                {
                    array_push($actual[substr($key,stripos($key, 'a'), strlen($key) - 1)], collect($ass)->where($basekey, $insurer_id)->except('*_at'));
                }
            }
        }
    }

    private function parse ($files)
    {
        return json_decode(file_get_contents($files), true);
    }
}