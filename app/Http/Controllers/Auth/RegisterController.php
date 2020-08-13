<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function index()
    {
        return view('admin.auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->only('name', 'email', 'password', 'password_confirmation');
        $usersDb = User::all();
        $validator = $this->validator($data);
        if($validator->fails()){
            return redirect()->route('panel.register')
                    ->withErrors($validator)
                    ->withInput();
        }
        foreach($usersDb as $userDb){
            if($userDb->is_deleted === null){
                if($data['email'] === $userDb->email){
                    $validator->errors()->add('unique', 'Já existe um usuário com este e-mail!');
                    return redirect()->route('panel.register')
                    ->withErrors($validator)
                    ->withInput();
                } 
            }
        }

        $user = $this->create($data);
        Auth::login($user);
        return redirect()->route('painel.home');
        
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:50'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'g-recaptcha-response' => 'required|captcha'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => ucwords($data['name']),
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'permission' => 2,
            'plan' => 1,
            'updated_at' => null
        ]);
    }
}
