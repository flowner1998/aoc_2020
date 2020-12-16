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
        "column" => $column[0]
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

function defineId($seat){
    return $seat['row'] * 8 + $seat['column'];
}

$seats = ingest();
$seatIds = array();
foreach ($seats as $seat) {
    $seat = defineSeat($seat);
    $seatIds[] = defineId($seat);
}

print(max($seatIds) . PHP_EOL);

