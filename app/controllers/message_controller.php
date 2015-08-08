<?php

class MessageController extends BaseController{
    
    public static function createMessage($id){
        $thread = Thread::find($id);
        View::make('message/message_create.html', array('thread' => $thread));
    }
    
    public static function addMessage($thread_id){
        $params = $_POST;
        $time = date('Y-m-d G:i:s');
        $message = new Message(array(
            'content' => $params['content'],
            'created' => $time,
            'modified' => $time,
            'user_id' => 1,             ///PLACEHOLDER
            'thread_id' => $thread_id
        ));

        $message->save();
        
        Redirect::to('/thread/'. $thread_id);
    }
}