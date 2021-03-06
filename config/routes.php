<?php

  function check_logged_in(){
      BaseController::check_logged_in();
  }
  
  $routes->get('/', function() {
      ThreadController::threadList();
  });

  //Thread
  $routes->post('/thread','check_logged_in', function(){
      ThreadController::addThread();
  });
  $routes->post('/thread/:id/edit', function($id){
      BaseController::check_thread_rights($id);
      ThreadController::updateThread($id);
  });
  $routes->post('/thread/:id/destroy', function($id){
      BaseController::check_admin();
      ThreadController::destroyThread($id);
  });
  
  $routes->get('/thread', function(){
      ThreadController::threadList();
  });
    
  $routes->get('/thread/create', 'check_logged_in', function(){
      ThreadController::createThread();
  });

  $routes->get('/thread/:id', function($id){
      ThreadController::showThread($id);
  });
  
  $routes->get('/thread/:id/participants', function($id){
      ThreadController::participants($id);
  });
  
  $routes->get('/thread/:id/edit', function($id){
      BaseController::check_thread_rights($id);
      ThreadController::editThread($id);
  });
  
  
  //Messages
  $routes->get('/thread/:id/message/create', 'check_logged_in', function($id){
      MessageController::createMessage($id);
  });
  
  $routes->get('/message/:id/edit', function($id){
      BaseController::check_message_rights($id);
      MessageController::editMessage($id);
  });
  
  $routes->post('/thread/:thread_id/message','check_logged_in', function($thread_id){
      MessageController::addMessage($thread_id);
  });
  
  $routes->post('/message/:id/update', function($id){
      BaseController::check_message_rights($id);
      MessageController::updateMessage($id);
  });
  
  $routes->post('/message/:id/destroy', function($id){
      BaseController::check_message_rights($id);
      MessageController::destroyMessage($id);
  });

  //Login
  $routes->get('/login', function(){
      LoginController::login();
  });
  
  $routes->post('/login', function(){
      LoginController::handleLogin();
  });
  
  $routes->post('/logout', function(){
      LoginController::logout();
  });
  
  $routes->get('/register', function(){
      LoginController::register();
  });
  
  $routes->post('/register', function(){
      LoginController::createAccount();
  });
  
  //User
  $routes->get('/user/:id', function($id){
      UserController::userPage($id);
  });

  //Sandobx
  $routes->get('/hiekkalaatikko', function(){
      MainController::sandbox(); 
  });