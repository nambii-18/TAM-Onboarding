import os
import shutil
from openpyxl import load_workbook
import sys
import mysql.connector as mysql
# import time
user = 'root'

dir = '/app/TAM/'
# template_dir = '/app/tam-template/'
# files = os.listdir(template_dir)
# os.mkdir(dir)

os.system('cd /app && git clone -b master https://github.com/nambii-18/TAM-Onboarding.git')
# os.rename(dir+'/TAM-Onboarding',dir+'/'+sys.argv[1])

shutil.copytree('/app/TAM-Onboarding/tam-template',dir+'/'+sys.argv[1])

dir = dir + '/'  +sys.argv[1] + '/'
# # print(files)
# for file in files:
#     try:
#         shutil.copy(template_dir+file,dir+file)
#     except Exception as e:
#         print(e)
#         if os.path.isdir(template_dir+file):
#             shutil.copytree(template_dir+file,dir+file)

with open(dir+'connect-hsbc.php') as f:
  lines = f.readlines()
  lines[2] = lines[2].split('_')[0] + '_' + sys.argv[1] + "');\n"
  lines = ''.join(lines)
  # print(lines)

with open(dir+'connect-hsbc.php','w') as f:
  f.write(lines)


db = mysql.connect(
    host = "localhost",
    user = user
)

db_name = 'tam_'+sys.argv[1]
cursor = db.cursor()
cursor.execute('CREATE DATABASE '+db_name)
cursor.execute('USE '+db_name+';')


with open('/app/mysql-template/scripts/tam-hsbc.sql') as f:
  lines = f.read().split(';')

# print(lines)
for line in lines:
  cursor.execute(line)

wb = load_workbook('/app/upload/OnboardExcel.xlsx')
sheets = ['Engineers','Reviewers','Customers','Managers or External Access']

sheet = wb['Engineers']
rows = sheet.rows
for i,row in enumerate(rows):
  if i!= 0:
    cec = row[0].value
    gdc = row[1].value
    cursor.execute('INSERT INTO c_eng VALUES ' + "('"+cec+"','"+gdc+"',0,0,0,0,0,0,0,0,0,0)")

sheet = wb['Customers']
rows = sheet.rows
for i,row in enumerate(rows):
  if i!= 0:
    customer = row[0].value
    cursor.execute('INSERT INTO customer VALUES ' + "('"+customer+"','NULL')")


cursor.close()
db.close()