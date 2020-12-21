const fs = require('fs');

function ingest(){
    const filePath = "./day_10/input.txt";
    try {
        const data = fs.readFileSync(filePath, 'utf8');
        const lines = data.split("\r\n");
        joltageRatings = new Array();
        for(const line of lines){
            joltageRatings.push(parseInt(line));
        }
        return joltageRatings;
    } catch (e) {
        console.error("Error: ", e.stack);
    }   
}

function checkDifference(difference, differences){
    if(difference === 1){
        differences['one']++;
    }else if(difference === 2){
        differences['two']++;
    }else if(difference === 3){
        differences['three']++;
    }else{
        console.error("Wut? Difference of: ", difference);
    }
    return differences;
}

function solve(joltageRatings){
    let differences = {
        'one': 0,
        'two': 0,
        'three': 0
    }

    for (let i = 0; i < joltageRatings.length -1; i++) {
        let difference = joltageRatings[i+1] - joltageRatings[i];
        differences = checkDifference(difference, differences);
    }
    return differences;
}

function main(){
    let joltageRatings = ingest();
    joltageRatings.push(0); joltageRatings.push(Math.max(...joltageRatings) + 3);
    joltageRatings = joltageRatings.sort((a,b) => a - b);
    let tmp = solve(joltageRatings);
    console.log("answer is: ", tmp['one'] * tmp['three']);
}

main();