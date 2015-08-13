<?php


  $routes->get('/', function() {
      ThreadController::threadList();
  });

  //Thread
  $routes->post('/thread', function(){
      ThreadController::addThread();
  });
  $routes->post('/thread/:id/edit', function($id){
      ThreadController::updateThread($id);
  });
  $routes->post('/thread/:id/destroy', function($id){
      ThreadController::destroyThread($id);
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
  
  $routes->get('/message/:id/edit', function($id){
      MessageController::editMessage($id);
  });
  
  $routes->post('/thread/:thread_id/message', function($thread_id){
      MessageController::addMessage($thread_id);
  });
  
  $routes->post('/message/:id/update', function($id){
      MessageController::updateMessage($id);
  });
  
  $routes->post('/message/:id/destroy', function($id){
      MessageController::destroyMessage($id);
  });

  
  $routes->get('/login', function(){
      MainController::login();
  });

  $routes->get('/hiekkalaatikko', function(){
      MainController::sandbox(); 
  });