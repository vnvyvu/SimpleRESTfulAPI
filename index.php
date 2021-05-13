<?php
    session_start();
    require 'vendor/autoload.php';
 
    use Medoo\Medoo;
    use Psr\Http\Message\ResponseInterface as Response;
    use Psr\Http\Message\ServerRequestInterface as Request;
    use Slim\Factory\AppFactory;

    // Instantiate App
    $app = AppFactory::create();

    // Add error middleware
    $app->addErrorMiddleware(true, true, true);

    // Set the base path of the Slim App
    $basePath = str_replace('/' . basename(__FILE__), '', $_SERVER['SCRIPT_NAME']);
    $app->setBasePath($basePath);

    // Database
    $db=new Medoo([
        'type' => 'mysql',
        'host' => 'yourdbhost',
        'database' => 'yourdbname',
        'username' => 'yourdbusername',
        'password' => 'yourdbpassword',
        'port' => 'yourdbaccessport',
    ]);
    //require routes
    $dao=array(
        "user" => require_once("./route/user.php"),
        "post" => require_once("./route/post.php"),
        "review" => require_once("./route/review.php"),
        "comment" => require_once("./route/comment.php"),
    );
    /*$routes=array_map(function ($i){
        return explode(".", $i)[0];
    }, glob('./route/*.php'));
    foreach($routes as $route) {
        if($route!="") $dao[$route]=require($route);
    }*/
    
    // Add routes
    //login
    //allow parse to JSON
    $app->addBodyParsingMiddleware();
    $app->post('/', function (Request $request, Response $response) use ($db, $dao) {
        $data=$request->getParsedBody();
        //check session
        if(isset($_SESSION[$data["username"]])&&$_SESSION[$data["username"]]["password"]==$data["password"]) $user=$_SESSION[$data["username"]];
        else {
            $user=array_shift($dao["user"]->authenticate($data, $db));
            if($user!=null) $_SESSION[$data["username"]]=$user;
        }
        unset($user["password"]);
        $response->getBody()->write(json_encode($user));
        return $response;
    });
    //register
    $app->post('/user/add', function (Request $request, Response $response) use ($db, $dao) {
        $result=$dao["user"]->add($request->getParsedBody(), $db);
        $response->getBody()->write(json_encode($result));
        return $response;
    });
    //forgot password
    $app->post('/user/forgot/{username}/{email}', function (Request $request, Response $response, $args) use($db, $dao) {
        $response->getBody()->write(
            json_encode($dao["user"]->forgotPassword([
                "username" => $args["username"],
                "email" => $args["email"],
                "password" => $request->getParsedBody()["password"]
            ], $db))
        );
        return $response;
    });
    
    $app->run();
?>