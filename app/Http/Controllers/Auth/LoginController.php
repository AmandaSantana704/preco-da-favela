<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('admin.auth.login');
    }

    public function authenticate(Request $request)
    {
        $data = $request->only('email', 'password');
        $selectUser = User::where('email', $data['email'])->first();
        
        if($selectUser != array()){
            $validator = $this->validator($data);
        if($selectUser->is_deleted != null){
            $validator->errors()->add('userdeleted', 'O e-mail informado não existe!');
            return redirect()->route('login')
                    ->withErrors($validator);
        }
        $remember = $request->input('remember', false);
        
        if($validator->fails()){
            return redirect()->route('login')
                    ->withErrors($validator)
                    ->withInput();
        }
        if(Auth::attempt($data, $remember)){
            return redirect()->route('painel.home');
        }else{
            $validator->errors()->add('password', 'Email ou senha são inválidos');
            return redirect()->route('login')
                    ->withErrors($validator)
                    ->withInput();
        }
        }
        return redirect()->route('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    protected function validator($data)
    {
        return Validator::make($data, [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);
    }
}
