<?php

class ThreadController extends BaseController{
    
    public static function threadList(){
        $threads = Thread::all();
        View::make('thread/thread_list.html', array('threads' => $threads));
    }
    
    public static function showThread($id){
        $messages = Message::findByThread($id);
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
        
        
        $attributes = array(
            'name' => $params['name'],
            'created' => $time,
            'lastpost' => $time,
            'user_id' => 1             ///PLACEHOLDER
        );
        $thread = new Thread($attributes);
        
        $errors = $thread->errors();
        if(count($errors) == 0){
            $thread->save();
        
            Redirect::to('/thread/'. $thread->id);
        }else{
            View::make('thread/thread_create.html', array('errors' => $errors, 'attributes' => $attributes));
        }
    }
    
    public static function updateThread($id){
        $params = $_POST;
        $oldThread = Thread::find($id);
        
        $attributes = $oldThread->asArray();
        $attributes['id'] = $id;
        $attributes['name'] = $params['name'];
        
        $thread = new Thread($attributes);
        
        $errors = $thread->errors();
        if(count($errors) == 0){
            $thread->update();
        
            Redirect::to('/thread/'. $id);
        }else{
            $thread = Thread::find($id);
            View::make('thread/thread_edit.html', array('errors' => $errors, 'thread' => $thread, 'attributes' => $attributes));
        }
    }
    
    public static function destroyThread($id){
        $thread = Thread::find($id);
        $thread->delete();
        
        Redirect::to('/thread', array('message' => 'Thread deleted.'));
    }
}