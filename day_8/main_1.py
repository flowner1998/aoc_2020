def ingest():
    instructions = list()
    with open("./day_8/input.txt", 'r') as wf:
        for line in wf.readlines():
            line = line.strip()
            splits = line.split()
            instruction = {
                'operation': splits[0],
                'argument': splits[1]
            }
            instructions.append(instruction)
    return instructions

def executeInstruction(instruction, step, accumelator):
    operation = instruction['operation']
    argument = instruction['argument']

    if(operation == 'acc'):
        accumelator = accumelate(argument, accumelator)
        step+=1
        return (step, accumelator)

    elif(operation == 'jmp'):
        step = jump(argument, step)
        return (step, accumelator)

    elif(operation == 'nop'):
        step+=1
        return (step, accumelator)
    else:
        print("ERROR")
        exit()
        
        

def accumelate(argument, accumelator):
    operator = argument[0]
    amount = int(argument[1:])
    if(operator == '+'):
        accumelator += amount
        return accumelator
    elif(operator == '-'):
        accumelator -= amount
        return accumelator
    else:
        print("ERROR")
        exit()

def jump(argument, step):
    operator = argument[0]
    amount = int(argument[1:])
    if(operator == '+'):
        step += amount
        return step
    elif(operator == '-'):
        step -= amount
        return step
    else:
        print("ERROR")
        exit()

def main():
    step = 0
    accumelator = 0
    instructions = ingest()
    alreadyExecuted = set()
    while(step < len(instructions)):
        if(step in alreadyExecuted):
            print("_BootLoop_")
            print("lastStep: " + str(step))
            print("accumelator: " + str(accumelator))
            break
        alreadyExecuted.add(step)
        step, accumelator = executeInstruction(instructions[step], step, accumelator)
    print("_terminated_")

main()