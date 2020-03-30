#!/usr/bin/env python3
from openpyxl import load_workbook

wb = load_workbook('/app/upload/OnboardExcel.xlsx')
sheets = ['Engineers','Reviewers','Customers','Managers or External Access']

gdc_list = ['Bangalore','RTP','KRK']
sheet = wb['Engineers']
rows = sheet.rows
for i,row in enumerate(rows):
	if i!= 0:
		cec = row[0].value
		gdc = row[1].value
		manager = row[2].value
		if len(cec)>8:
			print('Invalid CEC in Engineer worksheet')
		if gdc not in gdc_list:
			print('GDC values not correct in Engineer worksheet')
		if len(manager) >8:
			print('Invalid CEC in Engineer worksheet')
	# cursor.execute('INSERT INTO c_eng VALUES ' + "('"+cec+"','"+gdc+"',0,0,0,0,0,0,0,0,0,0)")

sheet = wb['Customers']
rows = sheet.rows

for i,row in enumerate(rows):
	if i!= 0:
		customer = row[0].value
	# cursor.execute('INSERT INTO customer VALUES ' + "('"+customer+"','NULL')")

sheet = wb['Managers or External Access']
rows = sheet.rows
for i,row in enumerate(rows):
	if i!=0:
		manager = row[0].value
		gdc = row[1].value
		if gdc not in gdc_list:
			print('GDC values not correct in Managers worksheet')
		if len(manager) >8:
			print('Invalid CEC in Managers worksheet')

sheet = wb['Reviewers']
rows = sheet.rows
for i,row in enumerate(rows):
	if i!=0:
		reviewer = row[0].value
		gdc = row[1].value
		if gdc not in gdc_list:
			print('GDC values not correct in Reviewers worksheet')
		if len(reviewer) >8:
			print('Invalid CEC in Reviewers worksheet')

