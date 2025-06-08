CREATE TABLE IF NOT EXISTS `Game` (
  `ID` INTEGER AUTO_INCREMENT,
  `name` VARCHAR(255),
  `description` TEXT,
  `defaultMode` ENUM('Coop', 'PVP'),
  PRIMARY KEY (`ID`)
);

CREATE TABLE IF NOT EXISTS `Player` (
  `ID` INTEGER AUTO_INCREMENT,
  `firstName` VARCHAR(255),
  `lastName` VARCHAR(255),
  `nickname` VARCHAR(255),
  PRIMARY KEY (`ID`)
);

CREATE TABLE IF NOT EXISTS `GameMatch` (
  `ID` INTEGER AUTO_INCREMENT,
  `gameID` INTEGER,
  `gameMode` ENUM('Coop', 'PVP'),
  `date` TIMESTAMP,
  `duration` TIME,
  `notes` TEXT,
  PRIMARY KEY (`ID`)
);

CREATE TABLE IF NOT EXISTS `Match_Players` (
  `matchID` INTEGER,
  `playerID` INTEGER,
  `points` INTEGER,
  PRIMARY KEY (`matchID`, `playerID`)
);

ALTER TABLE `Match_Players` ADD FOREIGN KEY (`matchID`) REFERENCES `GameMatch` (`ID`) ON DELETE CASCADE;

ALTER TABLE `Match_Players` ADD FOREIGN KEY (`playerID`) REFERENCES `Player` (`ID`) ON DELETE CASCADE;

ALTER TABLE `GameMatch` ADD FOREIGN KEY (`gameID`) REFERENCES `Game` (`ID`) ON DELETE CASCADE;
