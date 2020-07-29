<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class AssignmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    function everything_in_tags($string, $tagname)
    {
        $pattern = "#<\s*?$tagname\b[^>]*>(.*?)</$tagname\b[^>]*>#s";
        preg_match_all($pattern, $string, $matches);
        return $matches[1];
    }

    public function assignment(){

        logger("inside controller");
        $client = new \GuzzleHttp\Client();
        
        $response = $client->request('GET', 'https://time.com');

        $matches = $this->everything_in_tags($response->getBody(), 'h2');

        $res = [];
        $i=0;
        while($i<5){
            $result = explode("/", $matches[$i]);
            // logger($result);
            if(!empty($result)) {
                array_push($res, [ 'title' => strip_tags($matches[$i]), 'link' => "https://time.com/$result[1]/$result[2]/" ]);
                $i++;
            }
        }
        logger("Leaving controller");

        return response()->json($res);

    }
}