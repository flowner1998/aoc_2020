def ingest():
    inputList = []
    with open('day_1/input.txt', 'r') as wf:
        for line in wf.readlines():
            inputList.append(int(line))
    return inputList

def solve():
    target = 2020
    inputList = ingest()
    for a in inputList:
        for b in inputList:
            for c in inputList:
                if a + b + c == target:
                    print("answer is {} + {} + {} = {}".format(a, b, c, target))
                    print("{} x {} x {} = {}".format(a, b, c, a*b*c))
                    return


solve()
