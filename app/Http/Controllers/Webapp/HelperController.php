<?php

namespace App\Http\Controllers\Webapp;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class HelperController extends Controller
{
    private $lat;
    private $lng;
   
    public function getUserGeolocation(Request $request)
    {
        if(isset($_GET['lat']) && !empty($_GET['lat'])){
            $this->lat = $_GET['lat'];
            $this->lng = $_GET['lng'];
            $request->session()->put('userLocation', [
                'lat' => $this->lat,
                'lng' => $this->lng
            ]);
            echo $this->lat.'/'.$this->lng;

        }else{
            echo 'not coordinates';
        }
    }

    public function userLocationData(Request $request)
    {
        if($request->session()->has('userLocation')){
            return $request->session()->get('userLocation');
        }else{
            return array();
        }

    }

}
