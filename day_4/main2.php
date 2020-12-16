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

    private function checkByr(){
        if(empty($this->byr)){
            return false;
        }else{
            $byr = intval($this->byr);
            if(!($byr >= 1920 && $byr <= 2002)){
                return false;
            }
        }
        return true;
    }

    private function checkIyr(){
        if(empty($this->iyr)){
            return false;
        }else{
            $iyr = intval($this->iyr);
            if(!($iyr >= 2010 && $iyr <= 2020)){
                return false;
            }
        }
        return true;
    }

    private function checkEyr(){
        if(empty($this->eyr)){
            return false;
        }else{
            $eyr = intval($this->eyr);
            if(!($eyr >= 2020 && $eyr <= 2030)){
                return false;
            }
        }
        return true;
    }

    private function checkHgt(){
        if(empty($this->hgt)){
            return false;
        }else{
            $hgt = $this->hgt;
            if(strpos($hgt, "cm")){
                $val = intval($hgt);
                if(!($val >= 150 && $val <= 193)){
                    return false;
                }
            }else if(strpos($hgt, "in")){
                $val = intval($hgt);
                if(!($val >= 59 && $val <= 76)){
                    return false;
                }
            }else{
                return false;
            }
        }
        return true;
    }

    private function checkHcl(){
        if(empty($this->hcl)){
            return false;
        }else{
            $regexp = "/^#[0-9a-f]{6,6}$/i";
            if(!preg_match($regexp, $this->hcl)){
                return false;
            }
        }
        return true;
    }

    private function checkEcl(){
        if(empty($this->ecl)){
            return false;
        }else{
            $colors = [
                "amb",
                "blu",
                "brn",
                "gry",
                "grn",
                "hzl",
                "oth"
            ];
            if(!(in_array(strtolower($this->ecl), $colors))){
                return false;
            }
        }
        return true;
    }

    private function checkPid(){
        if(empty($this->pid)){
            return false;
        }else{
            $regexp = "/^[0-9]{9,9}$/";
            if(!preg_match($regexp, $this->pid)){
                return false;
            }
        }

        return true;
    }

    public function checkIfValid(){
        return (
            $this->checkByr() &&
            $this->checkIyr() &&
            $this->checkEyr() &&
            $this->checkHgt() &&
            $this->checkHcl() &&
            $this->checkEcl() &&
            $this->checkPid()
        );
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
