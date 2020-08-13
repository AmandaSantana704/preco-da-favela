<?php

namespace App\Http\Controllers\Webapp;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Webapp\HelperController;
use App\Commerce_category;
use App\Commerce;

class HomeController extends Controller
{
    private $HelperController;

    public function __construct()
    {
        $this->HelperController = new HelperController();
    }
    public function index(Request $request)
    {
   
        $statusRequest = $this->HelperController->userLocationData($request);
        $getAllCommerce = 'SELECT commerce_categorys.name AS category_name, commerces.* FROM commerces
        INNER JOIN commerce_categorys ON commerces.category = commerce_categorys.id';

        if($statusRequest != array()){
            $geolocationQuery = "SELECT commerce_categorys.name AS category_name, commerces.*,(6371 * acos( cos( radians(".$statusRequest['lat'].") ) * cos( radians( lat ) ) * cos( radians( lng ) 
            - radians(".$statusRequest['lng'].") ) + sin( radians(".$statusRequest['lat'].") ) * sin( radians( lat ) ) ) ) AS distance FROM commerces
            INNER JOIN commerce_categorys ON commerces.category = commerce_categorys.id HAVING distance < 1 ORDER BY 
            distance ASC";
        }else{
            $geolocationQuery = $getAllCommerce;
        }

         $allCommerces = DB::select($geolocationQuery);
         if($allCommerces == array()){
            $allCommerces = DB::select($getAllCommerce);
        }
        return view('app.home', [
            'categorys' => Commerce_category::where('is_deleted', null)->orderBy('name', 'ASC')->get(),
            'commerces' => $allCommerces
        ]);
    }

    

}
