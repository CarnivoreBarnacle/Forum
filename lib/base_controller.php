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
    
    public static function check_thread_rights($thread_id){
        $user = self::get_user_logged_in();
        $id = Thread::find($thread_id)->user_id;
        
        if($user->userrole != 'ADMIN' && $user->id != $id){
            Redirect::to('/', array('message' => 'You have no authority to perform that action.'));
        }
    }
    
    public static function check_message_rights($message_id){
        $user = self::get_user_logged_in();
        $id = Message::find($message_id)->user_id;
        
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
    
    public static function get_usernames_from($list){
        $usernames = array();
        foreach($list as $item){
            $usernames[$item->user_id] = ForumUser::find($item->user_id)->username;
        }
        return $usernames;
    }
  }
