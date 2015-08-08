<?php

//To get queries from database with less hassle
class DatabaseService{
    
    
    public static function get($statement, $type, $values = null){
        $rows = self::getQuery($statement, $values);
        $result = self::convert($rows, $type);
        
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
        if(count($rows) == 1){
            $result = self::parse($rows[0], $type);
        }else{
            $result = array();
            foreach ($rows as $row){
                $result[] = self::parse($row, $type);
            }
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
        }else{
            echo 'Something went wrong! Wrong type.';
        }
    }
}
