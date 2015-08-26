<?php

class Thread extends BaseModel{
    
    public $id, $user_id, $name, $created, $lastpost;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validateName');
    }
    
    //Gets all thread from database
    public static function all(){
        $statement = 'SELECT thread.*, forumuser.username AS username'
                . ' FROM thread LEFT JOIN forumuser'
                . ' ON thread.user_id = forumuser.id'
                . ' ORDER BY lastpost DESC';
        $threads = DatabaseService::get($statement);
        
        return $threads;
    }
    
    //Finds single thread from database by id
    public static function find($id){
        $statement = 'SELECT thread.*, forumuser.username as username'
                . ' FROM thread INNER JOIN forumuser'
                . ' ON thread.user_id = forumuser.id'
                . ' WHERE thread.id = :id';
        $values = array('id' => $id);
        $thread = DatabaseService::get($statement, $values, TRUE);
        
        return $thread;
    }
    
    //Finds thread created by user
    public static function findByUser($user_id){
        $statement = 'SELECT thread.*, forumuser.username as username'
                . ' FROM thread INNER JOIN forumuser'
                . ' ON thread.user_id = forumuser.id'
                . ' WHERE thread.user_id = :user_id';
        $values = array('user_id' => $user_id);
        $thread = DatabaseService::get($statement, $values);
        
        return $thread;
    }
    
    //Saves thread
    public function save(){
        $statement = 'INSERT INTO thread (user_id, name, created, lastpost) VALUES (:user_id, :name, :created, :lastpost) RETURNING id';
        $values = $this->asArray();
        
        $row = DatabaseService::save($statement, $values);
        $this->id = $row['id'];
    }
    
    //Updates thread
    public function update(){
        $statement = 'UPDATE thread SET name=:name WHERE id=:id';
        $values = array('id' => $this->id, 'name' => $this->name);
        
        DatabaseService::save($statement, $values);
    }
    
    //Updates lastPost value of thread (called when creating message)
    public function updateLastpost($lastpost){
        $statement = 'UPDATE thread SET lastpost=:lastpost WHERE id=:id';
        $values = array('id' => $this->id, 'lastpost' => $lastpost);
        
        DatabaseService::save($statement, $values);
    }
    
    //Removes thread and every message related to it as well as all thread_user rows related to it
    public function delete(){
        $statement1 = 'DELETE FROM thread WHERE id=:id';
        //To delete all messages posted to thread
        $statement2 = 'DELETE FROM message WHERE thread_id=:id';
        $statement3 = 'DELETE FROM thread_user WHERE thread_id=:id';
        
        $values = array('id' => $this->id);
        
        DatabaseService::execute($statement3, $values);
        DatabaseService::execute($statement2, $values);
        DatabaseService::execute($statement1, $values);
    }
    
    
    //Validators
    public function validateName(){
        $errors = array();
        if(!parent::validate_string_not_empty($this->name)){
            $errors[] = 'Name must not be empty';
        }
        if(!parent::validate_string_min($this->name, 3)){
            $errors[] = 'Name must be at least 3 characters';
        }
        if(!parent::validate_string_max($this->name, 100)){
            $errors[] = 'Name must be at no longer than 100 characters';
        }
        
        return $errors;
    }
}
