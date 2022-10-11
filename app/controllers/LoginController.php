<?php

namespace app\controllers;

use app\core\Request;
use app\database\models\Product;
use app\database\models\User;
use app\support\Validate;
use app\database\Connection;

class LoginController extends Controller
{
    /**
     * Method responsible for rendering dashboard
     *
     * @return void
     */
    public function form()
    {
    		
    	
        return $this->view('login');
    }


    public function store()
    {

        $validate = new Validate;
        $inputs = $validate->validate([
            'username' => 'required',
            'password' => 'required'
        ]);


        if (!$validate->validated($inputs)) {
            toastify('🔔 Não foi possível realizar o acesso', TOASTIFY_DANGER, 30000);
            return redirect(route('login'));
        }

        $user = new User;
        $username = $inputs['username'];
        $password = $inputs['password'];
        $userFind = $user->findByOne('username', '=', "{$username}");

        if (!$userFind) {
            toastify('🔔 Credenciais inválidas, tente novamente',  TOASTIFY_DANGER);
            return redirect(route('login'));
        }

        if (!password_verify($password, $userFind->password)) {
            toastify('🔔 Credenciais inválidas, tente novamente', TOASTIFY_DANGER);
            return redirect(route('login'));
        }

        setSession('authenticated', $userFind);
        return redirect(route('dashboard'));
    }
}
