<?php
/* this tow lines
Slim provides its own PSR-7 implementation 
so that it works out of the box. 
However, you are free to replace Slim’s default PSR 7 objects with 
a third-party implementation. Just override the application container’s request 
and response services so they return an instance 
of \Psr\Http\Message\ServerRequestInterface 
and \Psr\Http\Message\ResponseInterface, respectively.
*/ 
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require '../vendor/autoload.php';

$app = new \Slim\App;

// this function called resource or API that uses Psr technique

// First GET resource
$app->get('/hello/{name}', function (Request $request, Response $response) {
    $name = $request->getAttribute('name');
    $response->getBody()->write("Hello word , $name");

    return $response;
});

// Second GET resource
$app->get('/test/{new}', function (Request $request, Response $response) {
    $new = $request->getAttribute('new');
    $response->getBody()->write("This is test : $new");

    return $response;
});

// POST resource
//we can test the POST by Postman
$app->post('/test/demo',function(Request $r1, Response $r2){

$data=$r1->getParsedBody();
$inputdata=[];
$inputdata['name']=filter_var($data['name'],FILTER_SANITIZE_STRING);
$inputdata['phone']=filter_var($data['phone'],FILTER_SANITIZE_STRING);

$r2->getBody()->write("dear: " .$inputdata['name']." your phone number is: " .$inputdata['phone']);

});

// another user of API
$app->get('/testargs/{name}/{phone}', function ($request, $response, $args) {
    $name = $args['name'];
    $phone = $args['phone'];
    $response->getBody()->write("This is a test for args: $name and the phone number is: $phone");

    return $response;
});

// Json Response TEST
$app->get('/jsontest/{FirstName}/{LastNAme}',function($request,$response,$args)
{

$FirstName=$args['FirstName'];
$LastNAme=$args['LastNAme'];
$out=[];
$out['Status']=200;
$out['Message']="Thid is JSON Response Test";
$out['FirstName']=$FirstName;
$out['LastNAme']=$LastNAme;
$response->getBody()->write(json_encode($out));

});

// Put Resource
$app->put('/testput',function($request,$response)
{

$data=$request->getParsedBody();
$username=$data['UserName'];
$password=$data['Password'];
$response->getBody()->write("$username your password is $password");

});

// delete Resource
$app->delete('/testdelete',function($request,$response)
{

$data=$request->getParsedBody();
$username=$data['UserName'];
$password=$data['Password'];
$response->getBody()->write("$username your password is $password With 
	Delete Test Demo");

});

$app->run();