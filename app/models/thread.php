<?php

class Thread extends BaseModel{
    
    public $id, $user_id, $name, $created, $lastpost;
    
    public function __construct($attributes) {
        parent::__construct($attributes);
    }
    
    public static function all(){
        $statement = 'SELECT * FROM thread';
        $threads = DatabaseService::get($statement, 'thread');
        
        return $threads;
    }
    
    public static function find($id){
        $statement = 'SELECT * FROM thread WHERE id = :id';
        $values = array('id' => $id);
        $thread = DatabaseService::get($statement, 'thread', $values);
        
        return $thread;
    }
    
    public function save(){
        $statement = 'INSERT INTO thread (user_id, name, created, lastpost) VALUES (:user_id, :name, :created, :lastpost) RETURNING id';
        $query = DB::connection()->prepare($statement);
        $param = array(
            'user_id' => $this->user_id,
            'name' => $this->name,
            'created' => $this->created,
            'lastpost' => $this->lastpost
        );
        $query->execute($param);
        
        $row = $query->fetch();
        $this->id = $row['id'];
    }
}
