import re

def ingest():
    inputList = []
    with open('day_2/input.txt', 'r') as wf:
        for line in wf.readlines():
            workLine = line.split()
            allowed = workLine[0].split('-')
            entry = {
                'pos1': int(allowed[0])-1,
                'pos2': int(allowed[1])-1,
                'letter': workLine[1].strip(':'),
                'password': workLine[2]
            }
            inputList.append(entry)
    return inputList




def solve():
    foundValid = 0
    for entry in ingest():
        pos1Found = entry['password'][entry['pos1']] == entry['letter']
        pos2found = entry['password'][entry['pos2']] == entry['letter']
        if((pos1Found or pos2found) and not (pos1Found and pos2found)):
            print(entry['password'])
            foundValid+=1
    return foundValid

print(solve())