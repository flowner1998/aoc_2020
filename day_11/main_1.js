const { count } = require('console');
const fs = require('fs');

class Spot{

    self = "nothing"
    north = "nothing";
    east = "nothing";
    south = "nothing";
    west = "nothing"
    northeast = "nothing";
    southeast = "nothing";
    southwest = "nothing";
    northwest = "nothing";
    constructor(self, n, e, s, w, ne, se, sw, nw){
        this.self = self;
        this.north = n;
        this.east = e;
        this.south = s;
        this.west = w;
        this.northeast = ne;
        this.southeast = se;
        this.southwest = sw;
        this.northwest = nw;
        
    }

    countNearbyOccupied(){
        let count = 0;
        if(this.north === "#"){count++;}
        if(this.east === "#"){count++;}
        if(this.south === "#"){count++}
        if(this.west === "#"){count++}
        if(this.northeast=== "#"){count++}
        if(this.southeast === "#"){count++}
        if(this.southwest === "#"){count++}
        if(this.northwest === "#"){count++}
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

            if(occupied > 3){
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

function defineLayout(layout){
    let ferry = new Array;
    for (let y = 0; y < layout.length; y++) {
        let row = new Array();
        for (let x = 0; x < layout[y].length; x++) {
            let n, e, s, w, ne, se, sw, nw;
            if(layout[y-1]){
                n = layout[y-1][x];
                if(layout[y-1][x-1]){ nw = layout[y-1][x-1] } else { nw = "nothing" }
                if(layout[y-1][x+1]){ ne = layout[y-1][x+1] } else { ne = "nothing" }
            }else{
                n = ne = nw = "nothing";
            }
            if(layout[y][x+1]){
                e = layout[y][x+1];
            }else{
                e = "nothing";
            }
            if(layout[y+1]){
                s = layout[y+1][x];
                if(layout[y+1][x-1]){ sw = layout[y+1][x-1] } else { sw = "nothing" }
                if(layout[y+1][x+1]){ se = layout[y+1][x+1] } else { se = "nothing" }
            }else{
                s = se = sw = "nothing";
            }
            if(layout[y][x-1]){
                w = layout[y][x-1];
            }else{
                w = "nothing";
            }

            let spot = new Spot(
                layout[y][x],
                n, e, s, w, ne, se, sw, nw
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