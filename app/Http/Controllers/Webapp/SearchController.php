<?php

namespace App\Http\Controllers\Webapp;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Commerce;
use App\Commerce_category;
use App\Product_sessions;

class SearchController extends Controller
{
    

    public function index()
    {
        return view('app.search', [
            'categorys' => Commerce_category::where('is_deleted', null)->orderBy('name', 'ASC')->get()
        ]);
    }

    public function filterStoreCategory(Request $request){
        $data = $request->only('filterCategory');
        if($data){
            return redirect()->route('app.storeCategory', ['id'=>$data['filterCategory']]);
        }
       
    }

    public function searchProductInStore(Request $request, $id){
        $search = $request->only('product');
        if($search['product'] != ''){
            $itemSearch = ucfirst($search['product']);
            $data['commerce'] = DB::table('commerces')
                ->join('commerce_categorys', 'commerces.category', '=', 'commerce_categorys.id')
                ->select('commerces.*', 'commerce_categorys.name AS category_name')
                ->where('commerces.id', $id)
                ->where('commerces.is_deleted', null)
                ->first();

            $data['searchproducts'] = DB::table('products')
                ->join('product_sessions', 'products.session_id', '=', 'product_sessions.id')
                ->join('commerces', 'product_sessions.commerce_id', '=', 'commerces.id')
                ->join('product_categorys', 'products.category_id', '=', 'product_categorys.id')
                ->select('products.*', 'product_sessions.name AS session_name', 'commerces.name AS commerce_name', 'product_categorys.name AS category_name')
                ->where('product_sessions.commerce_id', $id)
                ->where('products.name', 'LIKE', "%{$itemSearch}%")
                ->where('products.is_deleted', null)
                ->get();

                if(count($data['searchproducts']) == 0){
                    $data['notResult'] = 'Poxa, não encontramos nada.';
                }
                
            return view('app.store', $data);
        }else{
            return redirect()->route('app.store', ['id'=>$id]);
        }
    }

    public function searchProduct(Request $request)
    {
        $search = $request->only('product');
        if($search['product'] != ''){
            $itemSearch = ucfirst($search['product']);
            $data['products'] = DB::table('products')
            ->join('product_sessions', 'products.session_id', '=', 'product_sessions.id')
            ->join('commerces', 'product_sessions.commerce_id', '=', 'commerces.id')
            ->join('product_categorys', 'products.category_id', '=', 'product_categorys.id')
            ->select('products.*', 'product_sessions.commerce_id', 'commerces.name AS commerce_name', 'product_categorys.name AS category_name')
            ->where('products.name', 'LIKE', "%{$itemSearch}%")
            ->where('products.is_deleted', null)
            ->get();
            if(count($data['products']) == 0){
                $data['notResult'] = 'Poxa, não encontramos nada.';
            }
            return view('app.productFilter', $data);
        }else{
            return redirect()->route('app.search');
        }
      
    }

    public function searchProductOffer(Request $request)
    {
        $search = $request->only('product');
 
        if($search['product'] != ''){
            $itemSearch = ucfirst($search['product']);
            $data['productsoffer'] = DB::table('products')
            ->join('product_sessions', 'products.session_id', '=', 'product_sessions.id')
            ->join('commerces', 'product_sessions.commerce_id', '=', 'commerces.id')
            ->join('product_categorys', 'products.category_id', '=', 'product_categorys.id')
            ->select('products.*', 'product_sessions.commerce_id', 'commerces.name AS commerce_name', 'product_categorys.name AS category_name')
            ->where('products.name', 'LIKE', "%{$itemSearch}%")
            ->where('products.offer', '!=', 'null')
            ->where('products.is_deleted', null)
            ->get();
            if(count($data['productsoffer']) == 0){
                $data['notResult'] = 'Poxa, não encontramos nada.';
            }
            return view('app.productFilterOffer', $data);
        }else{
            return redirect()->route('app.offer');
        }
      
    }

    public function searchStore(Request $request)
    {
        $search = $request->only('commerce');
        $itemSearch = ucfirst($search['commerce']);
        if($search['commerce'] != ''){
            $data['searchcommerces'] = DB::table('commerces')
            ->join('commerce_categorys', 'commerces.category', '=', 'commerce_categorys.id')
            ->select('commerces.*', 'commerce_categorys.name AS category_name')
            ->where('commerces.name', 'LIKE', "%{$itemSearch}%")
            ->where('commerces.is_deleted', null)
            ->get();

            if(count($data['searchcommerces']) == 0){
                $data['notResult'] = 'Poxa, não encontramos nada.';
            }

            $data['categorys'] = Commerce_category::where('is_deleted', null)->orderBy('name', 'ASC')->get();

            return view('app.storeSearch', $data);
        }else{
            return redirect()->route('app.search');
        }
    }

    public function searchRollback(){
        return redirect()->route('app.search');
    }
}
