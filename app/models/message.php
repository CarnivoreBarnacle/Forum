<?php

class Message extends BaseModel{
    public $id, $user_id, $thread_id, $content, $created, $modified;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validateContent');
    }
    
    //Quite possibly not actually needed
    public static function all(){
        $statement = 'SELECT * FROM message ORDER BY created ASC';
        $messages = DatabaseService::get($statement, 'message');
        
        return $messages;
    }

    public static function find($id){
        $statement = 'SELECT * FROM Message WHERE id = :id';
        $values = array('id' => $id);
        $message = DatabaseService::get($statement, 'message', $values, TRUE);
        
        return $message;
    }
    
    public static function findByThread($thread_id){
        $statement = 'SELECT * FROM Message WHERE thread_id = :thread_id ORDER BY created ASC';
        $values = array('thread_id' => $thread_id);
        $messages = DatabaseService::get($statement, 'message', $values);
        
        return $messages;
    }
    
    public static function findByUser($user_id){
        $statement = 'SELECT * FROM Message WHERE user_id = :user_id ORDER BY created ASC';
        $values = array('user_id' => $user_id);
        $messages = DatabaseService::get($statement, 'message', $values);
        
        return $messages;
    }
    
    public function save(){
        $statement = 'INSERT INTO message (user_id, thread_id, content, created) VALUES (:user_id, :thread_id, :content, :created) RETURNING id';
        $values = $this->asArray();
        unset($values['modified']);
        
        $row = DatabaseService::save($statement, $values);
        $this->id = $row['id'];
    }
    
   public function update(){
        $statement = 'UPDATE message SET content=:content, modified=:modified WHERE id=:id';
        $values = array('id' => $this->id, 'modified'=> $this->modified, 'content' => $this->content);
        
        DatabaseService::save($statement, $values);
    }
    
    public function delete(){
        $statement = 'DELETE FROM message WHERE id=:id';
        $values = array('id' => $this->id);
        
        DatabaseService::execute($statement, $values);
    }
    
    //Validators
    public function validateContent(){
        $errors = array();
        if(!parent::validate_string_not_empty($this->content)){
            $errors[] = 'Message must not be empty';
        }
        if(!parent::validate_string_max($this->content, 2000)){
            $errors[] = 'Message must not be longer than 2000 characters';
        }
        
        return $errors;
    }
}