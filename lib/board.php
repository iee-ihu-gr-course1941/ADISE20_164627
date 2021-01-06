<?php 

function get_board()
{
    global $mysqli;

    $sql = "SELECT * FROM board";
    if ($result = $mysqli->query($sql)) {
        header('Content-type: application/json');
		print json_encode(read_board(), JSON_PRETTY_PRINT);
    } else {
        echo "Error1: " . $mysqli->error();
    }

    return true;
}

function reset_board(){
    global $mysqli;

    $sql = "REPLACE INTO board SELECT * FROM board_empty WHERE 1";
    $res = $mysqli->query($sql);

    $sql = "UPDATE game_status SET g_status='0', g_turn=NULL, g_result=NULL";
    $st = $mysqli->prepare($sql);
	$st->execute();
}

function read_board() {
    global $mysqli;
    
	$sql = "SELECT * FROM board";
	$st = $mysqli->prepare($sql);
	$st->execute();
    $res = $st->get_result();
    
	return($res->fetch_all(MYSQLI_ASSOC));
}

//show piece in selected coordinates X,Y
function read_piece($x, $y){
    global $mysqli;

    $sql = "SELECT * FROM BOARD WHERE b_x=? AND b_y=?";
    $st = $mysqli->prepare($sql);
	$st->bind_param('ii',$x,$y);
	$st->execute();
    $res = $st->get_result();

    header('Content-type: application/json');
	print json_encode($res->fetch_all(MYSQLI_ASSOC), JSON_PRETTY_PRINT);
}

function place_piece($x, $y){
    global $mysqli;

    $sql = "SELECT * FROM game_status";
    $st = $mysqli->prepare($sql);
    $st->execute();
    $res = $st->get_result();
    $row = $res->fetch_assoc();

    if($row["g_turn"]=='1'){
        place_yellow_piece($x,$y);
    }else if($row["g_turn"]=='2'){
        place_red_piece($x,$y);
    }

}

//put piece in selected coordinates X,Y for Yellow player
function place_yellow_piece($x,$y){
    global $mysqli;

    //put yellow piece in X,Y
    $sql = "UPDATE board SET b_piece_color='Y' WHERE b_x=? AND b_y=? AND b_blocked='0'";
    $st = $mysqli->prepare($sql);
    $st->bind_param('ii',$x,$y);
    $st->execute();
    $res = $st->get_result();
    
    //let player1(yellow) play if this move was legal
    if($res){
        $sql = "UPDATE game_status SET g_turn='2' WHERE 1";
        $st = $mysqli->prepare($sql);
        $st->execute();
    }

    //make board square on top of X,Y available
    $y++;
    $sql = "UPDATE board SET b_blocked='0' WHERE b_x=? AND b_y=$y";
    $st = $mysqli->prepare($sql);
    $st->bind_param('i',$x);
    $st->execute();

    update_moves();
}

//put piece in selected coordinates X,Y for Red player 
function place_red_piece($x,$y){
    global $mysqli;

    //put red piece in X,Y
    $sql = "UPDATE board SET b_piece_color='R' WHERE b_x=? AND b_y=? AND b_blocked='0'";
    $st = $mysqli->prepare($sql);
    $st->bind_param('ii',$x,$y);
    $st->execute();
    $res = $st->get_result();

    //let player1(yellow) play if this move was legal
    if($res){
        $sql = "UPDATE game_status SET g_turn='1' WHERE 1";
        $st = $mysqli->prepare($sql);
        $st->execute();
    }
    
    //make board square on top of X,Y available
    $y++;
    $sql = "UPDATE board SET b_blocked='0' WHERE b_x=? AND b_y=$y";
    $st = $mysqli->prepare($sql);
    $st->bind_param('i',$x);
    $st->execute();

    update_moves();
}

//put all coordinates of the board in arrays
//board is X:7 by Y:6, X is rows, Y is columns
//row1 is Y=1, each element in the row1 array is [1]=1.1, [2]=2.1, [3]=3.1, etc
function update_moves(){
    global $mysqli;

    $sql = "SELECT * FROM board";

    if($res=$mysqli->query($sql)){
        $row1 = array();
        $row2 = array();
        $row3 = array();
        $row4 = array();
        $row5 = array();
        $row6 = array();
        for($i=1; $i<=6; $i++){
            $column1[$i] = [];
            $column2[$i] = [];
            $column3[$i] = [];
            $column4[$i] = [];
            $column5[$i] = [];
            $column6[$i] = [];
        }
    }
    
    while($row=$res->fetch_assoc()){
        if($row["b_y"]==1){
            $column1[$row["b_x"]] = ["b_x"=>$row["b_x"],"b_y"=>$row["b_y"],"b_piece_color"=>$row["b_piece_color"], "b_blocked"=>$row["b_blocked"]];
        }else if($row["b_y"]==2){
            $column2[$row["b_x"]] = ["b_x"=>$row["b_x"],"b_y"=>$row["b_y"],"b_piece_color"=>$row["b_piece_color"], "b_blocked"=>$row["b_blocked"]];
        }else if($row["b_y"]==3){
            $column3[$row["b_x"]] = ["b_x"=>$row["b_x"],"b_y"=>$row["b_y"],"b_piece_color"=>$row["b_piece_color"], "b_blocked"=>$row["b_blocked"]];
        }else if($row["b_y"]==4){
            $column4[$row["b_x"]] = ["b_x"=>$row["b_x"],"b_y"=>$row["b_y"],"b_piece_color"=>$row["b_piece_color"], "b_blocked"=>$row["b_blocked"]];
        }else if($row["b_y"]==5){
            $column5[$row["b_x"]] = ["b_x"=>$row["b_x"],"b_y"=>$row["b_y"],"b_piece_color"=>$row["b_piece_color"], "b_blocked"=>$row["b_blocked"]];
        }else if($row["b_y"]==6){
            $column6[$row["b_x"]] = ["b_x"=>$row["b_x"],"b_y"=>$row["b_y"],"b_piece_color"=>$row["b_piece_color"], "b_blocked"=>$row["b_blocked"]];
        }
        
    }
    header('Content-Type: application/json');
    print json_encode($column1);

    $deadlock = calculate_deadlock();
    if($deadlock=='0'){
        $sql = "UPDATE game_status SET g_result='0'";
        $st = $mysqli->prepare($sql);
        $st->execute();
        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
        print json_encode(['errormsg'=> 'No available moves left. The game will end in a draw.']);
    }

    $winner = calculate_winner();
}

//TODO
function calculate_winner(){
    //if flag is true then there is a winner
    $flag = false;

    //horizontal check
    //...for loop in each row array, check if there are 4 consecutive same-color pieces
    //for($i=1; $i<=7; $i++){
        
    //}

    //vertical check
    //...for loop with all row arrays, check if there are 4 consecutive same-color pieces where X is the same

    //diagonal check TODO
    //...den exw tin paramikri idea
}

function calculate_deadlock(){
    global $mysqli;

    //if count is 0 then there are no moves left in the game
    $count = 0;

    $sql = "SELECT * FROM board";
    $res = $mysqli->query($sql);
    while($row=$res->fetch_assoc()){
        if($row["b_y"]==1){
            if($column1[$row["b_blocked"]] = '0' AND $column1[$row["b_piece_color"]] != NULL){
                $count++;
            }
        }else if($row["b_y"]==2){
            if($column2[$row["b_blocked"]] = '0' AND $column2[$row["b_piece_color"]] != NULL){
                $count++;
            }
        }else if($row["b_y"]==3){
            if($column3[$row["b_blocked"]] = '0' AND $column3[$row["b_piece_color"]] != NULL){
                $count++;
            }
        }else if($row["b_y"]==4){
            if($column4[$row["b_blocked"]] = '0' AND $column4[$row["b_piece_color"]] != NULL){
                $count++;
            }
        }else if($row["b_y"]==5){
            if($column5[$row["b_blocked"]] = '0' AND $column5[$row["b_piece_color"]] != NULL){
                $count++;
            }
        }else if($row["b_y"]==6){
            if($column6[$row["b_blocked"]] = '0' AND $column6[$row["b_piece_color"]] != NULL){
                $count++;
            }
        }
    }

    return $count;
}



?>