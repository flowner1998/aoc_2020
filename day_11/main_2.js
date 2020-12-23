const { count } = require('console');
const fs = require('fs');

class Spot{

    self = "nothing"
    directions = Array(8);
    // Directions consist of
    // 0: North
    // 1: North-East
    // 2: East
    // 3: South-East
    // 4: South
    // 5: Sout-West
    // 6: West
    // 7: North-west

    constructor(self, directions){
        this.self = self;
        this.directions = directions;
    }

    countNearbyOccupied(){
        let count = 0;
        for(let d of this.directions){
            if(d === "#"){
                count++
            }
        }
        return count;
    }

    doRun(){
        if(this.self !== "."){
            const occupied = this.countNearbyOccupied();
            if(occupied === 0){
                if(this.self === "L"){
                    this.self = "#";
                    return true;
                }
            }

            if(occupied > 4){
                if(this.self === "#"){
                    this.self = "L";
                    return true;
                }
            }
        }
        return false;
    }
}

function ingest(){
    const filePath = "./day_11/input.txt";
    try {
        const data = fs.readFileSync(filePath, 'utf8');
        const lines = data.split("\r\n");
        layout = new Array();
        for(const line of lines){
            layout.push(line.split(""));
        }
        return layout;
    } catch (e) {
        console.error("Error: ", e.stack);
    }   
}

function getFirstInDirection(layout, y, x, direction){
    let vX, vY;
    vY = vX = 0;
    switch (direction) {
        case 0:
            // North
            vY = -1;
            break;
        case 1:
            // North-East
            vY = -1; vX = 1
            break;
        case 2:
            // East
            vX = 1;
            break;
        case 3:
            // South-East
            vY = 1; vX = 1;
            break;
        case 4:
            // South
            vY = 1;
            break;
        case 5:
            // South-West
            vY = 1; vX = -1;
            break;
        case 6:
            // West
            vX = -1;
            break
        case 7:
            // North West
            vY = -1; vX = -1;
            break;
        default:
            break;
    }
    if(layout[y + vY]){
        if(layout[y + vY][x + vX]){
            if(layout[y + vY][x + vX] === "."){
                return getFirstInDirection(layout, y+vY, x+vX, direction);
            }else if(layout[y + vY][x + vX] === "L"){
                return "L";
            }else if(layout[y + vY][x + vX] === "#"){
                return "#"
            }else{
                return "nothing";
            }
        }else{
            return "nothing";
        }
    }else{
        return "nothing";
    }
}

function defineLayout(layout){
    let ferry = new Array();
    for (let y = 0; y < layout.length; y++) {
        let row = new Array();
        for (let x = 0; x < layout[y].length; x++) {
            let directions = new Array(8);
            for(let i = 0; i < 8; i++){
                directions[i] = getFirstInDirection(layout, y, x, i);
            }
            let spot = new Spot(
                layout[y][x],
                directions
            );
            row.push(spot);
        }
        ferry.push(row);
    }
    return ferry;
}

function printHistory(history){
    for (const layout of history) {
        let toPrint = "";
        for (const row of layout) {
            for(spot of row){
                toPrint += spot;
            }
            toPrint += "\n";
        }
        console.log(toPrint);
    }
}

function countOccupiedSeats(layout){
    let c = 0;
    for(const row of layout){
        for(const spot of row){
            if(spot === "#"){
                c++;
            }
        }
    }
    return c;
}

function main(){
    let layout = ingest();
    let ferry = defineLayout(layout);

    let history = Array()
    history.push(layout);

    let answer = 0;

    let seatsChanged = 1;
    while(seatsChanged){
        seatsChanged = 0;
        let newLayout = Array();
        for (let y = 0; y < ferry.length; y++) {
            let newRow = Array();
            for (let x = 0; x < ferry[y].length; x++) {
                if(ferry[y][x].doRun()){seatsChanged++;}
                newRow.push(ferry[y][x].self);
            }
            newLayout.push(newRow);
        }
        history.push(newLayout);
        ferry = defineLayout(newLayout);

        if(seatsChanged === 0){
            answer = countOccupiedSeats(newLayout);
        }
    }

    printHistory(history);
    console.log("Answer: ", answer);
}

main()