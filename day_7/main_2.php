<?php

function ingest(){
    // Open file
    $filepath = "./day_7/test_input.txt";
    $workfile = fopen($filepath, "r") or die;

    $bags = [];

    // Read contents
    while(!feof($workfile)){
       $line = fgets($workfile);
       if(!empty($line)){
           $tmp = defineBag($line);
           $bags[$tmp[0]] = $tmp[1];
       }
    }
    return $bags;
}

function defineBag(string $line){
    $bag = [];
    $tmp = explode("contain", $line);
    $bagType = trim(str_replace("bags", "", trim($tmp[0])));
    $contains = explode(",", $tmp[1]);
    foreach ($contains as $containBag) {
        $containBag = trim($containBag);
        if($containBag === "no other bags."){
            break;
        }
        $containAmount = intval($containBag);
        $containBag = str_replace(".", "", $containBag);
        $containBag = str_replace("bags", "", $containBag);
        $containBagType = str_replace("bag", "", $containBag);
        $containBagType = substr($containBagType, 2, -1);
        $bag[$containBagType] = $containAmount;
    }

    return [$bagType, $bag];
}

function calculateContent($bags, $currentBag){
    $total = 0;
    if(count($bags[$currentBag]) > 0){
        foreach ($bags[$currentBag] as $bagtype => $amount) {
            
            $total += $amount * calculateContent($bags, $bagtype);
        }
        
    }else{
        return 1;
    }
    return $total + 1;
}

$bags = ingest();




print(calculateContent($bags, "shiny gold") . PHP_EOL);
