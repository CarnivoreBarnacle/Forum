<?php


  class MainController extends BaseController{

    public static function index(){
        // make-metodi renderöi app/views-kansiossa sijaitsevia tiedostoja
        View::make('index.html');
    }

    public static function sandbox(){
        $threadmessages = Message::thread(1);
        $messages = Message::all();
        $message = Message::find(1);
        
        $users = ForumUser::all();
        $user = ForumUser::find(1);
        
        $threads = Thread::all();
        $thread = Thread::find(1);
        
        Kint::dump($threadmessages);
        Kint::dump($messages);
        Kint::dump($message);
        
        Kint::dump($users);
        Kint::dump($user);
        
        Kint::dump($threads);
        Kint::dump($thread);
    }
  }
