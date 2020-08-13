<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Role;
use App\Plan;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();
        return view('admin.profile.update', [
            'user' => $user,
            'roles' => Role::where('id', $user->permission)->get()
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->only('name', 'password', 'password_confirmation', 'photo');
        $user = User::find(Auth::id());
        $validator = $this->validator($data);
        if($validator->fails()){
            return redirect()->route('panel.profile')
                    ->withErrors($validator);
        }
        $user->name = ucwords($data['name']);
        if(!empty($data['password'])){
            if(strlen($data['password']) >= 3){
                if($data['password'] === $data['password_confirmation']){
                    $user->password = Hash::make($data['password']);
                }else{
                    $validator->errors()->add('confirmed', 'O campo senha de confirmação não confere.');
                        return redirect()->route('panel.profile')
                            ->withErrors($validator);
                }
            }else{
                $validator->errors()->add('max', 'A senha dever ter no minímo 3 caracteres');
                return redirect()->route('panel.profile')
                    ->withErrors($validator);
            }
        }

        if(!empty($data['photo'])){
            $request->validate([
                'photo' => 'image|mimes:jpeg,jpg,png|max:1000'
            ]);
            if(!empty($request->file('photo')) && $request->file('photo')->isValid()){
                $extPhoto = $request->file('photo')->extension();
                $photoName = time().rand(0, 999999).md5(time()).'.'.$extPhoto;
                $request->file('photo')->move(public_path('images/users'), $photoName); 
                $user->photo = $photoName;
            }
        }
        
        $user->save();
        return redirect()->route('painel.home')
                ->with('success', 'Perfil atualizado com sucesso!');
    }

    public function suport()
    {
        return view('admin.profile.suport');
    }

    public function myaccount()
    {
        $islogged = Auth::user();
        if($islogged->permission == 1 || $islogged->permission == 2){
              $user = User::find($islogged->id);
              $plan = Plan::find($user->plan);

              return view('admin.profile.myaccount', [
                  'plan' => $plan
              ]);
        }
        return redirect()->route('painel.home');
      
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:100']
        ]);
    }
}
