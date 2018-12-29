DROP TABLE IF EXISTS test.upsert_aggr;

CREATE TABLE test.upsert_aggr
(
  grade      VARCHAR(15),
  field      INT,
  year       INT,
  status     CHAR(5),
  counter    INT,
  r_a        FLOAT,
  r_b        FLOAT,
  created_by INT,
  created_at INT,
  updated_by INT,
  updated_at INT
);

INSERT INTO test.upsert_aggr(grade, field, year, status, counter, r_a, r_b, created_by, updated_by)
VALUES ('MSc', 2011, 95, 'nok', 13, 3.2, 9.9, 1001, 1);
INSERT INTO test.upsert_aggr(grade, field, year, status, counter, r_a, r_b, created_by, updated_by)
VALUES ('MSc', 2012, 95, 'no', 12, 2.3, 1.1, 1001, 101);
