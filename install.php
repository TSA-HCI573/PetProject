<?php
require 'includes/constant/config.inc.php';


//create the table that stores the account information
$go = mysql_query("CREATE TABLE IF NOT EXISTS ".USERS." (
id bigint(20) NOT NULL AUTO_INCREMENT,
md5_id varchar(200) NOT NULL DEFAULT '',
full_name longblob,
user_name varchar(200) NOT NULL DEFAULT '',
usr_email longblob,
user_level tinyint(4) NOT NULL DEFAULT '1',
usr_pwd varchar(220) NOT NULL DEFAULT '',
date date NOT NULL DEFAULT '0000-00-00',
users_ip varchar(200) NOT NULL DEFAULT '',
approved int(1) NOT NULL DEFAULT '0',
activation_code int(10) NOT NULL DEFAULT '0',
ckey varchar(220) NOT NULL DEFAULT '',
ctime varchar(220) NOT NULL DEFAULT '',
num_logins int(11) NOT NULL DEFAULT '0',
last_login timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
PRIMARY KEY (id)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;");

//create the table that stores some text associate with each user
$details = mysql_query("CREATE TABLE IF NOT EXISTS ".USER_DETAILS." (
details_id int(11) unsigned NOT NULL AUTO_INCREMENT,
detail_user_id int(11) DEFAULT NULL,
detail_notes text,
PRIMARY KEY (details_id)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8;");




//manually insert some information about a few users so that we can see it show up on the page once those users log in
$detail_insert = mysql_query("INSERT INTO ".USER_DETAILS." (details_id, detail_user_id, detail_notes)
VALUES
(10,1,'something about user 1 '),
(11,1,'something else about user 1 '),
(12,4,'something about user 4 ');") or die(mysql_error());



if($go && $details && $detail_insert)
{
	echo "Installed tables successfully";
}
else
{
	echo "Unable to install tables";
}