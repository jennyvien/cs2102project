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
id raw(16) default sys_guid(),
owner varchar(255),
title varchar(255) NOT NULL,
keywords varchar(255) NOT NULL, --CSV
description varchar (2000) NOT NULL,
city varchar(255) NOT NULL,
state varchar(255) NOT NULL,
country varchar(255) NOT NULL, --DROPDOWN MENU PRECOMPILED?
area_code int NOT NULL,
pos_type varchar(255) NOT NULL, -- part/fulltime
salary int NOT NULL,
Primary Key (id),
CONSTRAINT fk_owner
  FOREIGN KEY(owner)
  REFERENCES Persons(email)
);


CREATE TABLE Applications
(
applicant varchar(255),
offer raw(16),
application_date date NOT NULL,
resume varchar(255) NOT NULL,
CONSTRAINT fk_applicant
  FOREIGN KEY (applicant)
  REFERENCES Persons(email),
CONSTRAINT fk_offer
  FOREIGN KEY (offer)
  REFERENCES Offers(id),
Primary Key (applicant, offer)
);