<?php

function ingest(){
     // Open file
     $filepath = "./day_5/input.txt";
     $workfile = fopen($filepath, "r") or die;
     $seats = [];
 
     // Read contents
     while(!feof($workfile)){
        $line = trim(fgets($workfile));
        if(!empty($line)){
            $seats[] = $line;
        }
     }
     return $seats;
}

function defineSeat($seat){
    $row = range(0, 127);
    $column = range(0, 7);
    foreach (str_split($seat) as $i => $char) {
        if($i < 7){
            $row = spacePartition($row, $char);
        }else{
            $column = spacePartition($column, $char);
        }
    }

    return array(
        "row" => $row[0],
        "column" => $column[0],
        "id" => defineId($row[0], $column[0])
    );

}

function spacePartition($workArray, $char){
    if($char === "F" || $char === "L"){
        $workArray = array_slice($workArray, 0, count($workArray)/2);
    }elseif($char === "B" || $char === "R"){
        $workArray = array_slice($workArray, count($workArray)/2, count($workArray));
    }
    return $workArray;
}

function defineId($row, $column){
    return $row * 8 + $column;
}

function writeSeats($realSeats){
    $filepath = "./day_5/outfile.txt";
    $workfile = fopen($filepath, 'w') or die;

    foreach ($realSeats as $i => $seat) {
        fwrite($workfile,
            "Row: {$seat['row']}, Column: {$seat['column']}, Id: {$seat['id']}\n"
        );
    }
    fclose($workfile);
}

function stepSeats($realSeats){
    $lastId = 0;
    foreach ($realSeats as $seat) {
        if($seat['id'] - $lastId > 1){
            print($seat['id'] . PHP_EOL);
        }
        $lastId = $seat['id'];
    }
}

$seats = ingest();
$realSeats = array();
foreach ($seats as $seat) {
    $realSeats[] = defineSeat($seat);
}

$ids = array();
foreach ($realSeats as $i => $seat) {
    $ids[$i] = $seat['id'];
}

array_multisort($ids, SORT_ASC, $realSeats);

writeSeats($realSeats);

stepSeats($realSeats);