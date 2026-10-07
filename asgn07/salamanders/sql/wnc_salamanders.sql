-- WNC Salamanders: a separate practice database for the asgn07 PDO labs.
-- This file does not change wnc_birds.
-- Import using phpMyAdmin or your established database tool.
-- Intended for a NEW database, or a compatible copy of this lab schema.
-- Re-import adds missing seeds; it does not reset edits or remove extra data.
-- CREATE TABLE IF NOT EXISTS is not a migration for incompatible tables.
-- Names and broad habitat associations: see DATA-NOTES.md for sources.

CREATE DATABASE IF NOT EXISTS wnc_salamanders
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE wnc_salamanders;

CREATE TABLE IF NOT EXISTS salamanders (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    common_name VARCHAR(100) NOT NULL,
    scientific_name VARCHAR(150) NOT NULL,
    description TEXT NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_salamander_scientific_name (scientific_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS habitats (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    habitat_name VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_habitat_name (habitat_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS salamander_habitat_links (
    salamander_id INT UNSIGNED NOT NULL,
    habitat_id INT UNSIGNED NOT NULL,
    PRIMARY KEY (salamander_id, habitat_id),
    KEY idx_salamander_habitat_habitat (habitat_id),
    CONSTRAINT fk_salamander_habitat_salamander
        FOREIGN KEY (salamander_id) REFERENCES salamanders (id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_salamander_habitat_habitat
        FOREIGN KEY (habitat_id) REFERENCES habitats (id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Natural-key uniqueness prevents repeated imports duplicating species.
-- The no-op update deliberately preserves edits to existing seed records.
INSERT INTO salamanders (common_name, scientific_name, description) VALUES
    ('Eastern Newt', 'Notophthalmus viridescens',
     'A salamander with an aquatic adult stage and a terrestrial eft stage.'),
    ('Spotted Salamander', 'Ambystoma maculatum',
     'A spotted woodland salamander that breeds in pools.'),
    ('Blue Ridge Two-lined Salamander', 'Eurycea wilderae',
     'A Blue Ridge salamander associated with streams and nearby terrestrial habitats.'),
    ('Red Salamander', 'Pseudotriton ruber',
     'A red salamander associated with streams, seepages, and moist woodland cover.'),
    ('Eastern Hellbender', 'Cryptobranchus alleganiensis alleganiensis',
     'A large aquatic salamander of flowing streams and rivers.')
ON DUPLICATE KEY UPDATE id = id;

INSERT INTO habitats (habitat_name, description) VALUES
    ('Woodlands', 'Moist forest floor, leaf litter, and cover around wooded waterways.'),
    ('Streams and rivers', 'Flowing freshwater, stream banks, and associated seepages.'),
    ('Ponds and pools', 'Standing freshwater, including temporary breeding pools.')
ON DUPLICATE KEY UPDATE id = id;

-- Associate using names, not assumed AUTO_INCREMENT values.
-- These broad teaching categories include habitat use at different life stages.
-- Each species can use several habitats; each habitat can support several species.
INSERT INTO salamander_habitat_links (salamander_id, habitat_id)
SELECT s.id, h.id
FROM salamanders AS s
CROSS JOIN habitats AS h
WHERE
    (s.scientific_name = 'Notophthalmus viridescens'
     AND h.habitat_name IN ('Woodlands', 'Ponds and pools'))
    OR
    (s.scientific_name = 'Ambystoma maculatum'
     AND h.habitat_name IN ('Woodlands', 'Ponds and pools'))
    OR
    (s.scientific_name = 'Eurycea wilderae'
     AND h.habitat_name IN ('Woodlands', 'Streams and rivers'))
    OR
    (s.scientific_name = 'Pseudotriton ruber'
     AND h.habitat_name IN ('Woodlands', 'Streams and rivers'))
    OR
    (s.scientific_name = 'Cryptobranchus alleganiensis alleganiensis'
     AND h.habitat_name = 'Streams and rivers')
ON DUPLICATE KEY UPDATE
    salamander_id = salamander_habitat_links.salamander_id;

-- Expected with only the supplied records: 5, 3, 9.
SELECT 'salamanders' AS table_name, COUNT(*) AS row_count FROM salamanders
UNION ALL
SELECT 'habitats', COUNT(*) FROM habitats
UNION ALL
SELECT 'salamander_habitat_links', COUNT(*) FROM salamander_habitat_links;
