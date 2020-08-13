<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Mail\adminMail;
use App\Forgot;
use App\User;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;
 

    public function forgot()
    {
        return view('admin.auth.forgot');
    }

    public function recover(Request $request)
    {
        $data = $request->only('email');
        $search = User::where('email', $data['email'])->first();
        if($search){
            $token = md5(time().rand(0, 99999)).base64_encode($search->email).rand(0, 99999);
            $name = $data['name'];
            $email = trim($data['email']);
            $msg = route('gettokenpost').'?token='.$token;
            $subject = 'Recuperação de senha';

            Mail::to($data['email'])->send(new adminMail($name, $email, $msg, $subject));

            Forgot::create([
                'user_id' => $search->id,
                'token' => $token,
                'created_at' => date('Y-m-d H:i'),
                'expires_at' =>date('Y-m-d H:i', strtotime('+2 hours'))
            ]);
            return redirect()->route('login')
                    ->with('success', 'Enviamos as intruções de recuperação para o seu e-mail');
        }
        return redirect()->route('forgot')
                    ->with('warning', 'Não existe usuário cadastrado com o e-mail informado');

    }

    public function sendPassword(Request $request)
    {
        $data = $request->only('email', 'password', 'password_confirmation', 'accounttoken');
        $validator = $this->validator($data);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $user = User::where('email', $data['email'])->first();
        if($user){

            $getToken = Forgot::where('token', $data['accounttoken'])
                            ->where('used', 0)
                            ->where('expires_at', '>', 'NOW()')
                            ->first();

             if($getToken){

                $verifyToken = Forgot::where('token', $data['accounttoken'])
                                      ->where('used', 0)
                                      ->where('expires_at', '>', 'NOW()')
                                      ->where('user_id', $user->id)
                                      ->first();
                 if($verifyToken){
                    $currentUser = User::where('id', $getToken->user_id)->first();
                    $currentUser->password = Hash::make($data['password']);
                    $currentUser->save();
                    $getToken->used = 1;
                    $getToken->save();
                    return redirect()->route('login')
                            ->with('success', 'Senha atualizada com sucesso!');
                 }else{
                     $validator->errors()->add('notpermission', 'Você não tem permissão para atualizar a senha desse usuário!');
                    return back()->withErrors($validator);
                 }
                
               
             }else{
                 $validator->errors()->add('invalid', 'Token usado ou inválido');
                return redirect()->route('login')
                        ->withErrors($validator);
             }
        }
        $validator->errors()->add('notfound', 'Não existe usuário cadastrado com esse e-mail');
        return back()->withErrors($validator)->withInput();
        

       
    }

    public function getToken()
    {
        if(isset($_GET['token']) && !empty($_GET['token'])){
            return view('admin.auth.update', [
                'token' => $_GET['token']
            ]);
        }else{
           return redirect()->route('login');
        }
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'g-recaptcha-response' => 'required|captcha'
        ]);
    }
}
