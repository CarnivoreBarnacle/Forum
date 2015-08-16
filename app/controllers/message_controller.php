<?php

class MessageController extends BaseController{
    
    public static function createMessage($id){
        if(BaseController::get_user_logged_in()){
            $thread = Thread::find($id);
            View::make('message/message_create.html', array('thread' => $thread));
        }else{
            Redirect::to('/login', array('errors' => array('Login to create a message.')));
        }
    }
    
    public static function editMessage($id){
        if(BaseController::get_user_logged_in()){
           $message = Message::find($id);
            View::make('message/message_edit.html', array('message' => $message));
        }else{
            Redirect::to('/login', array('errors' => array('Login to edit a message.')));
        }
    }
    
    
    //TODO: make sure adding message updates the lastPost value of thread!!!!
    public static function addMessage($thread_id){
        $params = $_POST;
        $time = date('Y-m-d G:i:s');
        
        $attributes = array(
            'content' => $params['content'],
            'created' => $time,
            'user_id' => $_SESSION['user'],
            'thread_id' => $thread_id
        );
        $message = new Message($attributes);
        
        $errors = $message->errors();
        
        if(count($errors) == 0){
            $message->save();

            Redirect::to('/thread/'. $thread_id);
        }else{
            $thread = Thread::find($thread_id);
            View::make('message/message_create.html', array('thread' => $thread, 'errors' => $errors, 'attributes' => $attributes));
        }
    }
    
    public static function updateMessage($id){
        $params = $_POST;
        $time = date('Y-m-d G:i:s');
        $oldMessage = Message::find($id);
        
        $attributes = $oldMessage->asArray();
        $attributes['id'] = $id;
        $attributes['content'] = $params['content'];
        $attributes['modified'] = $time;
        
        $message = new Message($attributes);
        
        $errors = $message->errors();
        if(count($errors) == 0){
            $message->update();
        
            Redirect::to('/thread/'. $message->thread_id);
        }else{
            $message = Message::find($id);
            View::make('thread/thread_edit.html', array('errors' => $errors, 'message' => $message, 'attributes' => $attributes));
        }
    }
    
    public static function destroyMessage($id){
        $message = Message::find($id);
        $message->delete();
        
        Redirect::to('/thread/' . $message->thread_id, array('message' => 'Message deleted.'));
    }
}