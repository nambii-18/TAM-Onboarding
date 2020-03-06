import os
import shutil
from openpyxl import load_workbook
import sys
import mysql.connector as mysql
user = 'root'

dir = '/app/TAM/'+sys.argv[1]+"/"
template_dir = '/app/tam-template/'
files = os.listdir(template_dir)
os.mkdir(dir)
# print(files)
for file in files:
    try:
        shutil.copy(template_dir+file,dir+file)
    except Exception as e:
        print(e)
        if os.path.isdir(template_dir+file):
            shutil.copytree(template_dir+file,dir+file)

with open(dir+'connect-hsbc.php') as f:
  lines = f.readlines()
  lines[2] = lines[2].split('_')[0] + '_' + sys.argv[1] + "');\n"
  lines = ''.join(lines)
  print(lines)

with open(dir+'connect-hsbc.php','w') as f:
  f.write(lines)

'''
db = mysql.connect(
    host = "localhost",
    user = user,
)
db_name = 'tam_'+sys.argv[1]
cursor = db.cursor()
cursor.execute('CREATE DATABASE '+db_name)
cursor.execute('USE '+db_name)

# try:
#   cursor.execute('\
#   CREATE TABLE `cases` (\
#     `PKID` int(11) NOT NULL,\
#     `CASE_NUM` varchar(200) NOT NULL,\
#     `QM_CEC` varchar(15) NOT NULL,\
#     `ENG_CEC` varchar(15) NOT NULL,\
#     `CUSTOMER` text NOT NULL,\
#     `ACCEPT` int(1) DEFAULT NULL,\
#     `DT_SUBMIT` datetime DEFAULT NULL,\
#     `DT_ACCEPT` datetime DEFAULT NULL,\
#     `DIFF_MIN` int(20) DEFAULT NULL,\
#     `SHIFT` varchar(2) DEFAULT NULL,\
#     `TYPE` varchar(20) DEFAULT NULL,\
#     `STATE` varchar(20) NOT NULL\
#   ) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;')

# except:
#   pass

# try:
#   cursor.execute('\
#   CREATE TABLE `c_eng` (\
#     `CEC` varchar(20) NOT NULL,\
#     `GDC` varchar(20) NOT NULL,\
#     `DAYS` int(11) NOT NULL,\
#     `REJECTED` int(8) NOT NULL,\
#     `EA_COUNT` int(5) NOT NULL,\
#     `P3P4_COUNT` int(5) NOT NULL,\
#     `P1P2_COUNT` int(5) NOT NULL,\
#     `S1_TIME` int(10) NOT NULL,\
#     `S2_TIME` int(10) NOT NULL,\
#     `S3_TIME` int(10) NOT NULL,\
#     `NOTICE_COUNT` int(5) NOT NULL,\
#     `DISPATCH` int(5) NOT NULL\
#   ) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;\
#   ')
# except:
#   pass

# try:
#   cursor.execute('\
#   CREATE TABLE `customer` (\
#   `CUSTOMER` varchar(20) NOT NULL,\
#   `ALERTS` varchar(300) DEFAULT NULL\
# ) ENGINE=MyISAM DEFAULT CHARSET=latin1 ROW_FORMAT=DYNAMIC;\
#   ')
# except:
#   pass

try:
  cursor.execute('\
    source /app/mysql-template/scripts/tam-hsbc.sql\
  ')
except:
  pass

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
# # print('Copy started')
# # try:
# #     a = shutil.copytree('/var/www/site/tam-template','/var/www/site/TAM/HSBC',symlinks=True)
# # # time.sleep(5)
# # except Exception as e:
# #     print(e)
# # print('Copy done')

'''
