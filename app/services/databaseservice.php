<?php

//Service to get database queries from database with less hassle and copypaste code
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
    
    public static function get($statement, $values = null, $single = FALSE){
        $rows = self::getQuery($statement, $values);
        
        if($rows && $single){
            return $rows[0];
        }
        return $rows;
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

}
