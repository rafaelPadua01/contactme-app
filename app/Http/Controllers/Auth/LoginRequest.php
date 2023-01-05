<?php
    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use App\Http\Controllers\Auth\AuthenticatedSessionController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;

    class LoginRequest extends Controller
    {
        public function authenticate(Request $request){
            //$credentials = $request->validate([
            //    'email' => $request->email,
            //    'password' => $request->password,
            //]);
            
           try{
             if(Auth::attempt(['email' => $request->email,'password' => $request->password])){
                $request->session()->regenerate();
                $response = 'Usuario logado com sucesso';
                return  \Response::json($response); //redirect()->inteded('dashboard');
             }
             else{
                $response = 'Usuario não encontrado';
                return \Response::json($response);
             }
            
           }
           catch(Exception $e){
                return \Response::json($e);
           }
            

            //return back()->withErrors([
            //    'email' => 'The provided credentials do not match our records.',
            //])->onlyInput('email');
        }
    }