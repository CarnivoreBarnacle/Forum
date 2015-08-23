<?php

class ForumUser extends BaseModel{
    public $id, $userrole, $username, $password, $registered;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    //Return all user from database (UNUSED)
    public static function all(){
        $statement = 'SELECT * FROM forumuser';
        $users = DatabaseService::get($statement);
        
        return $users;
    }
    
    //Finds single user by id
    public static function find($id){
        $statement = 'SELECT * FROM forumuser WHERE id = :id';
        $values = array('id' => $id);
        $user = DatabaseService::get($statement, $values, TRUE);
        
        return $user;
    }
    
    //Saves user to database
    public function save(){
        $statement = 'INSERT INTO forumuser (userrole, username, password, registered) VALUES (:userrole, :username, :password, :registered) RETURNING id';
        $values = $this->asArray();
        
        $row = DatabaseService::save($statement, $values);
        $this->id = $row['id'];
    }
    
    //Check wheter database contains user matching username, password
    public function authenticate($username, $password){
        $statement = 'SELECT * FROM forumuser WHERE username = :username AND password = :password';
        $values = array('username' => $username, 'password' => $password);
        $user = DatabaseService::get($statement, $values, TRUE);
        
        if($user){
            return new ForumUser($user);
        }
        return NULL;
    }

    //Functions relating to many to many connection between thread and user
    
    //Finds user who have participated to a thread and the amount of posts they have made to it
    public static function findParticipants($thread_id){
        $statement = 'SELECT forumuser.id, forumuser.username, thread_user.amount FROM forumuser '
                . ' INNER JOIN thread_user'
                . ' ON forumuser.id = thread_user.user_id'
                . ' WHERE thread_user.thread_id = :thread_id';
        $values = array('thread_id' => $thread_id);
        
        $users = DatabaseService::get($statement, $values);
        
        return $users;
    }
    
    //Change the number of posts to thread user has made
    //If no previous row exists, inserts new one
    //If amount drops to 0 removes the row
    public static function changePostAmount($user_id, $thread_id, $change){
        $res = self::findNumberOfMessages($user_id, $thread_id);
        if($res == NULL){
            $statement = 'INSERT INTO thread_user (user_id, thread_id, amount) VALUES (:user_id, :thread_id, :amount) ';
            $amount = 0;
        }else{
            $statement = 'UPDATE thread_user SET amount=:amount WHERE thread_id=:thread_id AND user_id=:user_id';
            $amount = $res['amount'];
        }
        $amount += $change;
        
        if($amount <= 0){
            self::deleteParticipation($user_id, $thread_id);
            return;
        }
        
        $values = array('amount' => $amount, 'thread_id' => $thread_id, 'user_id' => $user_id);
        DatabaseService::save($statement, $values);
    }
    
    //Finds how many messages user has posted to thread
    private static function findNumberOfMessages($user_id, $thread_id){
        $statement = 'SELECT amount FROM thread_user WHERE user_id = :user_id AND thread_id = :thread_id';
        $values = array('user_id' => $user_id, 'thread_id' => $thread_id);
        
        $result = DatabaseService::get($statement, $values, TRUE);
        
        return $result;
    }
    
    //Removes row from thread_user-table
    private static function deleteParticipation($user_id, $thread_id){
        $statement = 'DELETE FROM thread_user WHERE user_id = :user_id AND thread_id = :thread_id';
        $values = array('user_id' => $user_id, 'thread_id' => $thread_id);
        
        DatabaseService::execute($statement, $values);
    }
}