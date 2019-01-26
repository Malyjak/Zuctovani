CREATE TABLE z_characters(
    id int(11) NOT NULL AUTO_INCREMENT,
    user_id int(11) NOT NULL,
    name varchar(255) NOT NULL,
    lvl int(11),
	xp int(11),
	money int(11),
	race int(11),
	gift text,
	origin text,
	hp int(11),
	mp int(11),
	sp int(11),
	hp_max int(11),
	mp_max int(11),
	sp_max int(11),
	reflexes int(11),
	initiative int(11),
	magic text,
	perks text,
	skills text,
	skills_lvl text,
	inventory text,
	inventory_qty text,
    PRIMARY KEY (id)
);

CREATE TABLE z_groups(
    id int(11) NOT NULL AUTO_INCREMENT,
    group_name varchar(255) NOT NULL,
    permission text,
    PRIMARY KEY (id)
);

INSERT INTO z_groups (group_name, permission)  
VALUES ('Administrator', 'a:38:{i:0;s:10:"createUser";i:1;s:10:"updateUser";i:2;s:8:"viewUser";i:3;s:10:"deleteUser";i:4;s:11:"createGroup";i:5;s:11:"updateGroup";i:6;s:9:"viewGroup";i:7;s:11:"deleteGroup";i:8;s:9:"createNpc";i:9;s:9:"updateNpc";i:10;s:7:"viewNpc";i:11;s:9:"deleteNpc";i:12;s:15:"createCharacter";i:13;s:15:"updateCharacter";i:14;s:13:"viewCharacter";i:15;s:15:"deleteCharacter";i:16;s:14:"createLocation";i:17;s:14:"updateLocation";i:18;s:12:"viewLocation";i:19;s:14:"deleteLocation";i:20;s:10:"createRace";i:21;s:10:"updateRace";i:22;s:8:"viewRace";i:23;s:10:"deleteRace";i:24;s:10:"createItem";i:25;s:10:"updateItem";i:26;s:8:"viewItem";i:27;s:10:"deleteItem";i:28;s:11:"createSkill";i:29;s:11:"updateSkill";i:30;s:9:"viewSkill";i:31;s:11:"deleteSkill";i:32;s:11:"viewReports";i:33;s:15:"createCompanion";i:34;s:15:"updateCompanion";i:35;s:13:"viewCompanion";i:36;s:15:"deleteCompanion";i:37;s:13:"updateSetting";}');

CREATE TABLE z_items(
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    description text,
	quality int(11),
	purpose int(11),
	type int(11),
	availability int(11),
    PRIMARY KEY (id)
);

CREATE TABLE z_locations(
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
	terrain int(11),
	hidden text,
	traps text,
	description text,
    PRIMARY KEY (id)
);

CREATE TABLE z_npcs(
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    lvl int(11),
	money int(11),
	race int(11),
	gift text,
	origin text,
	hp int(11),
	mp int(11),
	sp int(11),
	hp_max int(11),
	mp_max int(11),
	sp_max int(11),
	reflexes int(11),
	initiative int(11),
	magic text,
	skills text,
	skills_lvl text,
	inventory text,
	inventory_qty text,
    PRIMARY KEY (id)
);

CREATE TABLE z_races(
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
    description text,
    PRIMARY KEY (id)
);

CREATE TABLE z_skills(
    id int(11) NOT NULL AUTO_INCREMENT,
    name varchar(255) NOT NULL,
	attribute int(11),
    description text,
    PRIMARY KEY (id)
);

CREATE TABLE z_users(
    id int(11) NOT NULL AUTO_INCREMENT,
    username varchar(255) NOT NULL,
	email varchar(255) NOT NULL,
	password varchar(255) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO z_users (username, email, password)  
VALUES ('admin', 'a@a.a', '$2y$10$sECaRO8HVRSJYJeTskHoXeMZu24piWyhcYLMvLM.kZfdsycsrQbD.');

CREATE TABLE z_user_group(
    id int(11) NOT NULL AUTO_INCREMENT,
    user_id int(11) NOT NULL,
	group_id int(11) NOT NULL,
    PRIMARY KEY (id)
);

INSERT INTO z_user_group (user_id, group_id)  
VALUES ('1', '1');