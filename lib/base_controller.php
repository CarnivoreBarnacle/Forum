<?php

  class BaseController{

    public static function get_user_logged_in(){
      if(isset($_SESSION['user'])){
          $user_id = $_SESSION['user'];
          $user = ForumUser::find($user_id);
          
          return $user;
      }
      return null;
    }

    public static function check_logged_in(){
        if(!isset($_SESSION['user'])){
            Redirect::to('/login', array('errors' => array('Login required.')));
        }
    }
    
    public static function check_rights($id){
        $user = self::get_user_logged_in();
        if($user->userrole != 'ADMIN' && $user->id != $id){
            Redirect::to('/', array('message' => 'You have no authority to perform that action.'));
        }
    }
    
    public static function check_admin(){
        $user = self::get_user_logged_in();
        if($user->userrole != 'ADMIN'){
            Redirect::to('/', array('message' => 'You have no authority to perform that action.'));
        }
    }
  }
