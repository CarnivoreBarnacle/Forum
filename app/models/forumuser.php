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
}