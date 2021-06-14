CREATE DATABASE IF NOT EXISTS appstoredb;
Use appstoredb;

CREATE TABLE IF NOT EXISTS Projects  (
  Id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  GroupId int NOT NULL,
  Title nvarchar(255) NOT NULL,
  `Description` nvarchar(4000) NOT NULL,
  DateCreated datetime NOT NULL,
  DateModified datetime NOT NULL,
  FileLocation nvarchar(4000)
);

CREATE TABLE IF NOT EXISTS Users (
  Id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  Username nvarchar(255) NOT NULL,
  GroupId int NOT NULL,
  Email varchar(255) NOT NULL,
  `Password` nvarchar(4000) NOT NULL,
  IsTeacher bit NOT NULL
);

CREATE TABLE IF NOT EXISTS Comments (
  Id int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  ProjectId int NOT NULL,
  UserId int NOT NULL,
  `Text` nvarchar(4000) NOT NULL,
  `Timestamp` datetime NOT NULL,
  FOREIGN KEY (ProjectId) REFERENCES Projects(Id),  
  FOREIGN KEY (UserId) REFERENCES Users(Id)
);

INSERT INTO Users (Username, GroupId,`Password`,IsTeacher)
Values ("Milen",'0','admin','1');
