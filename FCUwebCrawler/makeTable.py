import json  
import csv  
  
# Read JSON data from file  
with open('111-2.json', 'r', encoding='utf-8') as file:  
    data = json.load(file)  
  
# Extract items from JSON data  
items = data['items']  
  
# Write items to a CSV file  
with open('./table/output.csv', 'w', newline='', encoding='utf-8') as file:  
    writer = csv.writer(file)  
      
    # Write header row  
    header = list(items[0].keys())  
    writer.writerow(header)  
      
    # Write data rows  
    for item in items:  
        row = list(item.values())  
        writer.writerow(row)  
