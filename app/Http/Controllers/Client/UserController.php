<?php
    namespace App\Http\Controllers\Client;

    use App\Http\Controllers\Controller;
    use App\Models\User;
    use Illuminate\Support\Facades\Auth;


    class UserController extends Controller {
        private $users;

        public function __construct(UserController $user){
            $this->users = $users;
        }
        public function index(){
            $auth_user = Auth::user();
            return \Response::json($auth_user);
        }
}