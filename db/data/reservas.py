
import pandas as pd
import openpyxl

dataframe1 = pd.read_excel("sheets/agosto.xlsx")

# Define variable to load the dataframe
dataframe = openpyxl.load_workbook("sheets/agosto.xlsx")

# Define variable to read sheet
dataframe1 = dataframe.active

# Iterate the loop to read the cell values
f = open("reservas.txt","w", encoding="utf-8")

# f.write("(")
count = 0
for row in dataframe1.iter_rows(2,5):
    for col in range(0,10):
        if row[col].value:
            f.write(str(row[col].value)+ " ")
    f.write("\n")


f.close()

        
