<?php
    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use App\Http\Controllers\Auth\AuthenticatedSessionController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;
    use App\Models\User;

    class LoginRequest extends Controller
    {
        public function authenticate(Request $request){
            try{
                if(Auth::attempt(['email' => $request->email,'password' => $request->password])){
                    $request->session()->regenerate();
                    $response = 'Usuario logado com sucesso';
                    $response = User::where('email', '=', $request->email)->first();
                    return  \Response::json($response); 
                }
                else{
                    $response = 'Usuario não encontrado';
                    return \Response::json($response);
                }
            }
           catch(Exception $e){
                return \Response::json($e);
           }
            
        }
    }