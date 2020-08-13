<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Product;
use App\Product_sessions;
use App\Product_categorys;
use App\Commerce;

class ProductController extends Controller
{
    private $sessionId;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        $this->sessionId = $id;
        if(!$this->attachment($id)){
            return redirect()->route('panel.session')
                    ->with('warning', 'Você não pode acessar essa seção!');
        }
        
        $data['products'] = DB::table('products')
        ->join('product_categorys', 'products.category_id', '=', 'product_categorys.id')
        ->select('products.*', 'product_categorys.name AS category_name')
        ->where('products.session_id', $id)
        ->where('products.is_deleted', null)
        ->get();

        $data['count'] = count($data['products']);
        $data['id_session'] = $id;
        return view('admin.product.main', $data);
        
    }

    public function register($id)
    {
   
        return view('admin.product.create',[

            'categorys' => Product_categorys::where('is_deleted', null)->orderBy('name')->get(),
            'sessionId' => $id

        ]);
    }

    public function save(Request $request, $id)
    {
        $products = Product::all();
        $data = $request->only(

            'category',
            'name',
            'description',
            'price',
            'offer',
            'img'

        );

        $validator = $this->validator($data);
        if($validator->fails()){
            return redirect()->route('product.register', ['id'=>$id])
                    ->withErrors($validator)
                    ->withInput();
        }
        foreach($products as $product){
            if($product->user_id == Auth::id()){
                if(ucfirst($data['name']) === $product->name){
                    $validator->errors()->add('unique', 'Você já cadastrou um produto com esse nome!');
                    return redirect()->route('product.register', ['id'=>$id])
                            ->withErrors($validator)
                            ->withInput();
                }
            }
        }
        
        if(!empty($data['offer'])){
            $strOffer = str_replace(',', '.', $data['offer']);
            $data['offer'] = $strOffer;
        }else{
            $data['offer'] = null;
        }
        

        $request->validate([
            'img' => 'image|mimes:jpeg,jpg,png|max:1000'
        ]);

        if(!empty($request->file('img')) && $request->file('img')->isValid()){

            $extImg = $request->file('img')->extension();
            $imgName = time().rand(0, 999999).md5(time()).'.'.$extImg;
            $request->file('img')->move(public_path('images/product'), $imgName);
            $data['img'] = $imgName;
            
        }

        $user = Auth::user();
        $data['session'] = $id;
       
        if($user['permission'] == 1 || $user['permission'] == 2){
            $data['user'] = $user['id'];
        }else{
            $data['user'] = $user['user_creator'];
        }

        switch($user['plan']){
            case 1:
                if($this->limit(10)){
                    return $this->alert();
                }
            break;
            case 2:
                if($this->limit(20)){
                    return $this->alert();
                }
            break;
            case 3:
                if($this->limit(1000000)){
                    return $this->alert();
                }
            break;
            case 4:
                if($this->limit(1000000)){
                    return $this->alert();
                }
            break;
            default:
                return redirect()->route('panel.product', ['id'=>$id]);
            break;
        }
        
        $this->create($data);
        return redirect()->route('panel.product', ['id'=>$id])
                ->with('success', 'Produto cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $product = Product::find($id);
        if(!$this->attachmentProduct($product['session_id'], $id)){
            return redirect()->route('panel.session')
                    ->with('warning', 'Você não pode editar esse produto!');
        }
        if($product){
            return view('admin.product.update', [
                'product' => $product,
                'categorys' => Product_categorys::where('is_deleted', null)->orderBy('name')->get()
            ]);
        }
        return redirect()->route('panel.session');
    }

    public function update(Request $request, $id){
        $product = Product::find($id);
        if(!$this->attachmentProduct($product['session_id'], $id)){
            return redirect()->route('panel.session')
                ->with('warning', 'Você não pode editar esse produto!');
        }
        $data = $request->only(
            'name',
            'category',
            'description',
            'price',
            'offer',
            'img'
        );
        $validator = Validator::make($data, [
            'category' => ['required'],
            'name' => ['required', 'string', 'max:50'],
            'price' => ['required'],
        ]);
        if($validator->fails()){
            return redirect()->route('product.edit', ['id'=>$id])
                    ->withErrors($validator);
        }
        $product->name = ucfirst($data['name']);
        $product->category_id = $data['category'];
        $product->price = str_replace(',', '.', $data['price']);
        if(!empty($data['description']) || !empty($data['offer'])){
            $product->description = $data['description'];
            $product->offer = str_replace(',', '.', $data['offer']);
        }
        if(!empty($data['img'])){
            $request->validate([
                'img' => 'image|mimes:jpeg,jpg,png|max:1000'
            ]);
    
            if(!empty($request->file('img')) && $request->file('img')->isValid()){
    
                $extImg = $request->file('img')->extension();
                $imgName = time().rand(0, 999999).md5(time()).'.'.$extImg;
                $request->file('img')->move(public_path('images/product'), $imgName);
                $data['img'] = $imgName;
            
            }
            $product->img = $data['img'];
        }
        $product->save();
        return redirect()->route('panel.product', ['id'=>$product['session_id']])
                ->with('success', 'Produto atualizado com sucesso!');

    }

    public function delete(Request $request, $id)
    {
        $sessionId = $request->only('sessionId');
        if(!$this->attachmentProduct($sessionId, $id)){
            return redirect()->route('panel.product', ['id'=>$sessionId['sessionId']])
                    ->with('warning', 'Você não pode excluir esse produto!');
        }
        $product = Product::find($id);
        if($product){
            
            $product->is_deleted = date('Y-m-d H:i:s');
            $product->save();
            return redirect()->route('panel.product', ['id'=>$sessionId['sessionId']])
                    ->with('success', 'Produto excluído com sucesso!');
        }
        return redirect()->route('panel.product', ['id'=>$sessionId['sessionId']]);
    }

    protected function create(array $data)
    {
        return Product::create([
            'user_id' => $data['user'],
            'session_id' => $data['session'],
            'category_id' => $data['category'],
            'name' => ucfirst($data['name']),
            'description' => $data['description'],
            'price' => str_replace(',', '.', $data['price']),
            'offer' => $data['offer'],
            'img' => $data['img'],
            'updated_at' => null
        ]);
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'category' => ['required'],
            'name' => ['required', 'string', 'max:50'],
            'price' => ['required'],
            'img' => ['required']
        ]);
    }

    protected function attachment($id){
        $user = Auth::user();
        $data = array();
        switch($user['permission']){
            case 1:
                $data['sessions'] = DB::table('product_sessions')
                ->join('commerces', 'product_sessions.commerce_id', '=', 'commerces.id')
                ->select('product_sessions.*', 'commerces.name AS commerce_name')
                ->where('product_sessions.is_deleted', null)
                ->get();
            break;
            case 2:
                $data['sessions'] = DB::table('product_sessions')
                ->join('commerces', 'product_sessions.commerce_id', '=', 'commerces.id')
                ->select('product_sessions.*', 'commerces.name AS commerce_name')
                ->where('commerces.user_id', $user['id'])
                ->where('product_sessions.is_deleted', null)
                ->get();
            break;
            default:
                $data['sessions'] = DB::table('product_sessions')
                ->join('commerces', 'product_sessions.commerce_id', '=', 'commerces.id')
                ->select('product_sessions.*', 'commerces.name AS commerce_name')
                ->where('commerces.user_id', $user['user_creator'])
                ->where('product_sessions.is_deleted', null)
                ->get();
            break;
        }
       
        $ids = '';
        foreach($data['sessions'] as $session){
            $ids .= $session->id.',';
        }
        $arrayIds = explode(',', $ids);
        if(in_array($id, $arrayIds)){
            return true;
        }else{
            return false;
        }

    }

    protected function attachmentProduct($sessionid, $productId){
        $user = Auth::user();
        $data = array();
        if($user['permission'] == 1){
            $data['products'] = Product::where('session_id', $sessionid)->where('is_deleted', null)->get();
        }
        if($user['permission'] == 2){
            $data['products'] = Product::where('session_id', $sessionid)->where('user_id', $user['id'])->where('is_deleted', null)->get();
        }else{
            $data['products'] = Product::where('session_id', $sessionid)->where('user_id', $user['user_creator'])->where('is_deleted', null)->get();
        }
       
        $ids = '';
        foreach($data['products'] as $product){
            $ids .= $product->id.',';
        }
        $arrayIds = explode(',', $ids);
        if(in_array($productId, $arrayIds)){
            return true;
        }else{
            return false;
        }

    }

    protected function limit($num){
        $user = Auth::user();
        if($user['permission'] == 1 || $user['permission'] == 2){
            $product = Product::where('user_id', $user['id'])->where('is_deleted', null)->get();
        }else{
            $product = Product::where('user_id', $user['user_creator'])->where('is_deleted', null)->get();
        }
        if(count($product) >= $num){
           return true; 
        }else{
            return false;
        }
    }

    protected function alert()
    {
        return redirect()->route('panel.session')
                ->with('limit', 'Você atingiu o limite máximo de produtos cadastrados!');
    }

    
}
