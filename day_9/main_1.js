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

function solve(numbers, preambleLength){
    for (let i = preambleLength; i < numbers.length; i++) {
        const currentNumber = numbers[i];
        const preambles = numbers.slice(i-preambleLength,i);
        let preambleSums = new Set();
        for (let preamblesX of preambles) {
            for (let preamblesY of preambles) {
                preambleSums.add(preamblesX + preamblesY);
            }
        }

        if(!preambleSums.has(currentNumber)){
            console.log(currentNumber);
        }
    }
}

function main(){
    const numbers = ingest();
    solve(numbers, 25);
}


main()