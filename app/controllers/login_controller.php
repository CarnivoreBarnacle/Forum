<?php

//Controller responsible for login, register and logout
class LoginController extends BaseController{
    
    public static function login(){
        View::make('login.html');
    }
    
    public static function register(){
        View::make('register.html');
    }
    
    
    //Authenticates user using ForumUser's authenticate method
    //Upon success, saves user_id to session and redirects user to frontpage
    //Upon failure displays errors on login page
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
    
    //Clears user_id from session and redirects user to login-page
    public static function logout(){
        $_SESSION['user'] = null;
        Redirect::to('/login', array('errors' => array('You have logged out.')));
    }
    
    //Adds user to database, sets user_id to session and redirects user to frontpage
    //TODO: make sure username is not taken!
    public static function createAccount(){
        $params = $_POST;
        $time = date('Y-m-d G:i:s');
        $params['userrole'] = 'USER';
        $params['registered'] = $time;
        
        $user = new ForumUser($params);
        $user->save();

        $_SESSION['user'] = $user->id;

        Redirect::to('/', array('message'=>'Welcome '.$user->username));
    }
}