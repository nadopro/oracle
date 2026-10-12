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
