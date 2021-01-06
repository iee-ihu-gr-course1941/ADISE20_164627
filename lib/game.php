<?php

function check_aborted(){
    global $mysqli;

    $sql = "UPDATE game_status SET g_status='2' IF g_last_change<(now()-INTERVAL 1 MINUTE) AND g_status='1'";
    $st = $mysqli->prepare($sql);
	$res = $st->execute();
}

//get game status (0=hasn't started, 1=started, 2=aborted)
function get_game_status(){
    global $mysqli;

    $sql = "SELECT g_status FROM game_status";
    $st2 = $mysqli->prepare($sql);
	$st2->execute();
	$res2 = $st2->get_result();
    $row = $res2->fetch_assoc();

    $status = $row["g_status"];

    return($status);
}

//update game status
function update_game_status(){
    global $mysqli;
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $status = get_game_status();
    $new_status = NULL;
    $new_turn = NULL;

    //check if game is aborted NEEDS FIXING
    /*$sql = "SELECT count(*) AS aborted FROM players WHERE pl_last_action<(now()-INTERVAL 2 MINUTE)";
    $st3 = $mysqli->prepare($sql);
    $st3->execute();
    $res3 = $st3>get_result();
    $aborted = $res3->fetch_assoc()['aborted'];

    //kick players that abort the game and change game status to aborted(2)
    if($aborted>0){
        $sql = "SELECT pl_username AS username FROM players WHERE pl_last_action<(now()-INTERVAL 2 MINUTE)";
        $st4 = $mysqli->prepare($sql);
        $st4->execute();
        $res4 = $st4>get_result();
        $username = $res4->fetch_assoc()['username'];
        if($status['status']==1){
            $new_status = 2;
            header("HTTP/1.1 200 OK");
            header('Content-Type: application/json');
            print json_encode(['errormsg'=> 'The game has been aborted.']);
        }
        //TODO kick_player($username);
    }*/

    //check if game is ready to start
    $sql = "SELECT g_logged_in FROM game_status";
    $st = $mysqli->prepare($sql);
    $st->execute();
    $res5 = $st->get_result();
    $row = $res5->fetch_assoc();

    //if 2 players are ready, start the game
    if($row["g_logged_in"] == '2'){
        $new_status = 1;
        $sql = "UPDATE game_status SET g_status='1' WHERE 1";
        $st6 = $mysqli->prepare($sql);
        $st6->execute();
    }else{
        $new_status = 0;
        echo "new status 0";
        $sql = "UPDATE game_status SET g_status='0' WHERE 1";
        $st6 = $mysqli->prepare($sql);
        $st6->execute();
    }
       
}

//let player with yellow pieces play first
function start_game(){
    global $mysqli;

    $sql = "UPDATE game_status SET g_turn='1'";
    $st = $mysqli->prepare($sql);
    $st->execute();
}

?>