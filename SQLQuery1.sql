CREATE TABLE  Projects  (
  Id int NOT NULL IDENTITY(1,1) PRIMARY KEY,
  Title nvarchar(255) NOT NULL,
  [Description] nvarchar(MAX) NOT NULL,
  DateCreated datetime NOT NULL,
  DateModified datetime NOT NULL,
  FileLocation nvarchar(MAX)
);

CREATE TABLE Users (
  Id int NOT NULL IDENTITY(1,1) PRIMARY KEY,
  Username nvarchar(255) NOT NULL,
  Email varchar(255) NOT NULL,
  [Password] nvarchar(MAX) NOT NULL,
  IsTeacher bit NOT NULL
);

CREATE TABLE ProjectUsers (
  Id int NOT NULL IDENTITY(1,1) PRIMARY KEY,
  ProjectId int NOT NULL FOREIGN KEY REFERENCES Projects(Id),
  UserId int NOT NULL FOREIGN KEY REFERENCES Users(Id),
);

CREATE TABLE Comments (
  Id int NOT NULL IDENTITY(1,1) PRIMARY KEY,
  ProjectId int NOT NULL FOREIGN KEY REFERENCES Projects(Id),
  UserId int NOT NULL FOREIGN KEY REFERENCES Users(Id),
  [Text] nvarchar(MAX) NOT NULL,
  [Timestamp] datetime NOT NULL
);