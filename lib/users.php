<?php

function login($username, $password){
    global $mysqli;
    $sql = "SELECT * FROM players WHERE pl_username=? AND pl_password=?";
    if($st = $mysqli->prepare($sql)){
		$st->bind_param('ss',$username,$password);
		$st->execute();
		$result=$st->get_result();
		if($row = $result->fetch_array()){
            check_player_count($row[0]);
		}
		else{
            echo "not ok";
            header("HTTP/1.1 401 Unauthorized");
            print json_encode(['errormsg'=>"Player $username not found or password is incorrect."]);
		}
	} else{
			echo "Error1: ".$mysqli->error();
    }
		
	$st->close();
}

//check if another player can join the game
function check_player_count($value) {
    global $mysqli;

    $sql = "SELECT * FROM game_status";

    if($res = $mysqli->query($sql)){
        if($row = $res->fetch_assoc()) {
            if($row["g_logged_in"] == 2) {
                header("HTTP/1.1 200 OK");
                header('Content-Type: application/json');
                print json_encode(['errormsg'=> 'The game has 2 players already.']);
            } else {
                header("HTTP/1.1 200 OK");
                header('Content-Type: application/json');
                ready_player($row["g_logged_in"]);
            }
        }
    }	
    else {
        echo "Error1: ".$mysqli->error();
    }

}

//update the number of players ready to play
function ready_player($value){
    global $mysqli;

    if ($value == 0){
        $sql = "UPDATE game_status SET g_logged_in='1' WHERE 1";
        $st = $mysqli->prepare($sql);
	    $st->execute();
    }else {
        $sql = "UPDATE game_status SET g_logged_in='2' WHERE 1";
        $st = $mysqli->prepare($sql);
	    $st->execute();
    }
}

//get number of ready players
function get_player_count(){
    global $mysqli;

    $sql = "SELECT g_logged_in FROM game_status";
    $st = $mysqli->prepare($sql);
    $st->execute();
    $res = $st->get_result();

    header("HTTP/1.1 200 OK");
    header('Content-type: application/json');
    print json_encode(read_player_count($res), JSON_PRETTY_PRINT);

    //return true;
}

//print number of ready players
function read_player_count($res){
    global $mysqli;

    return($res->fetch_all(MYSQLI_ASSOC));
}

//deactivate player NEEDS FIXING
function logout($username){
    //TEMPORARY FIX TO UPDATE g_logged_in TO 0
    global $mysqli;
    $sql = "UPDATE game_status SET g_logged_in='0'";
    $st = $mysqli->prepare($sql);
    $st->execute();

    get_player_count();


    /*global $mysqli;

    $sql = "SELECT * FROM players WHERE pl_username='$username'";
    $st = $mysqli->prepare($sql);
    $st->execute();
    $res = $st->get_result();

    if($res != NULL){
        $sql = "SELECT g_logged_in FROM game_status";
        $logged_in = $mysqli->query($sql);
        $row = $logged_in->fetch_assoc();

        //$st = $mysqli->prepare($sql);
        //$st->execute();
        //$logged_in = $st->get_result();
        //$row = $logged_in->fetch_assoc();

        if($logged_in=='2'){
            $sql = "UPDATE game_status SET g_logged_in='1'";
            $st = $mysqli->prepare($sql);
            $st->execute();
        }else if($logged_in=='1'){
            $sql = "UPDATE game_status SET g_logged_in='0'";
            $st = $mysqli->prepare($sql);
            $st->execute();
        }else{
            header("HTTP/1.1 200 OK");
			header('Content-Type: application/json');
            print json_encode(['errormsg'=> 'No player is logged in']);
        }
    }else {
        header("HTTP/1.1 200 OK");
		header('Content-Type: application/json');
		print json_encode(['errormsg'=> 'Username not found.']);
    }*/

}

?>