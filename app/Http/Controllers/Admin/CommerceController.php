<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Commerce;
use App\Commerce_access;
use App\Commerce_category;
use App\User;


class CommerceController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        $data['commerces'] = $this->dbRequest();
        

        $data['permission'] = $user['permission'];
        if(count($data) > 0){
            return view('admin.commerce.main', $data);
        }else{
            return redirect()->route('painel.home');
        }

    }
  
    public function register(Request $request)
    {
        $user = Auth::user();
        if($user['permission'] != 1 && $user['permission'] != 2){
            return redirect()->route('panel.commerce')
                    ->with('warning', 'Você não permissão para criar um novo comércio!');
        }
        return view('admin.commerce.register', [
            "categorys" => Commerce_category::orderBy('name')->get()
        ]);
    }
    
    public function save(Request $request)
    {
        $user = Auth::user();
        if($user['permission'] != 1 && $user['permission'] != 2){
            return redirect()->route('panel.commerce')
                    ->with('warning', 'Você não permissão para criar um novo comércio!');
        }
       
        $data = $request->only(
            'name',
            'category',
            'description',
            'operation',
            'telephone',
            'email',
            'instagram',
            'whatsapp',
            'location',
            'district',
            'logo',
            'cover',
            'lat',
            'lng'
        );
        $validator = $this->validator($data);
        if($validator->fails()){
            return redirect()->route('commerce.register')
                    ->withErrors($validator)
                    ->withInput();
        }
        if($data['lat'] && $data['lng'] === 'null'){
            $validator->errors()->add('geolocation', 'Por favor, informe a sua localização!');
            return redirect()->route('commerce.register')
                    ->withErrors($validator)
                    ->withInput();
        }
        if(Commerce::where('user_id', Auth::id())->where('name', ucwords($data['name']))->where('is_deleted', null)->first()){
            $validator->errors()->add('unique', 'Você já cadastrou um comércio com este nome');
            return redirect()->route('commerce.register')
                    ->withErrors($validator)
                    ->withInput();
        }
        $request->validate([
            'file' => ['image|mimes:jpeg,jpg,png|max:1000']
        ]);
        $request->validate([
            'logo' => 'image|mimes:jpeg,jpg,png|max:1000',
            'cover' => 'image|mimes:jpeg,jpg,png|max:1000'
        ]);
        $logoName = null;
        $coverName = null;
        if(!empty($request->file('logo')) && $request->file('logo')->isValid()){
            $extLogo = $request->file('logo')->extension();
            $logoName = time().rand(0, 999999).md5(time()).'.'.$extLogo;
            $request->file('logo')->move(public_path('images/commerce'), $logoName); 
        }
        if(!empty($request->file('cover')) && $request->file('cover')->isValid()){
            $ext = $request->file('cover')->extension();
            $coverName = time().rand(0, 999999).md5(time()).'.'.$ext;
            $request->file('cover')->move(public_path('images/commerce'), $coverName);
        }

        switch($user['plan']){
            case 1:
                if($this->limit(1)){
                    return $this->alert();
                }
            break;
            case 2:
                if($this->limit(2)){
                    return $this->alert();
                }
            break;
            case 3:
                if($this->limit(4)){
                    return $this->alert();
                }
            break;
            case 4:
                if($this->limit(1000000)){
                    return $this->alert();
                }
            break;
            default:
                return redirect()->route('panel.commerce');
            break;
        }
        $this->create($data, $logoName, $coverName);
                return redirect()->route('panel.commerce')
                ->with('successRegister', 'Comércio cadastrado com sucesso!');
    }

    public function edit($id)
    {
        $user = Auth::user();
        if($user['permission'] != 1 && $user['permission'] != 2 && $user['permission'] != 3){
            return redirect()->route('panel.commerce')
                    ->with('warning', 'Você não tem permissão para atualizar esse comércio!');
        }
        if(!$this->attachment($id)){
            return redirect()->route('panel.commerce')
                    ->with('warning', 'Você não pode acessar esse comércio!');
        }
        $notPermission = Commerce_access::where('commerce_id', $id)->where('user_id', Auth::id())->where('is_deleted', null)->get();
        $infos = Commerce::find($id);
        if($user['permission'] == 3){
            if(count($notPermission) > 0){
                if($infos){
                    return view('admin.commerce.update', [
                        "categorys" => Commerce_category::orderBy('name')->get(),
                        "infos" => $infos
                    ]);
                }
            }else{
                return redirect()->route('panel.commerce')
                        ->with('warning', 'Você não tem permissão para atualizar esse comércio!');
            }
        }

        if($infos){
            return view('admin.commerce.update', [
                "categorys" => Commerce_category::orderBy('name')->get(),
                "infos" => $infos
            ]);
        }
         
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if($user['permission'] != 1 && $user['permission'] != 2 && $user['permission'] != 3){
            return redirect()->route('panel.commerce')
                    ->with('warning', 'Você não tem permissão para atualizar comércio!');
        }
        if(!$this->attachment($id)){
            return redirect()->route('panel.commerce')
                    ->with('warning', 'Você não pode atualizar esse comércio!');
        }
        $data = $request->only(
            'name',
            'category',
            'description',
            'operation',
            'telephone',
            'email',
            'instagram',
            'whatsapp',
            'location',
            'district',
            'logo',
            'cover',
            'lat',
            'lng'
        );
        $validator = $this->validator($data);
        if($validator->fails()){
            return redirect()->route('commerce.edit', ['id'=>$id])
                    ->withErrors($validator)
                    ->withInput();
        }
        $dbInfos = Commerce::find($id);
        $dbInfosAll = Commerce::where('user_id', Auth::id());

        if($data['name'] != $dbInfos->name){
            $dbInfos->name = ucwords($data['name']);
        }
        $request->validate([
            'logo' => 'image|mimes:jpeg,jpg,png|max:1000',
            'cover' => 'image|mimes:jpeg,jpg,png|max:1000'
        ]);
        if(!empty($request->file('logo')) && $request->file('logo')->isValid()){
            $extLogo = $request->file('logo')->extension();
            $logoName = time().rand(0, 999999).md5(time()).'.'.$extLogo;
            $dbInfos->logo = $logoName;
            $request->file('logo')->move(public_path('images/commerce'), $logoName); 
        }
        if(!empty($request->file('cover')) && $request->file('cover')->isValid()){
            $ext = $request->file('cover')->extension();
            $coverName = time().rand(0, 999999).md5(time()).'.'.$ext;
            $dbInfos->cover = $coverName;
            $request->file('cover')->move(public_path('images/commerce'), $coverName);
        }
        

        $notPermission = Commerce_access::where('commerce_id', $id)->where('user_id', Auth::id())->where('is_deleted', null)->get();
        if($user['permission'] == 3){
            if(count($notPermission) == 0){
                return redirect()->route('panel.commerce')
                        ->with('warning', 'Você não tem permissão para atualizar esse comércio!');
            }
        }

        $dbInfos->category = $data['category'];
        $dbInfos->description = $data['description'];
        $dbInfos->operation = $data['operation'];
        $dbInfos->telephone = $data['telephone'];
        $dbInfos->email = $data['email'];
        $dbInfos->instagram = $data['instagram'];
        $dbInfos->whatsapp = $data['whatsapp'];
        $dbInfos->location = $data['location'];
        $dbInfos->district = $data['district'];
        $dbInfos->lat = $data['lat'];
        $dbInfos->lng = $data['lng'];
        $dbInfos->updated_at = date('Y-m-d H:i:s');
        $dbInfos->save();

        return redirect()->route('panel.commerce')
                ->with('success', 'Comércio atualizado com sucesso!');
        
    }

    public function delete(Request $request, $id)
    {
        $user = Auth::user();
        if($user['permission'] != 1 && $user['permission'] != 2){
            return redirect()->route('panel.commerce')
                    ->with('warning', 'Você não permissão para excluir comércio!');
        }
        if(!$this->attachment($id)){
            return redirect()->route('panel.commerce')
                    ->with('warning', 'Você não pode excluir esse comércio!');
        }
       $commerce = Commerce::find($id);
       
       if($commerce){
           $date = date('Y-m-d H:i:s');
           $commerce->is_deleted = $date;
           $commerce->save();

           DB::table('products')
                ->join('product_sessions', 'products.session_id', '=', 'product_sessions.id')
                ->select('products.is_deleted', 'product_sessions.is_deleted')
                ->where('product_sessions.commerce_id', $id)
                ->where('products.is_deleted', null)
                ->update(['products.is_deleted' => $date, 'product_sessions.is_deleted' => $date]);

           return redirect()->route('panel.commerce')
                 ->with('delMsg', 'Comércio excluído com sucesso!');
       }
       return redirect()->route('panel.commerce');
    }

    public function manage($id)
    {
        $user = Auth::user();
        if($user['permission'] != 1 && $user['permission'] != 2){
            return redirect()->route('panel.commerce')
                    ->with('warning', 'Você não tem permissão para gerenciar comércio!');
        }
        if(!$this->attachment($id)){
            return redirect()->route('panel.commerce')
                    ->with('warning', 'Você não pode gerenciar esse comércio!');
        }
        $data['commerces'] = DB::table('commerce_access')
                ->join('users', 'commerce_access.user_id', '=', 'users.id')
                ->join('commerces', 'commerce_access.commerce_id', '=', 'commerces.id')
                ->select('commerce_access.*', 'users.name AS user_name', 'commerces.name')
                ->where('commerce_access.commerce_id', $id)
                ->where('commerce_access.is_deleted', null)
                ->get();
        if($user['permission'] == 1){
            $data['users'] = User::where('permission', 3)->where('is_deleted', null)->get();
        }else{
            $data['users'] = User::where('permission', 3)->where('user_creator', Auth::id())->where('is_deleted', null)->get();
        }
        
        $data['commerce_id'] = $id;
        $data['count'] = count($data['commerces']);
        return view('admin.commerce.manage', $data);
    }

    public function add(Request $request, $id)
    {
        $user = Auth::user();
        if($user['permission'] != 1 && $user['permission'] != 2){
            return redirect()->route('panel.commerce')
                    ->with('warning', 'Você não tem permissão para gerenciar comércio!');
        }
        $data = $request->only('user');
        $commerces = Commerce_access::where('commerce_id', $id)->get();
        if(!empty($data['user'])){
            foreach($commerces as $commerce){
                if($commerce->is_deleted === null){
                    if($commerce->user_id == $data['user']){
                        return redirect()->route('commerce.manage', ['id'=>$id])
                                ->with('unique', 'O usuário selecionado já tem acesso a esse comércio!');
                    }
                }
            }
            Commerce_access::create([
                'commerce_id' => $id,
                'user_id' => $data['user'],
                'updated_at' => null
            ]);
            return redirect()->route('commerce.manage', ['id'=>$id])
                    ->with('success', 'Usuário autorizado com sucesso!');
        }
        
        return redirect()->route('commerce.manage', ['id'=>$id])
                ->with('warning', 'O campo usuário é obrigatório!');
    }

    public function unlink(Request $request, $id)
    {
        $user = Auth::user();
        if($user['permission'] != 1 && $user['permission'] != 2){
            return redirect()->route('panel.commerce')
                    ->with('warning', 'Você não tem permissão para gerenciar comércio!');
        }
        $data = $request->only('commerce_id');
        $commerce = Commerce_access::find($id);
        $commerce->is_deleted = date('Y-m-d H:i:s');
        $commerce->save();
       
        return redirect()->route('commerce.manage', ['id'=>$data['commerce_id']])
                ->with('success', 'O usuário desvinculado com sucesso!');

    }
    protected function validator($data)
    {
        return Validator::make($data, [
            'name' => ['string', 'required', 'max:50'],
            'category' => ['required'],
            'location' => ['required', 'string', 'max:200'],
            'district' => ['required', 'string', 'max:50'],
            'description' => ['max:200'],
            'instagram' => ['max:100'],
            'whatsapp' => ['max:20']
        ]);
    }

    protected function create(array $data, $logoName, $coverName)
    {
        return Commerce::create([
            'user_id' => Auth::id(),
            'name' => ucwords($data['name']),
            'category' => intval($data['category']),
            'description' => $data['description'],
            'operation' => $data['operation'],
            'telephone' => $data['telephone'],
            'email' => $data['email'],
            'instagram' => $data['instagram'],
            'whatsapp' => $data['whatsapp'],
            'location' => ucwords($data['location']),
            'district' => ucwords($data['district']),
            'logo' => $logoName,
            'cover' => $coverName,
            'lat' => $data['lat'],
            'lng' => $data['lng'],
            'updated_at' => null
        ]);
    }

    protected function limit($num){
        $user = Auth::user();
        $commerces = Commerce::where('user_id', $user['id'])->where('is_deleted', null)->get();
        if(count($commerces) >= $num){
           return true; 
        }else{
            return false;
        }
    }

    protected function alert()
    {
        return redirect()->route('panel.commerce')
                ->with('limit', 'Você atingiu o limite máximo de comércios cadastrados!');
    }

    protected function attachment($id){

        $ids = '';
        $data['commerces'] = $this->dbRequest();
        foreach($data['commerces'] as $commerce){
            $ids .= $commerce->id.',';
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

        switch($user['permission']){
            case 1:
                return $data['commerces'] = DB::table('commerces')
                ->join('commerce_categorys', 'commerce_categorys.id', '=', 'commerces.category')
                ->join('users', 'users.id', '=', 'commerces.user_id')
                ->select('commerces.*', 'commerce_categorys.name AS category_name', 'users.name AS user_name')
                ->get();
                break;
            case 2:
                return $data['commerces'] = DB::table('commerces')
                ->join('commerce_categorys', 'commerce_categorys.id', '=', 'commerces.category')
                ->join('users', 'users.id', '=', 'commerces.user_id')
                ->select('commerces.*', 'commerce_categorys.name AS category_name', 'users.name AS user_name')
                ->where('user_id', Auth::id())
                ->get();
                break;
            case 3:
                return $data['commerces'] = DB::table('commerces')
                ->join('commerce_access', 'commerces.id', '=', 'commerce_access.commerce_id')
                ->join('commerce_categorys', 'commerce_categorys.id', '=', 'commerces.category')
                ->join('users', 'users.id', '=', 'commerces.user_id')
                ->select('commerces.*', 'commerce_categorys.name AS category_name', 'users.name AS user_name')
                ->where('commerce_access.user_id', Auth::id())->where('commerce_access.is_deleted', null)
                ->get();
                break;
            case 4:
                return redirect()->route('painel.home');
                break;
            default:    
                return redirect()->route('painel.home');
                break;
        }
    }
    
}
