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