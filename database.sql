CREATE TABLE Positions (
    posID INT AUTO_INCREMENT PRIMARY KEY,
    posName VARCHAR(100) NOT NULL,
    numOfPositions INT NOT NULL,
    posStat ENUM ('open','closed') DEFAULT 'open'
);

CREATE TABLE Candidates (
    candID INT AUTO_INCREMENT PRIMARY KEY,
    candFName VARCHAR(100) NOT NULL,
    candMName VARCHAR(100),
    candLName VARCHAR(100) NOT NULL,
    posID INT,
    candStat ENUM ('active','inactive') DEFAULT 'active', 
    FOREIGN KEY (posID) REFERENCES Positions (posID)
);

CREATE TABLE Voters (
    voterID INT AUTO_INCREMENT PRIMARY KEY,
    voterPass VARCHAR(100) NOT NULL,
    voterFName VARCHAR(100) NOT NULL,
    voterMName VARCHAR(100),
    voterLName VARCHAR(100) NOT NULL,
    voterStat ENUM('active', 'inactive') DEFAULT 'active',
    voted ENUM('y','Y','n','N') DEFAULT 'n'
);

CREATE TABLE Votes (
    posID INT,
    voterID INT,
    candID INT,
    FOREIGN KEY (posID) REFERENCES Positions (posID),
    FOREIGN KEY (voterID) REFERENCES Voters (voterID),
    FOREIGN KEY (candID) REFERENCES Candidates (candID)
);