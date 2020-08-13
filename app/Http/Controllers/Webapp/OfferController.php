<?php

namespace App\Http\Controllers\Webapp;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class OfferController extends Controller
{
    public function index()
    {
        $data['products'] = DB::table('products')
            ->join('product_sessions', 'products.session_id', '=', 'product_sessions.id')
            ->join('commerces', 'product_sessions.commerce_id', '=', 'commerces.id')
            ->join('product_categorys', 'products.category_id', '=', 'product_categorys.id')
            ->select('products.*', 'product_sessions.commerce_id', 'commerces.name AS commerce_name', 'product_categorys.name AS category_name')
            ->where('products.offer', '!=', 'null')
            ->where('products.is_deleted', null)
            ->orderBy('products.name', 'ASC')
            ->get();
        return view('app.offer', $data);
    }
}
