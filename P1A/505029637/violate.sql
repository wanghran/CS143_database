INSERT INTO Movie
	VALUES(1002, "killa kill", 2018, "R", "Warner Sisters"); --It violates the primary key constraint for id
--error 1062 (23000): Duplicate entry '1002' for key 'Primary'

INSERT INTO Actor
	VALUES(1002, "Wang", "Haoran", "Male", 1995-03-23, \N); --It violated the primary key constraint for id
--error 1062 (23000): Duplicate entry '1002' for key 'Primary'

INSERT INTO Director
	VALUES(300, "Wang", "Haoran", "Male", 1995-03-23, \N); --It violates the primary key constraint for id
--error 1062 (23000): Duplicate entry '1002' for key 'Primary'


DELETE FROM Director WHERE id = 1019; --It violates the foreign key constraint for Movie Director
--error 1451 (23000): cannot delete or update a parent row: a foreign key constraint fail

DELETE FROM Movie where id = 598; --It violates the foreign key constraint for Sales
--error 1451 (23000): cannot delete or update a parent row: a foreign key constraint fail

INSERT INTO MovieActor
	VALUES(2001, 100, 'rua'); --It violates the foreign key constraint for aid
--error 1452 (23000): Cannot add or update a child row: a foreign key constraint fails

DELETE FROM Actor WHERE id = 182;--it violates the foreign key constraint for MovieActor aid
--error 1451 (23000): cannot delete or update a parent row: a foreign key constraint fail

INSERT INTO MovieDirector
	VALUES(1002, 1000); --It violates the foreign key constraint for did
--error 1452 (23000): Cannot add or update a child row: a foreign key constraint fails

DELETE FROM Movie where id = 1002; --It violates the foreign key constraint for MoiveDirector mid
--error 1451 (23000): cannot delete or update a parent row: a foreign key constraint fail


INSERT INTO Review
	VALUES('ra', 2009-10-10 20:20:20, 1002, 10 'ww');--it violates the check constraint that rating has to be between 0 and 5

INSERT INTO MovieRating
	VALUES(1002, 200, 200);--It violates the check constraints: first imdb has to be between 0 and 200;
	--second, rot has to be between 0 and 100. 