<?php

class Message extends BaseModel{
    public $id, $user_id, $thread_id, $content, $created, $modified;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
        $this->validators = array('validateContent');
    }
    
    //Gets all messages from database (UNUSED)
    public static function all(){
        $statement = 'SELECT message.*, forumuser.username'
                . ' FROM message'
                . ' LEFT JOIN forumuser'
                . ' ON message.user_id = forumuser.id'
                . ' ORDER BY created ASC';
        $messages = DatabaseService::get($statement);
        
        return $messages;
    }
    
    //Finds message from database by id
    public static function find($id){
        $statement = 'SELECT message.*, forumuser.username'
                . ' FROM message'
                . ' LEFT JOIN forumuser'
                . ' ON message.user_id = forumuser.id'
                . ' WHERE message.id = :id'
                . ' ORDER BY created ASC';
        $values = array('id' => $id);
        $message = DatabaseService::get($statement, $values, TRUE);
        
        return $message;
    }
    
    //Finds messages by thread id
    public static function findByThread($thread_id){
        $statement = 'SELECT message.*, forumuser.username'
                . ' FROM message'
                . ' LEFT JOIN forumuser'
                . ' ON message.user_id = forumuser.id'
                . ' WHERE message.thread_id = :thread_id'
                . ' ORDER BY created ASC';
        $values = array('thread_id' => $thread_id);
        $messages = DatabaseService::get($statement, $values);
        
        return $messages;
    }
    
    //Finds messages by user id
    public static function findByUser($user_id){
        $statement = 'SELECT message.*, forumuser.username'
                . ' FROM message'
                . ' LEFT JOIN forumuser'
                . ' ON message.user_id = forumuser.id'
                . ' WHERE message.user_id = :user_id'
                . ' ORDER BY created ASC';
        $values = array('user_id' => $user_id);
        $messages = DatabaseService::get($statement, $values);
        
        return $messages;
    }
    
    //Saves message
    public function save(){
        $statement = 'INSERT INTO message (user_id, thread_id, content, created) VALUES (:user_id, :thread_id, :content, :created) RETURNING id';
        $values = $this->asArray();
        unset($values['modified']);
        
        $row = DatabaseService::save($statement, $values);
        $this->id = $row['id'];
    }
    
    //Updates message
   public function update(){
        $statement = 'UPDATE message SET content=:content, modified=:modified WHERE id=:id';
        $values = array('id' => $this->id, 'modified'=> $this->modified, 'content' => $this->content);
        
        DatabaseService::save($statement, $values);
    }
    
    //Deletes message
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