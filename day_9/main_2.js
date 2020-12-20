// Includes

const fs = require("fs");



function ingest(){
    const filePath = "./day_9/input.txt";
    try {
        const data = fs.readFileSync(filePath, 'utf8');
        const lines = data.split("\r\n");
        numbers = new Array();
        for (let i = 0; i < lines.length; i++) {
            numbers.push(parseInt(lines[i]));
        }
        return numbers;
    } catch (e) {
        console.error("Error: ", e.stack);
    }   
}

function min(set){
    return Math.min(...Array.from(set.values()));
}

function max(set){
    return Math.max(...Array.from(set.values()));
}

function sumArray(a){
    let t = 0;
    for (const v of a) {
        t+=v;
    }
    return t;
}

function solve(numbers, find, l=2){
    if(numbers.length < l){ return 0; }
    for (let i = l; i < numbers.length; i++) {
        const e = numbers.slice(i-l, i);
        if(sumArray(e) === find){
            return Math.min(...e) + Math.max(...e);
        }
    }
    return solve(numbers, find, l+1);
    
}

function main(){
    const numbers = ingest();
    console.log(solve(numbers, 88311122));
}


main()