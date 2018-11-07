select * from users;

select users.fname roles.role 
from users 
inner join users on roles.id = users.roleid; 

insert into users (fname, lname, email, mobile, password, roleid) 
values ('Stephan', 'Hoeksema', 's.hoeksema@windesheimflevoland.nl', '0641612525', 'ietsie!0*0', 1);

update users set fname = 'Stephan Paul' where id = 1

delete from user where id = ?;

insert into roles (role) 
values ('user');

update roles set role = 'Administrator' where id = 1;

delete from roles where id = ?;

insert into recipees (name, description, `step01`, `ingredient01`, `step02`, `ingredient02`, `step03`, `ingredient03`)
values ('Cappocinno Brazilian', 'This dark full flavoured cappocino is perfect after a juicy steak', 'slowly bring the milk to a heat of 60degree celsius, use a whisker to create the perfect layer of foam', 'milk 50ml','Bring the water to a temprature of 85degrees celsius and use your machine to create the coffee', 'water 150ml','distibute the coffee clearly over the compressor for the fine tast.', 'brazillian dark roast 60gr');

insert into posts (name, description) 
values ('great brizillian coffee', 'Strong wings in as grounds chicory galão redeye french press cortado sugar. Mug spoon ristretto foam aroma iced to go redeye extra kopi-luwak. Lungo latte decaffeinated, con panna caffeine half and half organic lungo. Steamed, wings seasonal fair trade rich that con panna organic.');

insert into `comments` (`postid`, `comment`)
values (1, 'Ristretto coffeedoppio, seasonal con panna at a organic. Café au lait, as aromatic acerbic cream extra beans bar whipped so cultivar.');

select postid, name, comment, comments.id from posts
inner join `comments` on comments.`postid` = posts.`id`;

