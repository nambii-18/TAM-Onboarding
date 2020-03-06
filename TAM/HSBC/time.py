import mysql.connector
import time


def add():
    conn = mysql.connector.connect(user='root', password='krithu',host='localhost',database='tam-hsbc')
    cursor = conn.cursor()
    t1="UPDATE T_ENG SET S1_TIME=S1_TIME+1 WHERE CEC IN (SELECT CEC FROM ENGINEER WHERE STATE='Available') AND DATES=CURDATE();"
    t2="UPDATE T_ENG SET S2_TIME=S2_TIME+1 WHERE CEC IN (SELECT CEC FROM ENGINEER WHERE STATE='Except Manual P1/P2') AND DATES=CURDATE();"
    t3="UPDATE T_ENG SET S3_TIME=S3_TIME+1 WHERE CEC IN (SELECT CEC FROM ENGINEER WHERE STATE='Unavailable') AND DATES=CURDATE();"
    c1="UPDATE C_ENG SET S1_TIME=S1_TIME+1 WHERE CEC IN (SELECT CEC FROM ENGINEER WHERE STATE='Available');"
    c2="UPDATE C_ENG SET S2_TIME=S2_TIME+1 WHERE CEC IN (SELECT CEC FROM ENGINEER WHERE STATE='Except Manual P1/P2');"
    c3="UPDATE C_ENG SET S3_TIME=S3_TIME+1 WHERE CEC IN (SELECT CEC FROM ENGINEER WHERE STATE='Unavailable');"
    cursor.execute(t1)
    cursor.execute(t2)
    cursor.execute(t3)
    cursor.execute(c1)
    cursor.execute(c2)
    cursor.execute(c3)
    
while True:
    time.sleep(60)
    add()
