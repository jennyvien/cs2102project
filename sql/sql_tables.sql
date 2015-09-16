CREATE TABLE Persons
(
email varchar(255) NOT NULL, -- USE THIS AS PRIMARY KEY
firstName varchar(255) NOT NULL,
lastName varchar(255) NOT NULL,
phoneNumber varchar(255) NOT NULL,
Primary Key (email),
password varchar(255) NOT NULL --HASH THE PASSWORDS. FRAMEWORKS SHOULD HANDLE THIS
);

CREATE TABLE Offers
(
id int NOT NULL AUTO INCREMENT,
title varchar(255) NOT NULL,
keywords varchar(255) NOT NULL, --CSV
description varchar (2000) NOT NULL,
city varchar(255) NOT NULL,
state varchar(255) NOT NULL,
country varchar(255) NOT NULL, --DROPDOWN MENU PRECOMPILED?
area_code int NOT NULL,
pos_type varchar(255) NOT NULL, -- part/fulltime
salary int NOT NULL,
Primary Key (id)
)


CREATE TABLE Applications
(
person int FOREIGN KEY REFERENCES Persons,
owner int FOREIGN KEY REFERENCES Persons, -- constraint don't apply to own job
offer int FOREIGN KEY REFERENCES Offers,
application_date date NOT NULL,
resume varchar(255) NOT NULL,
Primary Key (person, offer)
)