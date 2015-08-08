<?php


  $routes->get('/', function() {
      ThreadController::threadList();
  });

  //Thread
  $routes->post('/thread', function(){
      ThreadController::addThread();
  });
  
  $routes->get('/thread', function(){
      ThreadController::threadList();
  });
    
  $routes->get('/thread/create', function(){
      ThreadController::createThread();
  });

  $routes->get('/thread/:id', function($id){
      ThreadController::showThread($id);
  });
  
  $routes->get('/thread/:id/edit', function($id){
      ThreadController::editThread($id);
  });
  
  
  //Messages
  $routes->get('/thread/:id/message/create', function($id){
      MessageController::createMessage($id);
  });
  
  $routes->post('/thread/:thread_id/message', function($thread_id){
      MessageController::addMessage($thread_id);
  });

  
  $routes->get('/login', function(){
      MainController::login();
  });

  $routes->get('/hiekkalaatikko', function(){
      MainController::sandbox(); 
  });