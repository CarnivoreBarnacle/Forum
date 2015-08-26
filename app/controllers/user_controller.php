<?php

class UserController extends BaseController{
    
    public static function userPage($id){
        $user = new ForumUser(ForumUser::find($id));
        $threads = Thread::findByUser($id);
        $messages = Message::findByUser($id);
        
        View::make('user/userpage.html', array('user' => $user, 'threads' => $threads, 'messages' => $messages));
    }
}
