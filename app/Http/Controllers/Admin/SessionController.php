<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Product_sessions;
use App\Commerce;
use App\Product;

class SessionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        
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

        return view('admin.session.main', $data);
    }

    public function register()
    {
        $user = Auth::user();
        switch($user['permission']){
            case 1:
                $commerces = Commerce::where('is_deleted', null)->get();
            break;
            case 2:
                $commerces = Commerce::where('user_id', Auth::id())->where('is_deleted', null)->get();
            break;
            default:
                 $commerces = Commerce::where('user_id', $user['user_creator'])->where('is_deleted', null)->get();
            break;

        }

        return view('admin.session.create', [
            'commerces' => $commerces
        ]);
    }

    public function save(Request $request)
    {
        $sessions = Product_sessions::all();
        $data = $request->only('commerce', 'name');
        $validator = $this->validator($data);
        if($validator->fails()){
            return redirect()->route('session.register')
                    ->withErrors($validator)
                    ->withInput();
        }
        if(Product_sessions::where('commerce_id', $data['commerce'])->where('name', ucfirst($data['name']))->where('is_deleted', null)->first()){
            $validator->errors()->add('unique', 'Esse comércio já possui uma sessão com esse nome');
            return redirect()->route('session.register')
                    ->withErrors($validator)
                    ->withInput();
        }
        $user = Auth::user();
        if($user['permission'] == 1 || $user['permission'] == 2){
            $data['userId'] = $user['id'];
        }else{
            $data['userId'] = $user['user_creator'];
        }

        switch($user['plan']){
            case 1:
                if($this->limit(2)){
                    return $this->alert();
                }
            break;
            case 2:
                if($this->limit(4)){
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
                return redirect()->route('panel.session');
            break;
        }
       
        $this->create($data);
        return redirect()->route('panel.session')
                ->with('success', 'Seção cadastrada com sucesso!');
    }

    public function edit($id)
    {
        if(!$this->attachment($id)){
            return redirect()->route('panel.session')
                    ->with('warning', 'Você não pode editar essa seção!');
        }
        $session = Product_sessions::find($id);
        $user = Auth::user();
        switch($user['permission']){
            case 1:
                $commerces = Commerce::where('is_deleted', null)->get();
            break;
            case 2:
                $commerces = Commerce::where('user_id', Auth::id())->where('is_deleted', null)->get();
            break;
            default:
                 $commerces = Commerce::where('user_id', $user['user_creator'])->where('is_deleted', null)->get();
            break;

        }
        // $idsCommerces = '';
        if($session && $commerces){

            // foreach($commerces as $commerce){
            //     $idsCommerces .= $commerce->id.',';
            // }
            // $arrIds = explode(',', $idsCommerces);
            // // print_r($arrIds);exit;
            // if(in_array($session->id, $arrIds)){
            //     echo 'tem'; exit;
            // }else{
            //     echo 'não'; exit;
            // }
            return view('admin.session.update', [
                'session' => $session,
                'commerces' => $commerces
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        if(!$this->attachment($id)){
            return redirect()->route('panel.session')
                    ->with('warning', 'Você não pode atualizar essa seção!');
        }
        $session = Product_sessions::find($id);
        $data = $request->only('commerce', 'name');
        if($session){
            $validator = $this->validator($data);
            if($validator->fails()){
                return redirect()->route('session.edit', ['id'=>$id])
                        ->withErrors($validator);
            }
            $session->commerce_id = $data['commerce'];
            $session->name = $data['name'];
            $session->updated_at = date('Y-m-d H:i:s');
            $session->save();
            return redirect()->route('panel.session')
                    ->with('success', 'Seção atualizada com sucesso!');
        }
    }

    public function delete($id)
    {
        
        if(!$this->attachment($id)){
            return redirect()->route('panel.session')
                    ->with('warning', 'Você não pode excluir essa seção!');
        }
        $session = Product_sessions::find($id);
        if($session){
            $session->is_deleted = date('Y-m-d H:i:s');
            $session->save();
            $products = Product::where('session_id', $id)->where('is_deleted', null)->get();
            foreach($products as $product){
                $product->is_deleted = date('Y-m-d H:i:s');
                $product->save();
            }
            return redirect()->route('panel.session')
                    ->with('success', 'Seção excluída com sucesso!');
        }
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'commerce' => ['required'],
            'name' => ['required', 'string', 'max:100']
        ]);
    }

    protected function create(array $data){
        return Product_sessions::create([
            'commerce_id' => $data['commerce'],
            'user_id' => $data['userId'],
            'name' => ucfirst($data['name']),
            'updated_at' => null
        ]);
    }

    protected function limit($num){
        $user = Auth::user();
        if($user['permission'] == 1 || $user['permission'] == 2){
            $sessions = Product_sessions::where('user_id', $user['id'])->where('is_deleted', null)->get();
        }else{
            $sessions = Product_sessions::where('user_id', $user['user_creator'])->where('is_deleted', null)->get();
        }
        if(count($sessions) >= $num){
           return true; 
        }else{
            return false;
        }
    }

    protected function alert()
    {
        return redirect()->route('panel.session')
                ->with('limit', 'Você atingiu o limite máximo de seções cadastradas!');
    }

    protected function attachment($id){

        $ids = '';
        $data['sessions'] = $this->dbRequest();
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

    protected function dbRequest()
    {
        $user = Auth::user();
        $data = [];
        if($user['permission'] == 1){
           return $sessions = Product_sessions::where('is_deleted', null)->get();
        }
        if($user['permission'] == 2){
            return $sessions = Product_sessions::where('user_id', $user['id'])->where('is_deleted', null)->get();
        }else{
            return $sessions = Product_sessions::where('user_id', $user['user_creator'])->where('is_deleted', null)->get();
        }
    }

}
