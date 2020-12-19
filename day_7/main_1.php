<?php

function ingest(){
    // Open file
    $filepath = "./day_7/input.txt";
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

function canContain($allBags, $bag, $search){
    $depth = 0;
    foreach ($bag as $key => $value) {
        if($key === $search){
            return true;
        }else{
            if(canContain($allBags, $allBags[$key], $search)){
                return true;
            }else{
                continue;
            }
        }
    }
    return false;
}

$bags = ingest();

$amount = 0;
foreach ($bags as $key => $value) {
    if(canContain($bags, $bags[$key], "shiny gold")){
        $amount++;
    }
}

print($amount . PHP_EOL);
