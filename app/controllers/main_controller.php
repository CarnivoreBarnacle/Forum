<?php


  class MainController extends BaseController{

    public static function index(){
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('index.html');
    }

    public static function sandbox(){
        $postedTo1 = ForumUser::findPostedTo(1);
        $postedTo2 = ForumUser::findPostedTo(2);
        
        Kint::dump($postedTo1);
        Kint::dump($postedTo2);
    }
  }
