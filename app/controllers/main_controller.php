<?php

  class MainController extends BaseController{

    public static function index(){
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('index.html');
    }
    
    public static function threadList(){
        View::make('thread_list.html');
    }
    
    public static function threadShow(){
        View::make('thread_show.html');
    }
    
    public static function threadEdit(){
        View::make('thread_edit.html');
    }
    
    public static function postCreate(){
        View::make('post_create.html');
    }
    
    public static function postEdit(){
        View::make('post_edit.html');
    }
    
    public static function login(){
        View::make('login.html');
    }
  }
