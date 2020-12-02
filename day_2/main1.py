import re

def ingest():
    inputList = []
    with open('day_2/input.txt', 'r') as wf:
        for line in wf.readlines():
            workLine = line.split()
            allowed = workLine[0].split('-')
            entry = {
                'minimum': int(allowed[0]),
                'maximum': int(allowed[1]),
                'letter': workLine[1].strip(':'),
                'password': workLine[2]
            }
            inputList.append(entry)
    return inputList




def solve():
    foundValid = 0
    for entry in ingest():
        occurences = entry['password'].count(entry['letter'])
        if entry['minimum'] <= occurences <= entry['maximum']:
            print(entry['password'])
            foundValid+=1
    return foundValid

print(solve())