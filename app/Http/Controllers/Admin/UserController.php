<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;

class UserController extends Controller
{
    public function __construct()
    {
        
        $this->middleware('auth');
        $this->middleware('permissioncommerce');
        
    }

    public function index()
    {
        $user = Auth::user();
        switch($user['permission']){
            case 1:
                $data['users'] = DB::table('users')
                    ->join('roles', 'users.permission', '=', 'roles.id')
                    ->select('users.*', 'roles.display_name')
                    ->get();
                break;
            case 2:
                $data['users'] = DB::table('users')
                    ->join('roles', 'users.permission', '=', 'roles.id')
                    ->select('users.*', 'roles.display_name')
                    ->where('user_creator', Auth::id())
                    ->get();
                break;
            default:
                return redirect()->route('painel.home');
            break;
        }
        $data['isLogged'] = Auth::id();
        if($data){
            return view('admin.user.main', $data);
        }
        return redirect()->route('painel.home');
    }

    public function register()
    {
        $user = Auth::user();
        $role = Role::all();
        $data = [];
        if($user['permission'] != 1){
            $data['roles'] = $role->forget([0, 1]);
        }
        $data['roles'] = $role;

        return view('admin.user.create', $data);
    }

    public function save(Request $request)
    {

        $data = $request->only('name', 'permission', 'email', 'password', 'password_confirmation');
        $usersDb = User::all();
        $validator = $this->validator($data);
        if($validator->fails()){
            return redirect()->route('user.register')
                    ->withErrors($validator)
                    ->withInput();
        }
        foreach($usersDb as $userDb){
            if($userDb->is_deleted === null){
                if($data['email'] === $userDb->email){
                    $validator->errors()->add('unique', 'Já existe um usuário com este e-mail!');
                    return redirect()->route('user.register')
                    ->withErrors($validator)
                    ->withInput();
                } 
            }
        }
        $user = Auth::user();
        if($user['permission'] == 2){
            $data['plan'] = $user['plan'];
        }
        switch($user['plan']){
            case 1:
                if($this->limit(2)){
                    return redirect()->route('panel.user')
                    ->with('warning', 'Você atingiu o limite máximo de usuários cadastrados!');
                }
            break;
            case 2:
                if($this->limit(4)){
                    return redirect()->route('panel.user')
                    ->with('warning', 'Você atingiu o limite máximo de usuários cadastrados!');
                }
            break;
            case 3:
                if($this->limit(8)){
                    return redirect()->route('panel.user')
                    ->with('warning', 'Você atingiu o limite máximo de usuários cadastrados!');
                }
            break;
            case 4:
                if($this->limit(1000000)){
                    return redirect()->route('panel.user')
                    ->with('warning', 'Você atingiu o limite máximo de usuários cadastrados!');
                }
            break;
            default:
                return redirect()->route('panel.user');
            break;
        }
        $this->create($data);
        return redirect()->route('panel.user')
                ->with('successRegister', 'Usuário criado com sucesso!');

    }

    public function edit(Request $request, $id)
    {
        if(!$this->attachment($id)){
            return redirect()->route('panel.user')
                    ->with('warning', 'Você não pode atualizar esse usuário!');
        }
        $user = Auth::user();
        $role = Role::all();
        $data = [];
        if($user['permission'] != 1){
            $data['roles'] = $role->forget([0, 1]);
        }
        $data['roles'] = $role;
        $data['user'] = User::find($id);
   
        return view('admin.user.update', $data);
    }

    public function update(Request $request, $id)
    {
        if(!$this->attachment($id)){
            return redirect()->route('panel.user')
                    ->with('warning', 'Você não pode atualizar esse usuário!');
        }
        $data = $request->only('name', 'permission','email', 'password', 'password_confirmation');
        $user = User::find($id);
        $validator = Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'permission' => ['required'],
        ]);
        if(!empty($data['password'])){
            if($data['password'] != $user->password){
                if(strlen($data['password']) >= 6){
                    if($data['password'] === $data['password_confirmation']){
                        $user->password = Hash::make($data['password']);
                    }else{
                        $validator->errors()->add('confirmed', 'O campo senha de confirmação não confere.');
                        return redirect()->route('user.edit', ['id'=>$id])
                            ->withErrors($validator);
                    }
                }else{
                    $validator->errors()->add('max', 'A senha dever ter no minímo 3 caracteres');
                    return redirect()->route('user.edit', ['id'=>$id])
                            ->withErrors($validator);
                }
            }
        }
        if($validator->fails()){
            return redirect()->route('user.edit', ['id'=>$id])
                    ->withErrors($validator);
        }

        $user->name = ucwords($data['name']);
        $user->permission = $data['permission'];
        $user->save();
        return redirect()->route('panel.user')
                ->with('success', 'Usuário atualizado com sucesso!');
       
    }

    public function delete(Request $request, $id)
    {
        if(!$this->attachment($id)){
            return redirect()->route('panel.user')
                    ->with('warning', 'Você não pode excluir esse usuário!');
        }
        if($id == Auth::id()){
            return redirect()->route('panel.user')
                    ->with('warning', 'Você não pode excluir o seu próprio usuário!');
        }
        $user = User::find($id);
        if($user){
            $date = date('Y-m-d H:i:s');
            $user->is_deleted = $date;
            $user->save();

            DB::table('products')
                ->join('product_sessions', 'products.session_id', '=', 'product_sessions.id')
                ->join('commerces', 'product_sessions.commerce_id', '=', 'commerces.id')
                ->select('commerces.is_deleted', 'products.is_deleted', 'product_sessions.is_deleted')
                ->where('commerces.user_id', $id)
                ->update(['commerces.is_deleted' => $date, 'products.is_deleted' => $date, 'product_sessions.is_deleted' => $date]);

            return redirect()->route('panel.user')
                    ->with('delMsg', 'Usuário excluido com sucesso!');
        }
        return redirect()->route('panel.user');
    }

    protected function validator(array $data){
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100'],
            'permission' => ['required'],
            'email' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed']
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => ucwords($data['name']),
            'permission' => $data['permission'],
            'plan' => $data['plan'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'updated_at' => null,
            'user_creator' => Auth::id()
        ]);
    }

    protected function limit($num){
        $user = Auth::user();
        $dbUsers = User::where('user_creator', $user['id'])->where('is_deleted', null)->get();
        if(count($dbUsers) >= $num){
            return true; 
        }else{
            return false;
        }
    }

    protected function attachment($id){

        $ids = '';
        $data['accounts'] = $this->dbRequest();
        foreach($data['accounts'] as $account){
            $ids .= $account->id.',';
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
           return $accounts = User::where('is_deleted', null)->get();
        }
        if($user['permission'] == 2){
            return $accounts = User::where('user_creator', $user['id'])->where('is_deleted', null)->get();
        }
    }
  

}
