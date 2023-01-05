<?php
    namespace App\Http\Controllers\Client;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;


    class UserController extends Controller {
        private $user;

        public function __construct(UserController $user){
            $this->user = $user;
        }
        public function index(){
            $auth_user = Auth::user();
            return \Response::json($auth_user);
        }


    }