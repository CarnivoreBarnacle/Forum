<?php

class ForumUser extends BaseModel{
    public $id, $userrole, $username, $password, $registered;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function all(){
        $statement = 'SELECT * FROM forumuser';
        $users = DatabaseService::get($statement, 'forumuser');
        
        return $users;
    }
    
    public static function find($id){
        $statement = 'SELECT * FROM forumuser WHERE id = :id';
        $values = array('id' => $id);
        $user = DatabaseService::get($statement, 'forumuser', $values, TRUE);
        
        return $user;
    }
    
    public function authenticate($username, $password){
        $statement = 'SELECT * FROM forumuser WHERE username = :username AND password = :password';
        $values = array('username' => $username, 'password' => $password);
        $user = DatabaseService::get($statement, 'forumuser', $values, TRUE);
        
        if($user){
            return $user;
        }
        return NULL;
    }
    
    
    //Functions relating to many to many connection between thread and user
    
    public static function findUsersPostedTo($thread_id){
        $statement = 'SELECT * FROM forumuser WHERE id IN (SELECT user_id FROM thread_user WHERE thread_id=:thread_id)';
        $values = array('thread_id' => $thread_id);
        
        $users = DatabaseService::get($statement, 'forumuser', $values);
        
        return $users;
    }
    
    public static function findAllPostsToThread($users, $thread_id){
        $statement = 'SELECT amount FROM thread_user WHERE user_id=:user_id AND thread_id=:thread_id';
        
        $amount = array();
        foreach($users as $user){
            $values = array('user_id' => $user->id, 'thread_id' => $thread_id);
            $amount[$user->id] = DatabaseService::get($statement, 'postamount', $values, True);
        }
        
        return $amount;
    }
    
    public static function findPostsToThread($user_id, $thread_id){
        $statement = 'SELECT amount FROM thread_user WHERE user_id=:user_id AND thread_id=:thread_id';
        $values = array('user_id' => $user_id, 'thread_id' => $thread_id);
        
        $amount = DatabaseService::get($statement, 'postamount', $values, True);
        
        return $amount;
    }
    
    public function increasePostAmount($thread_id){
        $amount = self::findPostsToThread($this->id, $thread_id);
        if($amount == NULL){
            $amount = 1;
        }else{
            $amount++;
        }
        
        $statement = 'UPDATE thread_user SET amount=:amount WHERE thread_id=:thread_id AND user_id=:user_id';
        $values = array('amount' => $amount, 'thread_id' => $thread_id, 'user_id' => $this->id);
        
        DatabaseService::save($statement, $values);
    }
}