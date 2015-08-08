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

    public static function find($id){
        $statement = 'SELECT * FROM Message WHERE id = :id';
        $values = array('id' => $id);
        $message = DatabaseService::get($statement, 'message', $values);
        
        return $message;
    }
    
    public static function thread($thread_id){
        $statement = 'SELECT * FROM Message WHERE thread_id = :thread_id';
        $values = array('thread_id' => $thread_id);
        $messages = DatabaseService::get($statement, 'message', $values);
        
        return $messages;
    }
    
    public function save(){
        $statement = 'INSERT INTO message (user_id, thread_id, content, created, modified) VALUES (:user_id, :thread_id, :content, :created, :modified) RETURNING id';
        $query = DB::connection()->prepare($statement);
        $param = array(
            'user_id' => $this->user_id,
            'thread_id' => $this->thread_id,
            'content' => $this->content,
            'created' => $this->created,
            'modified' => $this->modified
        );
        $query->execute($param);
        
        $row = $query->fetch();
        $this->id = $row['id'];
    }
}