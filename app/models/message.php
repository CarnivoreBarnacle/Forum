<?php

class Message extends BaseModel{
    public $id, $user_id, $thread_id, $content, $created, $modified;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    //Quite possibly not actually needed
    public static function all(){
        $statement = 'SELECT * FROM message';
        $messages = DatabaseService::get($statement, 'message');
        
        return $messages;
    }
    
    public static function thread($thread_id){
        $statement = 'SELECT * FROM Message WHERE thread_id = :thread_id';
        $values = array('thread_id' => $thread_id);
        $messages = DatabaseService::get($statement, 'message', $values);
        
        return $messages;
    }
    
    public static function find($id){
        $statement = 'SELECT * FROM Message WHERE id = :id';
        $values = array('id' => $id);
        $message = DatabaseService::get($statement, 'message', $values);
        
        return $message;
    }
}