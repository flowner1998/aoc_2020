<?php

class Passport {

    private $byr;
    private $iyr;
    private $eyr;
    private $hgt;
    private $hcl;
    private $ecl;
    private $pid;
    private $cid;

    function __construct($batch){
        foreach ($batch as $key => $value) {
            $this->$key = $value;
        }
    }


    public function checkIfValid(){
        $isValid = true;

        if(empty($this->byr)){
            $isValid = false;
        }

        if(empty($this->iyr)){
            $isValid = false;
        }

        if(empty($this->eyr)){
            $isValid = false;
        }

        if(empty($this->hgt)){
            $isValid = false;
        }

        if(empty($this->hcl)){
            $isValid = false;
        }

        if(empty($this->ecl)){
            $isValid = false;
        }

        if(empty($this->pid)){
            $isValid = false;
        }

        //Ignore $this->cid


        return $isValid;
    }
}

function ingest(){
    // Open file
    $filepath = "./day_4/input.txt";
    $workfile = fopen($filepath, "r") or die;
    $passports = [];

    // Read contents
    $batch = [];
    $currentLine = 0;
    while(!feof($workfile)){
        $line = fgets($workfile);
        if($line === PHP_EOL){
            $passports[] = new Passport($batch);
            $batch = [];
            continue;
        }else{
            $workline = explode(" ", $line);
            foreach ($workline as $entry) {
                $entry = trim($entry);
                $currentKeyValue = explode(":", $entry);
                if(!$currentKeyValue[0] == ""){
                    $batch[$currentKeyValue[0]] = $currentKeyValue[1];
                }
            }
        }
    }

    fclose($workfile);
    return $passports;
}

$passports = ingest();
$amountValid = 0;
foreach ($passports as $passport) {
    if($passport->checkIfValid()){
        $amountValid++;
    }
}
echo($amountValid);
