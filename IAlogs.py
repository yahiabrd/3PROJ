import json
from collections import Counter

logFile = "serverExpress/logs.json"

def countElements(elements, tabAttack): 
    count = 0
    for ele in elements: 
        if (ele == tabAttack): 
            count = count + 1
    return count 


def allInformations():
	data = ""
	with open(logFile, "r") as read_file:
		data = json.load(read_file)

	nb = len(data)

	print("{} attacks found".format(nb))

	tabAttack = []
	tabDate = []
	tabAttackedSection = []
	tabIp = []
	elements = ["attackName", "Data Attack", "DoS Attack", "Backdoor Attack", "Database Attack"]
	elements2 = ["data protection", "server protection", "backdoor protection", "database protection"]

	for key in data:
		print("Attaque number : " + key)
		print("=================================")

		for key2 in data[str(key)]:
			print(key2 + " : " + data[str(key)][key2])

		print("=================================")

		tabAttack.append(data[str(key)]['attackName'])
		tabDate.append(data[str(key)]['Date'])
		tabAttackedSection.append(data[str(key)]['section'])
		tabIp.append(data[str(key)]['ip'])

	 
	print("Attacks infos")
	for i in range(len(elements)):
		print('{} has occurred {} times'.format(elements[i], countElements(tabAttack, elements[i])))

	print()

	print("Attacked Sections infos")
	for i in range(len(elements2)):
		print('{} has occurred {} times'.format(elements2[i], countElements(tabAttackedSection, elements2[i])))

	print()

	print("Attacker IP infos")
	print(Counter(tabIp))

	print("Dates infos")
	print(Counter(tabDate))

def search(categorie, research):
	found = False
	data = ""
	with open(logFile, "r") as read_file:
		data = json.load(read_file)

	nb = len(data)

	for key in data:
		if data[key][categorie].lower() == research.lower():
			found = True
			for key2 in data[str(key)]:
				print(data[key][str(key2)])
			print("=======")

	if found == False:
		print("Nothing found..")


def menu():
	displayMenu = True
	continueMenu = ""

	while(displayMenu):
		print("=======================")
		print("3PROJ LOGS - AI BOT")
		print("=======================")
		print("1 - Display all Informations")
		print("2 - Search by Attack Name")
		print("3 - Search by Date")
		print("4 - Search by Section")
		print("5 - Search by IP")
		print()

		choice = int(input("Make your choice : "))
		print()

		if choice == 1:
			allInformations()
		elif choice == 2:
			name = input("Enter the Attack Name : ")
			search("attackName", name)
		elif choice == 3:
			date = input("Enter the Date : ")
			search("Date", date)
		elif choice == 4:
			section = input("Enter the Section : ")
			search("section", section)
		elif choice == 5:
			ip = input("Enter the IP : ")
			search("ip", ip)

		print()
		continueMenu = input("Would you like to continue ? y/n : ")

		if continueMenu == "y" or continueMenu == "Y":
			displayMenu = True
		else:
			displayMenu = False

menu()

