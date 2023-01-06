<?php
namespace App\Http\Controllers\Enterprise\Auth;

use \App\Http\Controllers\Controller;
use \App\Models\Company;
use \App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;

class RegisterEnterpriseController extends Controller{
    private $enterprise;

    public function __construct(Company $enterprises){
        $this->enterprise = $enterprises;
    }

    public function create(Request $request){
        try{
            $insert_enterprise = User::create([
                'name' => $request->nameEmp,
                'email' => $request->emailEmp,
                'password' => Hash::make($request->confirmPasswordEmp),
                'type' => 'enterprise',
            ]);
          
            event(new Registered($insert_enterprise));
            Auth::login($insert_enterprise);
            return \Response::json($insert_enterprise);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
      
    }
}