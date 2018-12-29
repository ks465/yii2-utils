DROP TABLE IF EXISTS test.upsert_data;

CREATE TABLE test.upsert_data
(
  grade      VARCHAR(15),
  field      INT,
  year       INT,
  faculty    INT,
  status     CHAR(5),
  r_a        FLOAT,
  r_b        FLOAT,
  created_by INT,
  created_at INT,
  updated_by INT,
  updated_at INT
);

INSERT INTO test.upsert_data(grade, field, year, faculty, status, r_a, r_b, created_by, updated_by)
VALUES ('phd', 1201, 97, 10011, 'wf_1', 1.0, 1.0, 1, 101);
INSERT INTO test.upsert_data(grade, field, year, faculty, status, r_a, r_b, created_by, updated_by)
VALUES ('phd', 1201, 97, 10012, 'wf_2', 1.0, 1.0, 101, 1001);
INSERT INTO test.upsert_data(grade, field, year, faculty, status, r_a, r_b, created_by, updated_by)
VALUES ('phd', 1201, 97, 10013, 'wf_2', 1.0, 1.0, 1, 1001);
INSERT INTO test.upsert_data(grade, field, year, faculty, status, r_a, r_b, created_by, updated_by)
VALUES ('phd', 1202, 97, 10011, 'wf_1', 1.0, 1.0, 101, 1);
