CREATE TABLE Movie(
	id INT NOT NULL, -- Each movie must have an id 
	title VARCHAR(100) NOT NULL, -- Each movie must have a title 
	year INT,
	rating VARCHAR(10),
	company VARCHAR(50),
	PRIMARY KEY(id) -- Primary 1: Every movie has a unique id
)
ENGINE = INNODB; 

CREATE TABLE Actor(
	id INT NOT NULL,  -- Each actor must have an id 
	last VARCHAR(20),
	first VARCHAR(20),
	sex VARCHAR(6),
	dob DATE NOT NULL, -- Each actor must have a date of born 
	dod DATE,
	PRIMARY KEY(id) -- Primary key 2: Every actor has a unique id
)
ENGINE = INNODB;

CREATE TABLE Sales(
	mid INT NOT NULL,  -- Each movie must have an id 
	ticketsSold INT,
	totalIncome INT,
	FOREIGN KEY (mid) references Movie(id)  -- Reference 1
)
ENGINE=INNODB;

CREATE TABLE Director(
	id INT NOT NULL,  -- Each director must have an id 
	last VARCHAR(20),
	first VARCHAR(20),
	sex VARCHAR(6),
	dob DATE,
	dod DATE,
	PRIMARY KEY(id)-- Primary key 3: Every director has a unique id 
)
ENGINE = INNODB;

CREATE TABLE MovieGenre(
	mid INT NOT NULL,  -- Each movie must have an id 
	genre VARCHAR(20),
	FOREIGN KEY (mid) references Movie(id)  -- Reference 2
)
ENGINE = INNODB;

CREATE TABLE MovieDirector(
	mid INT NOT NULL, 
	did INT NOT NULL, 
	FOREIGN KEY (mid) references Movie(id),  -- Reference 3
	FOREIGN KEY (did) references Director(id)  -- Reference 4
)
ENGINE = INNODB;

CREATE TABLE MovieActor(
	mid INT NOT NULL,  
	aid INT NOT NULL,
	role VARCHAR(50),
	FOREIGN KEY (mid) references Movie(id),  -- Reference 5
	FOREIGN KEY (aid) references Actor(id)  -- Reference 6
)
ENGINE = INNODB;

CREATE TABLE MovieRating(
	mid INT NOT NULL, 
	imdb INT,
	rot INT,
	CHECK(imdb >= 0 AND imdb <= 100),  -- Check 1: imdb is 0 - 100
	CHECK(rot >= 0 AND rot <= 100)  -- Check 2: rot is 0 - 100
)
ENGINE = INNODB;

CREATE TABLE Review(
	name VARCHAR(20),
	time TIMESTAMP,
	mid INT NOT NULL, 
	rating INT,
	comment VARCHAR(500),
    CHECK(rating >= 0 AND rating <= 5)  -- Check 3: rating is 0 - 5
)
ENGINE = INNODB;

CREATE TABLE MaxPersonID(
	id INT
)
ENGINE = INNODB;

CREATE TABLE MaxMovieID(
	id INT
)
ENGINE = INNODB;