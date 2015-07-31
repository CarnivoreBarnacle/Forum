<?php

  $routes->get('/', function() {
      MainController::index();
  });
  
  $routes->get('/threads', function(){
      MainController::threadList();
  });
  
  $routes->get('/threads/example', function(){
      MainController::threadShow();
  });
  
  $routes->get('/threads/example/edit', function(){
      MainController::threadEdit();
  });
  
  $routes->get('/threads/example/post', function(){
      MainController::postCreate();
  });

  $routes->get('/threads/example/post/edit', function(){
      MainController::postEdit();
  });

  $routes->get('/login', function(){
      MainController::login();
  });