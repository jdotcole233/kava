<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illumninate\Support\Arr;


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
            

            foreach ($nesteddirectories as $files)
            {

                $structure = $this->filt(basename($files), $files);
                 if (Str::contains($files, 'address'))
                 {

                 }

                 if (Str::contains($files, 'associate'))
                 {

                 }
            }
            // echo json_encode($nesteddirectories);
        }

        return "Done " . json_encode($structure);

        //for each file [insurer or reinsurer]

        // return json_encode($dir);

    }

    private function filt ($key, $files)
    {
        $structure = [];
        if (Str::contains($files, $key))
        {
            foreach ($this->parse($files) as $jsonContent)
            {
                if ((!collect($structure[$key])->contains($jsonContent[$key.'_company_name']) 
                || !collect($structure[$key])->contains($jsonContent[substr($key, 0, 2). '_company_name'])) 
                 && $jsonContent['delete_status'] == "NOT DELETED"
                )
                {
                     array_push($structure[$key],  collect($jsonContent)->except('*_at'));
                }
            }
        }

        return $structure;
    }

    public function address ($structure, $key, $files)
    {
        if (Str::contains($files, 'address'))
        {
            foreach ($this->parse($files) as $add)
            {
                $insurer_id = $add[Str::plural($key).$key."_id"];
                collect($structure[])->contains();
            }
        }
    }

    private function parse ($files)
    {
        return json_decode(file_get_contents($files), true);
    }
}