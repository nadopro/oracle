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