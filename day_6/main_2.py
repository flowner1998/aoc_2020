from typing import List

class Answer:

    def __init__(self, question: str):
        self.question = question
    
    def get(self) -> str:
        return self.question

    

class Person:

    def __init__(self):
        self.answers: List[Answer] = list()

    def addAnswer(self, answer: Answer) -> None:
        self.answers.append(answer)

class Group:

    def __init__(self):
        self.persons: List[Person] = list()

    def addPerson(self, person: Person) -> None:
        self.persons.append(person)

    def answeredYes(self):
        alreadyAnswered: dict = dict()
        total = 0
        for person in self.persons:
            for answer in person.answers:
                if(answer.get() in alreadyAnswered):
                    alreadyAnswered[answer.get()] += 1
                else:
                    alreadyAnswered[answer.get()] = 1
            
        for k in alreadyAnswered:
            if(alreadyAnswered[k] == len(self.persons)):
                total += 1
        return total




def ingest() -> List[Group]:
    groups: List[Group] = list()
    with open('./day_6/input.txt', 'r') as wf:
        lines = wf.readlines()

        # Loop over lines in file
        group: Group = Group()
        for line in lines:

            # Strip the line from spaces and newlines
            line = line.strip()

            person: Person = Person()
            # Check if the string is not empty otherwise, create new group
            if(line):
                # Loop over the characters in the line
                for char in line:
                    person.addAnswer(Answer(char))
                group.addPerson(person)
            else:
                groups.append(group)
                group = Group()
        groups.append(group)
        group = Group()
    return groups



def main():
    groups: List[Group] = ingest()
    total = 0
    for group in groups:
        total += group.answeredYes()

    print(total)

main()
    
