<?php

  class BaseModel{
    // "protected"-attribuutti on käytössä vain luokan ja sen perivien luokkien sisällä
    protected $validators;
    
    public function __construct($attributes = null){
      // Käydään assosiaatiolistan avaimet läpi
      foreach($attributes as $attribute => $value){
        // Jos avaimen niminen attribuutti on olemassa...
        if(property_exists($this, $attribute)){
          // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
          $this->{$attribute} = $value;
        }
      }
    }
    
    //Returns parameter of the object as array, exluding validators and id
    public function asArray(){
        $array = get_object_vars($this);
        unset($array['id']);
        unset($array['validators']);
        
        return $array;
    }
    
    public function errors(){
      // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
      $errors = array();

      foreach($this->validators as $validator){
        // Kutsu validointimetodia tässä ja lisää sen palauttamat virheet errors-taulukkoon
          $errors = array_merge($errors, $this->{$validator}());
      }

      return $errors;
    }
    
    //Validation
    public static function validate_string_min($string, $min){        
        return strlen($string) > $min;
    }
    
    public static function validate_string_max($string, $max){        
        return strlen($string) < $max;
    }
    
    public static function validate_string_not_empty($string){
        return $string != NULL && $string != '';
    }
  }
