<?php

class Thread extends BaseModel{
    
    public $id, $user_id, $name, $created, $lastpost;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validateName');
    }
    
    public static function all(){
        $statement = 'SELECT * FROM thread ORDER BY lastpost DESC';
        $threads = DatabaseService::get($statement, 'thread');
        
        return $threads;
    }
    
    public static function find($id){
        $statement = 'SELECT * FROM thread WHERE id = :id';
        $values = array('id' => $id);
        $thread = DatabaseService::get($statement, 'thread', $values, TRUE);
        
        return $thread;
    }
    
    public static function findByUser($user_id){
        $statement = 'SELECT * FROM thread WHERE user_id = :user_id ORDER BY created DESC';
        $values = array('user_id' => $user_id);
        $thread = DatabaseService::get($statement, 'thread', $values);
        
        return $thread;
    }
    
    public function save(){
        $statement = 'INSERT INTO thread (user_id, name, created, lastpost) VALUES (:user_id, :name, :created, :lastpost) RETURNING id';
        $values = $this->asArray();
        
        $row = DatabaseService::save($statement, $values);
        $this->id = $row['id'];
    }
    
    public function update(){
        $statement = 'UPDATE thread SET name=:name WHERE id=:id';
        $values = array('id' => $this->id, 'name' => $this->name);
        
        DatabaseService::save($statement, $values);
    }
    
    public function updateLastpost($lastpost){
        $statement = 'UPDATE thread SET lastpost=:lastpost WHERE id=:id';
        $values = array('id' => $this->id, 'lastpost' => $lastpost);
        
        DatabaseService::save($statement, $values);
    }
    
    public function delete(){
        $statement1 = 'DELETE FROM thread WHERE id=:id';
        //To delete all messages posted to thread
        $statement2 = 'DELETE FROM message WHERE thread_id=:id';
        
        $values = array('id' => $this->id);
        
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
