<?php

class ThreadController extends BaseController{
    
    public static function threadList(){
        $threads = Thread::all();
        View::make('thread/thread_list.html', array('threads' => $threads));
    }
    
    public static function showThread($id){
        $messages = Message::thread($id);
        $thread = Thread::find($id);
        View::make('thread/thread_show.html', array('messages' => $messages, 'thread' => $thread));
    }
    
    public static function createThread(){
        View::make('thread/thread_create.html');
    }
    
    public static function editThread($id){
        $thread = Thread::find($id);
        View::make('thread/thread_edit.html', array('thread' => $thread));
    }
    
    public static function addThread(){
        $params = $_POST;
        $time = date('Y-m-d G:i:s');
        $thread = new Thread(array(
            'name' => $params['name'],
            'created' => $time,
            'lastpost' => $time,
            'user_id' => 1             ///PLACEHOLDER
        ));

        $thread->save();
        
        Redirect::to('/thread/'. $thread->id);
    }
}