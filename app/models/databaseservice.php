<?php

//To get queries from database with less hassle
class DatabaseService{
    
    
    public static function execute($statement, $values = null){
        $query = DB::connection()->prepare($statement);
        if($values == null){
            $query->execute();
        }else{
            $query->execute($values);
        }
    }
    
    public static function save($statement, $values){
        $query = DB::connection()->prepare($statement);
        $query->execute($values);
        
        return $query->fetch();
    }
    
    public static function get($statement, $type, $values = null, $single = FALSE){
        $rows = self::getQuery($statement, $values);
        $result = self::convert($rows, $type);
        
        if($result && $single){
            return $result[0];
        }
        return $result;
    }
    
    
    private static function getQuery($statement, $values){
        $query = DB::connection()->prepare($statement);
        if($values == null){
            $query->execute();
        }else{
            $query->execute($values);
        }
        $rows = $query->fetchAll();
        
        return $rows;
    }

    
    private static function convert($rows, $type){
        $result = array();
        foreach ($rows as $row){
            $result[] = self::parse($row, $type);
         }
        
        return $result;
    }
        
    private static function parse($row, $type){
        if($type == 'message'){
            return new Message(array(
                'id' => $row['id'],
                'user_id' => $row['user_id'],
                'thread_id' => $row['thread_id'],
                'content' => $row['content'],
                'created' => $row['created'],
                'modified' => $row['modified']
            ));
        }else if($type == 'thread'){
            return new Thread(array(
                'id' => $row['id'],
                'user_id' => $row['user_id'],
                'name' => $row['name'],
                'created' => $row['created'],
                'lastpost' => $row['lastpost']
            ));
        }else if($type == 'forumuser'){
            return new ForumUser(array(
                'id' => $row['id'],
                'userrole' => $row['userrole'],
                'username' => $row['username'],
                'password' => $row['password'],
                'registered' => $row['registered']
            ));
        }else if ($type == 'postamount') {
            return $row['amount'];
        }else{
            echo 'Something went wrong! Wrong type!';
        }
    }
}
