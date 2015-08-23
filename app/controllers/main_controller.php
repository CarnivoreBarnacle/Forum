<?php

//Controller primarilly used for testing, pretty much unused in the final app
class MainController extends BaseController{
    
    public static function index(){
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('index.html');
    }

    //Testing
    public static function sandbox(){
        $postedTo1 = ForumUser::findPostedTo(1);
        $postedTo2 = ForumUser::findPostedTo(2);

        Kint::dump($postedTo1);
        Kint::dump($postedTo2);
    }
}
