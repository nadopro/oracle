https://github.com/nadopro/oracle

test010-1234-5648010-123a-5647010-1111-1111dsfadsaf
test010-1234-5648010-123a-5647010-1111-1111dsfadsaf
강의용
[가-힣]{2,4}
https://naver.me/GFsgHAGE

https://www.oracle.com/database/free/

https://www.oracle.com/database/sqldeveloper/technologies/download/

설명

CREATE USER KPC
IDENTIFIED BY kpc1111;

GRANT CREATE SESSION,
      CREATE TABLE,
      CREATE VIEW,
      CREATE SEQUENCE,
      CREATE PROCEDURE,
      CREATE TRIGGER
TO KPC;

ALTER USER KPC
QUOTA UNLIMITED ON USERS;



CREATE TABLE SAMPLE (
    SAMPLE_ID  NUMBER PRIMARY KEY,
    NAME       VARCHAR2(30) NOT NULL,
    DEPARTMENT      VARCHAR2(30),
    SCORE      NUMBER(3),
    REG_DATE   DATE DEFAULT SYSDATE
);

INSERT INTO SAMPLE
    (SAMPLE_ID, NAME, DEPARTMENT, SCORE)
VALUES
    (1, '홍길동', '컴퓨터공학과', 90);

INSERT INTO SAMPLE
    (SAMPLE_ID, NAME, DEPARTMENT, SCORE)
VALUES
    (2, '김영희', '문화콘텐츠학과', 85);

INSERT INTO SAMPLE
    (SAMPLE_ID, NAME, DEPARTMENT, SCORE)
VALUES
    (3, '이철수', '컴퓨터공학과', 78);

INSERT INTO SAMPLE
    (SAMPLE_ID, NAME, DEPARTMENT, SCORE)
VALUES
    (4, '박민수', '정보보안학과', 95);

INSERT INTO SAMPLE
    (SAMPLE_ID, NAME, DEPARTMENT, SCORE)
VALUES
    (5, '최수진', '문화콘텐츠학과', 88);

COMMIT;


connect();
for()
    insert()
close();



for()
{
    connect();
    insert();
    close();
}


$id, $pass

$sql = "select * from users where id='$id' and pass='$pass' ";
id = xxxx' or 2>1 -- 
$sql = "select * from users where id='xxxx' or 2>1 -- ' and pass='1234' ";


p. 40

DECLARE
    V_OUTER VARCHAR2(20) := '외부 변수';
BEGIN
    DBMS_OUTPUT.PUT_LINE(V_OUTER);

    DECLARE
        V_INNER VARCHAR2(20) := '내부 변수';
    BEGIN
        DBMS_OUTPUT.PUT_LINE(V_OUTER);
        DBMS_OUTPUT.PUT_LINE(V_INNER);
    END;

    DBMS_OUTPUT.PUT_LINE(V_OUTER);
END;
/


p. 41

DECLARE
    V_PRICE  NUMBER := 10000;
    V_COUNT  NUMBER := 3;
    V_TOTAL  NUMBER;
BEGIN
    V_TOTAL := V_PRICE * V_COUNT;

    DBMS_OUTPUT.PUT_LINE(
        '합계: ' || V_TOTAL
    );
END;
/

Neo4j


Naming Rule

Snake Expression
get_user_name

Camel Expression
getUserName

GET_USER_NAME


int i_score, i_age;
dobule d_score, d_age;

netcraft webserver survey


p. 58

DECLARE
    V_NAME  SAMPLE.NAME%TYPE;
    V_SCORE SAMPLE.SCORE%TYPE;
BEGIN
    SELECT NAME, SCORE
      INTO V_NAME, V_SCORE
      FROM SAMPLE
     WHERE SAMPLE_ID = 1;

    DBMS_OUTPUT.PUT_LINE(V_NAME || ': ' || V_SCORE);
END;
/


p. 59

DECLARE
    V_SAMPLE SAMPLE%ROWTYPE;
BEGIN
    SELECT *
      INTO V_SAMPLE
      FROM SAMPLE
     WHERE SAMPLE_ID = 1;

    DBMS_OUTPUT.PUT_LINE(V_SAMPLE.NAME);
    DBMS_OUTPUT.PUT_LINE(V_SAMPLE.SCORE);
END;
/



1.2.3.4
0001 0010  0011 0100
1111 1111  1111 0000
====================
0001 0010  0011 0000 = 1.2.3.0


for(i = 1; i < 10; i++)
{

}

sum = 0;
i = 10;
while(i > 0)
{
    sum = sum + i;
    i--;
}


p. 77

DECLARE
    V_NUM NUMBER := 1;
BEGIN
    LOOP
        DBMS_OUTPUT.PUT_LINE(V_NUM);
        V_NUM := V_NUM + 1;

        EXIT WHEN V_NUM > 5;
    END LOOP;
END;
/


p. 80

DECLARE
    V_NUM NUMBER := 1;
BEGIN
    WHILE V_NUM <= 5 LOOP
        DBMS_OUTPUT.PUT_LINE(V_NUM);
        V_NUM := V_NUM + 1;
    END LOOP;
END;
/


p. 82

DECLARE
    V_NUM NUMBER := 1;
BEGIN
    FOR V_NUM IN 1..15 BY 2 LOOP
        DBMS_OUTPUT.PUT_LINE(V_NUM);
    END LOOP;
END;
/




for(100000)
    print(i);

for(1억)
    print(i);




a();
print("A");
b();
print("B");
c();
print("C");
fflush(stdout); // out.flush();
d();
print("D");
e();
print("E");

A 
B 


p. 90

BEGIN
    UPDATE SAMPLE
       SET SCORE = SCORE + 5
     WHERE DEPARTMENT = '컴퓨터공학과';

    DBMS_OUTPUT.PUT_LINE(
        SQL%ROWCOUNT || '건 수정되었습니다.'
    );
END;
/


insert into sample (sample_id, name, department, score) 
    values (10, '가가가', '컴퓨터공학과', 90), ( );


p. 92

BEGIN
    UPDATE SAMPLE
       SET SCORE = SCORE + 5
     WHERE DEPARTMENT = '컴퓨터공학과';

    IF SQL%FOUND THEN
        DBMS_OUTPUT.PUT_LINE(
            SQL%ROWCOUNT || '건 수정'
        );
    ELSE
        DBMS_OUTPUT.PUT_LINE('수정 대상 없음');
    END IF;
END;
/


p. 97

SET SERVEROUTPUT ON;

DECLARE
    CURSOR C_SAMPLE IS
        SELECT NAME, SCORE FROM SAMPLE
        ORDER BY NAME ASC;

    V_NAME  SAMPLE.NAME%TYPE;
    V_SCORE SAMPLE.SCORE%TYPE;
BEGIN
    OPEN C_SAMPLE;
    FETCH C_SAMPLE INTO V_NAME, V_SCORE;

    IF C_SAMPLE%FOUND THEN
        	DBMS_OUTPUT.PUT_LINE(
		V_NAME || ' : ' || V_SCORE
	);
    END IF;

    CLOSE C_SAMPLE;
END;
/