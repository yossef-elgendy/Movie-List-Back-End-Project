CREATE DATABASE dvd_store;
use dvd_store;

CREATE TABLE city (
cityID INT(11) AUTO_INCREMENT,
cityName VARCHAR(20),
PRIMARY KEY(cityID)
);

CREATE TABLE d_user (
uID INT(11) AUTO_INCREMENT,
firstName VARCHAR(20) NOT NULL,
lastName VARCHAR(20) NOT NULL,
email VARCHAR(20) NOT NULL,
pass VARCHAR(20) NOT NULL,
mobile CHAR(11),
cityID INT(11),
PRIMARY KEY (uID),
FOREIGN KEY (cityID) REFERENCES city(cityID) 
);

CREATE TABLE photo (
pID INT(11) AUTO_INCREMENT,
pName VARCHAR(20) NOT NULL,
pWidth MEDIUMINT(4) NOT NULL,
pHeight MEDIUMINT(4) NOT NULL,
PRIMARY KEY (pID)
);

CREATE TABLE movie (
movieID INT(11) AUTO_INCREMENT,
mName VARCHAR(20) NOT NULL,
mRate TINYINT(2) NOT NULL,
pID INT(11),
uID INT(11),
PRIMARY KEY (movieID),
FOREIGN KEY (pID) REFERENCES photo(pID),
FOREIGN KEY (uID) REFERENCES d_user(uID)
);

use laravel;
DESC teachers ;

INSERT INTO `dvd_store`.`d_user` (`firstName`, `lastName`, `email`, `pass`, `mobile`, `cityID`) VALUES
 ('joe', 'sherif', 'yossef@gmail.com', 'Asd3311062', '01002321604', '1');
 
ALTER TABLE d_user
MODIFY pass VARCHAR(80);
 
 DESC d_user ;

CREATE DATABASE library;
use dvd_store;


use dvd_store;


 ALTER TABLE d_user
 MODIFY email VARCHAR(255) UNIQUE;
 
DESC movie ;

use dvd_store;
SELECT * FROM movie WHERE mName ="divergent";
use dvd_store;

ALTER TABLE movie
MODIFY mRate float(3,1);

SELECT * FROM movie, photo WHERE movie.pID = photo.pID ;

 UPDATE movie SET mName='Joker', mRate=0.5 WHERE movieID=40;
 
 use dvd_store;
 