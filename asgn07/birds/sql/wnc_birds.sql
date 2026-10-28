-- asgn07: WNC Birds - related tables and PDO foundations
-- MySQL / MariaDB; InnoDB; utf8mb4.
--
-- SAFE ADDITIVE SETUP for the original one-table WNC Birds starter.
-- No DROP DATABASE, DROP TABLE, TRUNCATE, or disabled foreign-key checks.
-- Existing species records and existing seed records are not overwritten.
-- The no-op ON DUPLICATE KEY UPDATE clauses let seed data be re-imported
-- without duplicating records identified by their unique natural keys.
-- This is a setup script, not a general-purpose migration for arbitrary
-- pre-existing tables. CREATE TABLE IF NOT EXISTS does not repair a schema.
-- Back up any existing database before importing schema changes.
--
-- Fresh/original-only database after import:
--   birds = 8; bird_images = 17; bird_image_links = 18.
-- Existing student-added records may make these totals larger.
--
-- Images are AI-generated teaching illustrations, not photographs.
-- All actual JPEG files live in public/images/birds/.
-- SQL stores metadata only; no BLOBs and no encoded image bytes.

CREATE DATABASE IF NOT EXISTS wnc_birds
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE wnc_birds;
SET NAMES utf8mb4;

-- 1. One row per bird SPECIES, not per individual animal.
CREATE TABLE IF NOT EXISTS birds (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    common_name VARCHAR(100) NOT NULL,
    scientific_name VARCHAR(150) NOT NULL,
    family_name VARCHAR(100) NOT NULL,
    primary_habitat VARCHAR(180) NOT NULL,
    seasonal_status VARCHAR(100) NOT NULL,
    description TEXT NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_scientific_name (scientific_name),
    INDEX idx_common_name (common_name),
    INDEX idx_seasonal_status (seasonal_status)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 2. One row per physical image file. A filename is stored only once.
-- There is deliberately no bird_id here: one file can show multiple species.
CREATE TABLE IF NOT EXISTS bird_images (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    file_name VARCHAR(190) NOT NULL,
    caption VARCHAR(255) NOT NULL,
    alt_text VARCHAR(255) NOT NULL,
    image_kind VARCHAR(30) NOT NULL DEFAULT 'ai_illustration',
    credit VARCHAR(255) NOT NULL,
    source_url VARCHAR(500) NULL,
    width_px INT UNSIGNED NOT NULL,
    height_px INT UNSIGNED NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_bird_images_file_name (file_name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 3. Junction table: this is what makes the relationship MANY-TO-MANY.
-- One species can have many files; one file can relate to many species.
-- Sex describes the depicted individual(s) of THIS species in THIS image.
-- 'both' supports a male/female pair; 'unknown' avoids invented certainty.
CREATE TABLE IF NOT EXISTS bird_image_links (
    bird_id INT UNSIGNED NOT NULL,
    image_id INT UNSIGNED NOT NULL,
    sex ENUM('male', 'female', 'both', 'unknown') NOT NULL DEFAULT 'unknown',
    sort_order SMALLINT UNSIGNED NOT NULL DEFAULT 1,
    PRIMARY KEY (bird_id, image_id),
    KEY idx_bird_image_links_image_id (image_id),
    CONSTRAINT fk_bird_image_links_bird
        FOREIGN KEY (bird_id) REFERENCES birds (id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,
    CONSTRAINT fk_bird_image_links_image
        FOREIGN KEY (image_id) REFERENCES bird_images (id)
        ON UPDATE CASCADE
        ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Deleting a bird or an image removes only its matching junction rows.
-- It does NOT delete the other parent records, nor any filesystem files.
-- Primary-key IDs should normally remain stable. ON UPDATE CASCADE is
-- present as requested, but renumbering IDs is not normal application work.

-- DDL above is separate from this seed-data transaction.
START TRANSACTION;

-- Preserve existing species data, including any edits made in earlier work.
INSERT INTO birds
    (common_name, scientific_name, family_name, primary_habitat, seasonal_status, description)
VALUES
    ('Eastern Towhee', 'Pipilo erythrophthalmus', 'Passerellidae', 'Brushy woodland edges and thickets', 'Year-round', 'A large sparrow often noticed while scratching through leaf litter in dense cover.'),
    ('American Robin', 'Turdus migratorius', 'Turdidae', 'Lawns, open woods, and woodland edges', 'Year-round', 'A familiar thrush often seen feeding on lawns, forest edges, and other open ground.'),
    ('Blue Jay', 'Cyanocitta cristata', 'Corvidae', 'Woodlands, forest edges, and neighborhoods', 'Year-round', 'A bold blue-and-white member of the crow family with a wide range of calls.'),
    ('Carolina Wren', 'Thryothorus ludovicianus', 'Troglodytidae', 'Brushy yards, thickets, and wooded areas', 'Year-round', 'A small warm-brown wren known for a loud voice that seems much larger than the bird.'),
    ('Northern Cardinal', 'Cardinalis cardinalis', 'Cardinalidae', 'Thickets, woodland edges, and backyards', 'Year-round', 'A common backyard bird; adult males are bright red while females are mostly warm brown with red accents.'),
    ('Red-bellied Woodpecker', 'Melanerpes carolinus', 'Picidae', 'Mature woods, parks, and wooded neighborhoods', 'Year-round', 'A medium-sized woodpecker commonly found around mature trees and wooded neighborhoods.'),
    ('Dark-eyed Junco', 'Junco hyemalis', 'Passerellidae', 'Woodland edges, brushy yards, and mountain forests', 'Winter visitor', 'A small sparrow that becomes especially noticeable in the region during the colder months.'),
    ('Rose-breasted Grosbeak', 'Pheucticus ludovicianus', 'Cardinalidae', 'Deciduous forests and wooded edges', 'Spring/fall migrant and summer resident', 'A stout-billed songbird seen during migration and breeding season in suitable mountain habitat.')
ON DUPLICATE KEY UPDATE scientific_name = scientific_name;

-- Local file metadata. Source URLs are NULL because these are generated assets.
INSERT INTO bird_images
    (file_name, caption, alt_text, image_kind, credit, source_url, width_px, height_px)
VALUES
    ('eastern_towhee_male.jpg', 'Eastern Towhee: male teaching illustration', 'AI-generated illustration intended to represent a male Eastern Towhee.', 'ai_illustration', 'AI-generated for this teaching package; not a photograph.', NULL, 594, 296),
    ('eastern_towhee_female.jpg', 'Eastern Towhee: female teaching illustration', 'AI-generated illustration intended to represent a female Eastern Towhee.', 'ai_illustration', 'AI-generated for this teaching package; not a photograph.', NULL, 593, 296),
    ('american_robin_male.jpg', 'American Robin: male teaching illustration', 'AI-generated illustration intended to represent a male American Robin.', 'ai_illustration', 'AI-generated for this teaching package; not a photograph.', NULL, 594, 325),
    ('american_robin_female.jpg', 'American Robin: female teaching illustration', 'AI-generated illustration intended to represent a female American Robin.', 'ai_illustration', 'AI-generated for this teaching package; not a photograph.', NULL, 593, 325),
    ('blue_jay_male.jpg', 'Blue Jay: male teaching illustration', 'AI-generated illustration intended to represent a male Blue Jay.', 'ai_illustration', 'AI-generated for this teaching package; not a photograph.', NULL, 594, 324),
    ('blue_jay_female.jpg', 'Blue Jay: female teaching illustration', 'AI-generated illustration intended to represent a female Blue Jay.', 'ai_illustration', 'AI-generated for this teaching package; not a photograph.', NULL, 593, 324),
    ('carolina_wren_male.jpg', 'Carolina Wren: male teaching illustration', 'AI-generated illustration intended to represent a male Carolina Wren.', 'ai_illustration', 'AI-generated for this teaching package; not a photograph.', NULL, 594, 343),
    ('carolina_wren_female.jpg', 'Carolina Wren: female teaching illustration', 'AI-generated illustration intended to represent a female Carolina Wren.', 'ai_illustration', 'AI-generated for this teaching package; not a photograph.', NULL, 593, 343),
    ('northern_cardinal_male.jpg', 'Northern Cardinal: male teaching illustration', 'AI-generated illustration intended to represent a male Northern Cardinal.', 'ai_illustration', 'AI-generated for this teaching package; not a photograph.', NULL, 506, 378),
    ('northern_cardinal_female.jpg', 'Northern Cardinal: female teaching illustration', 'AI-generated illustration intended to represent a female Northern Cardinal.', 'ai_illustration', 'AI-generated for this teaching package; not a photograph.', NULL, 506, 378),
    ('red_bellied_woodpecker_male.jpg', 'Red-bellied Woodpecker: male teaching illustration', 'AI-generated illustration intended to represent a male Red-bellied Woodpecker.', 'ai_illustration', 'AI-generated for this teaching package; not a photograph.', NULL, 506, 384),
    ('red_bellied_woodpecker_female.jpg', 'Red-bellied Woodpecker: female teaching illustration', 'AI-generated illustration intended to represent a female Red-bellied Woodpecker.', 'ai_illustration', 'AI-generated for this teaching package; not a photograph.', NULL, 506, 384),
    ('dark_eyed_junco_male.jpg', 'Dark-eyed Junco: male teaching illustration', 'AI-generated illustration intended to represent a male Dark-eyed Junco.', 'ai_illustration', 'AI-generated for this teaching package; not a photograph.', NULL, 506, 344),
    ('dark_eyed_junco_female.jpg', 'Dark-eyed Junco: female teaching illustration', 'AI-generated illustration intended to represent a female Dark-eyed Junco.', 'ai_illustration', 'AI-generated for this teaching package; not a photograph.', NULL, 506, 344),
    ('rose_breasted_grosbeak_male.jpg', 'Rose-breasted Grosbeak: male teaching illustration', 'AI-generated illustration intended to represent a male Rose-breasted Grosbeak.', 'ai_illustration', 'AI-generated for this teaching package; not a photograph.', NULL, 506, 406),
    ('rose_breasted_grosbeak_female.jpg', 'Rose-breasted Grosbeak: female teaching illustration', 'AI-generated illustration intended to represent a female Rose-breasted Grosbeak.', 'ai_illustration', 'AI-generated for this teaching package; not a photograph.', NULL, 506, 406),
    ('towhee_cardinal_comparison.jpg', 'Eastern Towhee and Northern Cardinal: comparison illustration', 'Side-by-side AI-generated teaching illustrations of a male Eastern Towhee and a male Northern Cardinal.', 'ai_illustration', 'Composite of two AI-generated teaching illustrations; not a photograph.', NULL, 1120, 378)
ON DUPLICATE KEY UPDATE file_name = file_name;

-- Look up parent IDs by their unique names rather than assuming IDs 1-8.
-- This also works when the original eight species have different IDs.
-- The composite primary key and no-op upsert prevent duplicate links.

INSERT INTO bird_image_links (bird_id, image_id, sex, sort_order)
SELECT b.id, i.id, 'male', 1
FROM birds AS b
CROSS JOIN bird_images AS i
WHERE b.scientific_name = 'Pipilo erythrophthalmus'
  AND i.file_name = 'eastern_towhee_male.jpg'
ON DUPLICATE KEY UPDATE sex = sex;

INSERT INTO bird_image_links (bird_id, image_id, sex, sort_order)
SELECT b.id, i.id, 'female', 2
FROM birds AS b
CROSS JOIN bird_images AS i
WHERE b.scientific_name = 'Pipilo erythrophthalmus'
  AND i.file_name = 'eastern_towhee_female.jpg'
ON DUPLICATE KEY UPDATE sex = sex;

INSERT INTO bird_image_links (bird_id, image_id, sex, sort_order)
SELECT b.id, i.id, 'male', 1
FROM birds AS b
CROSS JOIN bird_images AS i
WHERE b.scientific_name = 'Turdus migratorius'
  AND i.file_name = 'american_robin_male.jpg'
ON DUPLICATE KEY UPDATE sex = sex;

INSERT INTO bird_image_links (bird_id, image_id, sex, sort_order)
SELECT b.id, i.id, 'female', 2
FROM birds AS b
CROSS JOIN bird_images AS i
WHERE b.scientific_name = 'Turdus migratorius'
  AND i.file_name = 'american_robin_female.jpg'
ON DUPLICATE KEY UPDATE sex = sex;

INSERT INTO bird_image_links (bird_id, image_id, sex, sort_order)
SELECT b.id, i.id, 'male', 1
FROM birds AS b
CROSS JOIN bird_images AS i
WHERE b.scientific_name = 'Cyanocitta cristata'
  AND i.file_name = 'blue_jay_male.jpg'
ON DUPLICATE KEY UPDATE sex = sex;

INSERT INTO bird_image_links (bird_id, image_id, sex, sort_order)
SELECT b.id, i.id, 'female', 2
FROM birds AS b
CROSS JOIN bird_images AS i
WHERE b.scientific_name = 'Cyanocitta cristata'
  AND i.file_name = 'blue_jay_female.jpg'
ON DUPLICATE KEY UPDATE sex = sex;

INSERT INTO bird_image_links (bird_id, image_id, sex, sort_order)
SELECT b.id, i.id, 'male', 1
FROM birds AS b
CROSS JOIN bird_images AS i
WHERE b.scientific_name = 'Thryothorus ludovicianus'
  AND i.file_name = 'carolina_wren_male.jpg'
ON DUPLICATE KEY UPDATE sex = sex;

INSERT INTO bird_image_links (bird_id, image_id, sex, sort_order)
SELECT b.id, i.id, 'female', 2
FROM birds AS b
CROSS JOIN bird_images AS i
WHERE b.scientific_name = 'Thryothorus ludovicianus'
  AND i.file_name = 'carolina_wren_female.jpg'
ON DUPLICATE KEY UPDATE sex = sex;

INSERT INTO bird_image_links (bird_id, image_id, sex, sort_order)
SELECT b.id, i.id, 'male', 1
FROM birds AS b
CROSS JOIN bird_images AS i
WHERE b.scientific_name = 'Cardinalis cardinalis'
  AND i.file_name = 'northern_cardinal_male.jpg'
ON DUPLICATE KEY UPDATE sex = sex;

INSERT INTO bird_image_links (bird_id, image_id, sex, sort_order)
SELECT b.id, i.id, 'female', 2
FROM birds AS b
CROSS JOIN bird_images AS i
WHERE b.scientific_name = 'Cardinalis cardinalis'
  AND i.file_name = 'northern_cardinal_female.jpg'
ON DUPLICATE KEY UPDATE sex = sex;

INSERT INTO bird_image_links (bird_id, image_id, sex, sort_order)
SELECT b.id, i.id, 'male', 1
FROM birds AS b
CROSS JOIN bird_images AS i
WHERE b.scientific_name = 'Melanerpes carolinus'
  AND i.file_name = 'red_bellied_woodpecker_male.jpg'
ON DUPLICATE KEY UPDATE sex = sex;

INSERT INTO bird_image_links (bird_id, image_id, sex, sort_order)
SELECT b.id, i.id, 'female', 2
FROM birds AS b
CROSS JOIN bird_images AS i
WHERE b.scientific_name = 'Melanerpes carolinus'
  AND i.file_name = 'red_bellied_woodpecker_female.jpg'
ON DUPLICATE KEY UPDATE sex = sex;

INSERT INTO bird_image_links (bird_id, image_id, sex, sort_order)
SELECT b.id, i.id, 'male', 1
FROM birds AS b
CROSS JOIN bird_images AS i
WHERE b.scientific_name = 'Junco hyemalis'
  AND i.file_name = 'dark_eyed_junco_male.jpg'
ON DUPLICATE KEY UPDATE sex = sex;

INSERT INTO bird_image_links (bird_id, image_id, sex, sort_order)
SELECT b.id, i.id, 'female', 2
FROM birds AS b
CROSS JOIN bird_images AS i
WHERE b.scientific_name = 'Junco hyemalis'
  AND i.file_name = 'dark_eyed_junco_female.jpg'
ON DUPLICATE KEY UPDATE sex = sex;

INSERT INTO bird_image_links (bird_id, image_id, sex, sort_order)
SELECT b.id, i.id, 'male', 1
FROM birds AS b
CROSS JOIN bird_images AS i
WHERE b.scientific_name = 'Pheucticus ludovicianus'
  AND i.file_name = 'rose_breasted_grosbeak_male.jpg'
ON DUPLICATE KEY UPDATE sex = sex;

INSERT INTO bird_image_links (bird_id, image_id, sex, sort_order)
SELECT b.id, i.id, 'female', 2
FROM birds AS b
CROSS JOIN bird_images AS i
WHERE b.scientific_name = 'Pheucticus ludovicianus'
  AND i.file_name = 'rose_breasted_grosbeak_female.jpg'
ON DUPLICATE KEY UPDATE sex = sex;

INSERT INTO bird_image_links (bird_id, image_id, sex, sort_order)
SELECT b.id, i.id, 'male', 3
FROM birds AS b
CROSS JOIN bird_images AS i
WHERE b.scientific_name = 'Pipilo erythrophthalmus'
  AND i.file_name = 'towhee_cardinal_comparison.jpg'
ON DUPLICATE KEY UPDATE sex = sex;

INSERT INTO bird_image_links (bird_id, image_id, sex, sort_order)
SELECT b.id, i.id, 'male', 3
FROM birds AS b
CROSS JOIN bird_images AS i
WHERE b.scientific_name = 'Cardinalis cardinalis'
  AND i.file_name = 'towhee_cardinal_comparison.jpg'
ON DUPLICATE KEY UPDATE sex = sex;

COMMIT;

-- Expected seed-only totals: 8, 17, 18. These are three result sets.
SELECT COUNT(*) AS bird_count FROM birds;
SELECT COUNT(*) AS image_count FROM bird_images;
SELECT COUNT(*) AS link_count FROM bird_image_links;
