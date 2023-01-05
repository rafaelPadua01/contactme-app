<?php
    namespace App\Http\Controllers\Auth;

    use App\Http\Controllers\Controller;
    use App\Http\Controllers\Auth\AuthenticatedSessionController;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Auth;


    class LogoutRequest extends Controller
    {
        public function logout(Request $request){
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();

            $response = 'Fazendo logout, clique em ok para concluir';

            return \Response::json($response);
        }

    }