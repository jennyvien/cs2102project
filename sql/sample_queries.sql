--Insert
INSERT into Offers 
max(select id from Offers), --ID
title,
keywords,
description,
city,
state,
country,
area_code,
pos_type,
salary,

--Selection

