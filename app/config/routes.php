<?php

$router = new Phalcon\Mvc\Router();
$router->removeExtraSlashes(true);

/* For public view*/

$router->add('/', array(
    'controller' => 'site',
    'action' => 'index'
));

$router->add('/site/{name:[a-z\-]+}/{id:[a-z0-9\-]{36}}', array(
    'controller' => 'site',
    'action' => 'view'
));

$router->add('/site/view/{name:[a-z\-]+}', array(
    'controller' => 'site',
    'action' => 'list'
));

$router->add('/admin', array(
    'controller' => 'session',
    'action' => 'login'
));


/*For Control Panel*/


/*$admin = new \Phalcon\Mvc\Router\Group();
$admin->setPrefix('admin')*/

$router->add('/user', array(
    'controller' => 'session',
    'action' => 'login'
));


$router->add('/confirm/{code}/{email}', array(
    'controller' => 'user_control',
    'action' => 'confirmEmail'
));

$router->add('/reset-password/{code}/{email}', array(
    'controller' => 'user_control',
    'action' => 'resetPassword'
));


$router->add('/content/{contentType}', array(
    'controller' => 'content',
    'action' => 'index'
));
$router->add('/content/{contentType}/create', array(
    'controller' => 'content',
    'action' => 'create'
));
$router->add('/content/{contentType}/edit/{id}', array(
    'controller' => 'content',
    'action' => 'edit'
));
$router->add('/content/{contentType}/edit/{id}/{version}', array(
    'controller' => 'content',
    'action' => 'edit'
));
$router->add('/content/{contentType}/editversion/{id}/{version}', array(
    'controller' => 'content',
    'action' => 'editversion'
));
$router->add('/content/{contentType}/delete/{id}', array(
    'controller' => 'content',
    'action' => 'delete'
));
$router->add('/content/{contentType}/upload/{id}', array(
    'controller' => 'content',
    'action' => 'upload'
));
$router->add('/content/{contentType}/versions/{id}', array(
    'controller' => 'content',
    'action' => 'versions'
));
$router->add('/content/{contentType}/listajax', array(
    'controller' => 'content',
    'action' => 'listajax'
));
$router->add('/webform/{machine_name}/list', array(
    'controller' => 'webformsdata',
    'action' => 'list'
));
$router->add('/webform/{machine_name}/show/{id}', array(
    'controller' => 'webformsdata',
    'action' => 'view'
))->setName('webformsdata-show');

return $router;