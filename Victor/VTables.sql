create table Employers(
email varchar(255) NOT NULL,-- USE THIS AS PRIMARY KEY
company varchar(255) NOT NULL, 
first_name varchar(255) NOT NULL,
last_name varchar(255) not null,
phoneNumber varchar(255) NOT NULL,
Primary Key (email),
password varchar(255) NOT NULL --HASH THE PASSWORDS. FRAMEWORKS SHOULD HANDLE THIS
);

create table JobOffers(
jobnum raw(16) default sys_guid(),
Employers varchar(255),
title varchar(255) NOT NULL,
keywords varchar(255) NOT NULL, --CSV
description varchar(2000) NOT NULL,
city varchar(255) NOT NULL,
country varchar(255) NOT NULL, --DROPDOWN MENU PRECOMPILED?
area_code int NOT NULL,
pos_type varchar(255) NOT NULL, -- part/fulltime
salary int NOT NULL,
Primary Key (jobnum, Employers),
foreign key (Employers) references Employers(email)
);

create table Applicants(
email varchar(255) Primary key,
name varchar(255) Not null,
phoneNumber varchar(255) not null,
password varchar(255) not null,
resume varchar(2000) Not null
);

create table Applications(
Applicants varchar(255) not null,
date_applied date not null,
writeup varchar(256) not null,

Employers varchar(255) not null,
JobOffers raw(16) not null,

primary key(applicants,Employers,JobOffers),
foreign key (applicants) references Applicants(email),
foreign key (Employers,JobOffers) references JobOffers(Employers,jobnum)
);