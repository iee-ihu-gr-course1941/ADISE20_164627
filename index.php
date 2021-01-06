<?php
    require_once "lib/board.php";
    require_once "lib/dbconnect.php";
    require_once "lib/game.php";
    require_once "lib/users.php";

    $method = $_SERVER['REQUEST_METHOD'];
    $request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
    $input = json_decode(file_get_contents('php://input'),true);

    switch ($r=array_shift($request)){
        case 'board':
            handle_board($method,$input);
            break;
        case 'login':
            handle_login($method,$input);
            break;
        case 'start':
            handle_start($method,$input);
            break;
        case 'place':
            handle_place($method,$input);
            break;
        case 'logout':
            handle_logout($method,$input);
        default: header("HTTP/1.1 404 Not Found");
            exit;
    }

    function handle_board($method,$input){
        if($method=='GET'){
            get_board();
        }else if ($method=='POST'){
            reset_board();
        }else {
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function handle_login($method, $input){
        if($method=='POST'){
            login($input["username"],$input["password"]);
        }else {
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function handle_start($method, $input){
        update_game_status();
        $status = get_game_status();

        if($method=='POST'){
            if($status=='1'){
                reset_board();
                start_game();
                header("HTTP/1.1 200 OK");
                header('Content-Type: application/json');
                print json_encode(['message'=> 'Game started.']);
            }else {
                header("HTTP/1.1 200 OK");
                header('Content-Type: application/json');
                print json_encode(['errormsg'=> 'The game is not ready to start yet. Need 2 players.']);
            }
        }else {
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function handle_place($method, $input){
        if($method=='POST'){
            place_piece($input["x"],$input["y"]);
        }else {
            header("HTTP/1.1 401 Unauthorized");
        }
    }

    function handle_logout($method,$input){
        if($method=='POST'){
            logout($input["username"]);
        }else {
            header("HTTP/1.1 401 Unauthorized");
        }
    }

?>