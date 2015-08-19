<?php

class LoginController extends BaseController{
    
    public static function login(){
        View::make('login.html');
    }
    
    public static function handleLogin(){
        $params = $_POST;
        
        $user = ForumUser::authenticate($params['username'], $params['password']);
        
        if(!$user){
            View::make('login.html', array('errors' => array('Wrong username or password!'), 'username' => $params['username']));
        } else{
            $_SESSION['user'] = $user->id;
            
            Redirect::to('/', array('message'=>'Welcome '.$user->username));
        }
    }
    
    public static function logout(){
        $_SESSION['user'] = null;
        Redirect::to('/login', array('errors' => array('You have logged out.')));
    }
}