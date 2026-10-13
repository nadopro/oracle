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


dice.php 파일을 만들어 줘.
상단에는 주사위 던지는 회수를 6회부터 60000000회까지 선택할 수 있어.
만약에 3이 나오면 
$dice[3] 을 증가시키면 3이 몇회 발생했는지 알수 있어.
실행이 끝나면 $dice[1] ~ $idce[6]까지 몇 회씩 출현했는지 출력해줘.
그 다음에 구글 차트의 꺾은선 그래프로 분포를 그려줘.


$result = query($sql);

if($result)
    print("success");
ELSE
    print("fail");

p. 100

DECLARE
    CURSOR C_SAMPLE IS
        SELECT NAME, SCORE
          FROM SAMPLE
	  ORDER BY NAME ASC;

    V_NAME  SAMPLE.NAME%TYPE;
    V_SCORE SAMPLE.SCORE%TYPE;
BEGIN
    OPEN C_SAMPLE;

    LOOP
        FETCH C_SAMPLE
         INTO V_NAME, V_SCORE;

        EXIT WHEN C_SAMPLE%NOTFOUND;

        DBMS_OUTPUT.PUT_LINE(
            V_NAME || ' : ' || V_SCORE
        );
    END LOOP;

    CLOSE C_SAMPLE;
END;
/


FOR I IN 1..5 LOOP

END LOOP;

다음과 같이 정의된 스키마가 있어.
CREATE TABLE SAMPLE (
    SAMPLE_ID  NUMBER PRIMARY KEY,
    NAME       VARCHAR2(30) NOT NULL,
    DEPARTMENT      VARCHAR2(30),
    SCORE      NUMBER(3),
    REG_DATE   DATE DEFAULT SYSDATE
);

이 스키마를 사용할거니까, 이 스키마를 기억해 놔.

C_MY_CURSOR를 정의하는데,
DEPARTMENT가 컴퓨터공학과 인 사람의 상위 30명을 가져오도록 정의하고,
FOR LOOP를 이용해서 NAME, SCORE를 출력하는 PL/SQL을 만들어줘.

SET SERVEROUTPUT ON;

DECLARE
    CURSOR C_MY_CURSOR IS
        SELECT NAME, SCORE
          FROM SAMPLE
         WHERE DEPARTMENT = '컴퓨터공학과'
         ORDER BY SCORE DESC, SAMPLE_ID ASC
         FETCH FIRST 30 ROWS ONLY;

BEGIN
    FOR V_ROW IN C_MY_CURSOR LOOP

        DBMS_OUTPUT.PUT_LINE(
            V_ROW.NAME || ' : ' || V_ROW.SCORE
        );

    END LOOP;
END;
/


MySQL/MariaDB

LIMIT 10; -- LIMIT 0, 10

LIMIT 5, 10


직전에 만든 커서를 변경하고 싶어.
커서를 사용하지 않고, 
FOR LOOP 안에서 바로 질의를 하고 싶어.
PL/SQL 문장을 만들어 줘.

SET SERVEROUTPUT ON;

BEGIN
    FOR V_ROW IN (
        SELECT NAME, SCORE
          FROM SAMPLE
         WHERE DEPARTMENT = '컴퓨터공학과'
         ORDER BY SCORE DESC, SAMPLE_ID ASC
         FETCH FIRST 30 ROWS ONLY
    )
    LOOP
        DBMS_OUTPUT.PUT_LINE(
            V_ROW.NAME || ' : ' || V_ROW.SCORE
        );
    END LOOP;
END;
/

p. 104

DECLARE
    CURSOR C_SAMPLE(P_SCORE NUMBER) IS
        SELECT NAME, SCORE
          FROM SAMPLE
         WHERE SCORE >= P_SCORE;
BEGIN
    FOR V_ROW IN C_SAMPLE(80) LOOP
        DBMS_OUTPUT.PUT_LINE(
            V_ROW.NAME || ' : ' ||
            V_ROW.SCORE
        );
    END LOOP;
END;
/


search_update.php 파일을 만들고 싶어.
php를 위해 mysql은 다음과 같이 정의했어.
CREATE TABLE SAMPLE (
    SAMPLE_ID  int PRIMARY KEY,
    NAME       char(30) NOT NULL,
    DEPARTMENT     char(30),
    SCORE      int(3),
    REG_DATE   DATE
);

db name : kpc 
db user : kpc
db pass : 1111
이야. 상단에 점수와 학과를 입력받고, "실행"버튼을 누르면
입력된 점수 이상의 데이터를 모두 조회해서 출력해 줘.
또, 각 출력에 해당하는 인물의 학과를 입력된 학과로 변경해 줘.


while(1) -- True
{
    sleep(1); // sleep(1000)
    print("Hello");
}



int main()
{
    if(my_func() <0)
    {

        print("Error");
    }

}


my_func(a, *b, c)
{
    // param check
    error = "";
    if(error)
        print("param error");
        error = "param error";
        goto error_processing;
        
    // error
    error = "param 2 error";
    goto error_processing;
    // erro

    error = "processing error";

    print("%s", b);
    return 1;
error_processing:
    printf("%s Error", error);
    return -1;
}


create table mytable (
    id  varchar2(30) unique ,
    name varchar2(20),
    age number default '10'
);
insert into mytable (id, name) values ('test', '홍길동');
insert into mytable (id, name) values ('test', '홍길동');

insert into mytable (id, name, age) values ('test', '홍길동', '열살');



BAD_REQUEST = 400,
FORBIDDEN = 403,
NOT_FOUND,
METHOD_NOT_ALLOWED,

int main()
{
    start = 3;
    test(start);

    print(start); // 4
}


void test(int &a)
{
    a = a +1;
}


p. 133

CREATE OR REPLACE PROCEDURE P_PRINT_SCORE
(
    P_ID IN SAMPLE.SAMPLE_ID%TYPE
)
IS
    V_NAME  SAMPLE.NAME%TYPE;
    V_SCORE SAMPLE.SCORE%TYPE;
BEGIN
    SELECT NAME, SCORE
      INTO V_NAME, V_SCORE
      FROM SAMPLE
     WHERE SAMPLE_ID = P_ID;

    DBMS_OUTPUT.PUT_LINE(
        V_NAME || ' : ' || V_SCORE
    );
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        DBMS_OUTPUT.PUT_LINE(
            '해당 학생이 없습니다.'
        );
END;
/


p. 136
CREATE OR REPLACE PROCEDURE P_GET_SCORE
(
    P_ID    IN  SAMPLE.SAMPLE_ID%TYPE,
    P_NAME  OUT SAMPLE.NAME%TYPE,
    P_SCORE OUT SAMPLE.SCORE%TYPE
)
IS
BEGIN
    SELECT NAME, SCORE
      INTO P_NAME, P_SCORE
      FROM SAMPLE
     WHERE SAMPLE_ID = P_ID;
END;
/


p. 136B

DECLARE
    V_NAME  SAMPLE.NAME%TYPE;
    V_SCORE SAMPLE.SCORE%TYPE;
BEGIN
    P_GET_SCORE(1, V_NAME, V_SCORE);

    DBMS_OUTPUT.PUT_LINE(
        V_NAME || ' : ' || V_SCORE
    );
END;
/

p. 142

CREATE OR REPLACE FUNCTION F_GET_GRADE
(
    P_SCORE IN NUMBER
)
RETURN VARCHAR2
IS
BEGIN
    IF P_SCORE >= 90 THEN
        RETURN 'A';
    ELSIF P_SCORE >= 80 THEN
        RETURN 'B';
    ELSIF P_SCORE >= 70 THEN
        RETURN 'C';
    ELSIF P_SCORE >= 60 THEN
        RETURN 'D';
    ELSE
        RETURN 'F';
    END IF;
END;
/


p. 143

DECLARE
    V_GRADE VARCHAR2(1);
BEGIN
    V_GRADE := F_GET_GRADE(85);

    DBMS_OUTPUT.PUT_LINE(
        '등급 : ' || V_GRADE
    );
END;
/

p.143B
SELECT NAME,
       SCORE,
       F_GET_GRADE(SCORE) AS GRADE
FROM SAMPLE;


p. 147

CREATE OR REPLACE PACKAGE PKG_SAMPLE
IS
    PROCEDURE P_PRINT_SCORE
    (
        P_ID IN SAMPLE.SAMPLE_ID%TYPE
    );

    FUNCTION F_GET_GRADE
    (
        P_SCORE IN NUMBER
    )
    RETURN VARCHAR2;
END PKG_SAMPLE;
/


p. 148

CREATE OR REPLACE PACKAGE BODY PKG_SAMPLE
IS
    FUNCTION F_GET_GRADE
    (
        P_SCORE IN NUMBER
    )
    RETURN VARCHAR2
    IS
    BEGIN
        IF P_SCORE >= 90 THEN
            RETURN 'A';
        ELSIF P_SCORE >= 80 THEN
            RETURN 'B';
        ELSIF P_SCORE >= 70 THEN
            RETURN 'C';
        ELSIF P_SCORE >= 60 THEN
            RETURN 'D';
        ELSE
            RETURN 'F';
        END IF;
    END F_GET_GRADE;

    PROCEDURE P_PRINT_SCORE
    (
        P_ID IN SAMPLE.SAMPLE_ID%TYPE
    )
    IS
        V_NAME  SAMPLE.NAME%TYPE;
        V_SCORE SAMPLE.SCORE%TYPE;
    BEGIN
        SELECT NAME, SCORE
          INTO V_NAME, V_SCORE
          FROM SAMPLE
         WHERE SAMPLE_ID = P_ID;

        DBMS_OUTPUT.PUT_LINE(
            V_NAME || ' : ' ||
            V_SCORE || '점 / ' ||
            F_GET_GRADE(V_SCORE) || '등급'
        );
    EXCEPTION
        WHEN NO_DATA_FOUND THEN
            DBMS_OUTPUT.PUT_LINE(
                '해당 학생이 없습니다.'
            );
    END P_PRINT_SCORE;
END PKG_SAMPLE;
/


연관배열 : Associative Array
dict[0] = "apple";
dict[1] = "desk";
dict[2] = "test";


dict["apple"] = "사과";
dict["desk"] = "책상";


mytable / a, (k), b, c, d, E
$sql = "select count(*) as mycount from sample";
$sql = select * from mytable
while(data = fetch())
{
    // data[0], data[1],  data[2], data[3], data[4], data[5]

    data["mycount"] , data["k"], data["b"], data["c"], data["d"]
}


p. 156

CREATE TABLE SAMPLE_SCORE_LOG
(
    SAMPLE_ID  NUMBER,
    OLD_SCORE  NUMBER,
    NEW_SCORE  NUMBER,
    CHANGE_DATE DATE
);


p. 157

CREATE OR REPLACE TRIGGER TRG_SAMPLE_SCORE
AFTER UPDATE OF SCORE
ON SAMPLE
FOR EACH ROW
BEGIN
    INSERT INTO SAMPLE_SCORE_LOG
    (
        SAMPLE_ID,
        OLD_SCORE,
        NEW_SCORE,
        CHANGE_DATE
    )
    VALUES
    (
        :OLD.SAMPLE_ID,
        :OLD.SCORE,
        :NEW.SCORE,
        SYSDATE
    );
END;
/
