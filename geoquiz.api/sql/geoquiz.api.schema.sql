-- Utilisateurs
            CREATE TABLE users (
                                   user_id CHAR(36) PRIMARY KEY NOT NULL,
                                   username VARCHAR(255) NOT NULL,
                                   email VARCHAR(255) NOT NULL,
                                   created_at DATETIME NOT NULL,
                                   total_score INT DEFAULT 0,
                                   total_games_played INT DEFAULT 0
            );

-- Niveaux de Difficulté
CREATE TABLE difficulty_levels (
                                   difficulty_id CHAR(36) PRIMARY KEY NOT NULL,
                                   level_name VARCHAR(255) NOT NULL,
                                   description TEXT,
                                   distance_threshold FLOAT NOT NULL,
                                   time_limit INT NOT NULL
);

-- Parties
CREATE TABLE games (
                       game_id CHAR(36) PRIMARY KEY NOT NULL,
                       user_id CHAR(36) NOT NULL,
                       serie_id CHAR(36) NOT NULL,
                       difficulty_id CHAR(36) NOT NULL,
                       status ENUM('créée', 'en cours', 'terminée') NOT NULL,
                       score INT DEFAULT 0,
                       created_at DATETIME NOT NULL,
                       finished_at DATETIME,
                       FOREIGN KEY (user_id) REFERENCES users(user_id),
                       FOREIGN KEY (difficulty_id) REFERENCES difficulty_levels(difficulty_id)
);