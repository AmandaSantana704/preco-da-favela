<?php

namespace App\Http\Controllers\Webapp;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Webapp\HelperController;
use App\Commerce;
use App\Commerce_category;
use App\Product_sessions;

class StoreController extends Controller
{
    private $HelperController;

    public function __construct()
    {
        $this->HelperController = new HelperController();
    }

    public function index($id)
    {
        $data['commerce'] = DB::table('commerces')
                ->join('commerce_categorys', 'commerces.category', '=', 'commerce_categorys.id')
                ->select('commerces.*', 'commerce_categorys.name AS category_name')
                ->where('commerces.id', $id)
                ->where('commerces.is_deleted', null)
                ->first();

        $data['products'] = DB::table('products')
                ->join('product_sessions', 'products.session_id', '=', 'product_sessions.id')
                ->join('commerces', 'product_sessions.commerce_id', '=', 'commerces.id')
                ->join('product_categorys', 'products.category_id', '=', 'product_categorys.id')
                ->select('products.*', 'product_sessions.name AS session_name', 'commerces.name AS commerce_name', 'product_categorys.name AS category_name')
                ->where('product_sessions.commerce_id', $id)
                ->where('products.is_deleted', null)
                ->get();
                
        $data['sessions'] = Product_sessions::where('commerce_id', $id)->where('is_deleted', null)->get();
        if($data){
            return view('app.store', $data);
        }
    }

    public function storeCategory(Request $request, $id)
    {
        $statusRequest = $this->HelperController->userLocationData($request);
        $getAllCommerceCategory = "SELECT commerce_categorys.name AS category_name, commerces.* FROM commerces
        INNER JOIN commerce_categorys ON commerces.category = commerce_categorys.id WHERE commerces.category = ".$id."";

        if($statusRequest != array()){
            $geolocationQuery = "SELECT commerce_categorys.name AS category_name, commerces.*,(6371 * acos( cos( radians(".$statusRequest['lat'].") ) * cos( radians( lat ) ) * cos( radians( lng ) 
            - radians(".$statusRequest['lng'].") ) + sin( radians(".$statusRequest['lat'].") ) * sin( radians( lat ) ) ) ) AS distance FROM commerces
            INNER JOIN commerce_categorys ON commerces.category = commerce_categorys.id WHERE commerces.category = ".$id." HAVING distance < 1 ORDER BY 
            distance ASC";
        }else{
            $geolocationQuery = $getAllCommerceCategory;
        }

        $filterCommerce = DB::select($geolocationQuery);
        if($filterCommerce == array()){
            $filterCommerce = DB::select($getAllCommerceCategory);
            if($filterCommerce == array()){
                $data['notResult'] = 'Poxa, não encontramos nada.';
            }
        }

        $data['category'] = Commerce_category::where('id', $id)->first();
        $data['Allcategorys'] = Commerce_category::where('is_deleted', null)->orderBy('name', 'ASC')->get();
        $data['commerces'] = $filterCommerce;
        return view('app.storeFilter', $data);
    }

   
}
