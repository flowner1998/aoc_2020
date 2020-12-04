<?php

error_reporting(E_ALL);

/**
 * Handle the input
 * 
 * @return array
 */
function ingest(){
    // Open file
    $filepath = "./day_3/input.txt";
    $workfile = fopen($filepath, "r") or die;

    $map = [];
    // Read contents
    while(!feof($workfile)){
        $line = str_split(trim(fgets($workfile)));
        $map[] = $line;
    }

    fclose($workfile);

    return $map;
}

/**
 * Solve the puzzle.
 * 
 * @link https://adventofcode.com/2020/day/3
 * @param int $right Steps to the right
 * @param int $down Steps down
 * @return int Amount of trees found
 */
function main($right, $down){
    // Setup loop
    $x = 0;
    $y = 0;
    $map = ingest();
    $sizeY = count($map);
    $sizeX = count($map[0]);

    $trees = 0;

    // Start sledding down
    for($x=0,$y=0; $y < $sizeY; $y = $y + $down){

        // Check if the x position needs to reset to the beginning.
        if($x >= $sizeX){
            $x = $x - $sizeX;
        }

        // Check if there is a tree
        if($map[$y][$x] === "#"){
            $map[$y][$x] = "X";
            $trees++;
        }else{
            $map[$y][$x] = "O";
        }

        // Move three positions over
        $x = $x + $right;
    }
    echo($trees);
    echo("\n");
    return $trees;
}

/**
 * Make a visual representation of the path.
 * 
 * @param array $map The current mapping
 * @return void
 */
function write_map($map){
    $filepath = "./day_3/outfile.txt";
    $workfile = fopen($filepath, 'w') or die;

    foreach ($map as $line) {
        foreach ($line as $spot) {
            fwrite($workfile, $spot);
        }
        fwrite($workfile, "\n");
    }
    fclose($workfile);
}

$answer = main(1,1) * main(3,1) * main(5,1) * main(7,1) * main(1,2);
echo("Answer: " . $answer);
echo("\n");