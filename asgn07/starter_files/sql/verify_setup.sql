-- Read-only checks: no rows are modified or deleted.
USE wnc_birds;

-- Expected seed-only counts: 8, 17, 18.
SELECT COUNT(*) AS bird_count FROM birds;
SELECT COUNT(*) AS image_count FROM bird_images;
SELECT COUNT(*) AS link_count FROM bird_image_links;

-- Both foreign keys must report UPDATE_RULE = CASCADE and DELETE_RULE = CASCADE.
SELECT CONSTRAINT_NAME, REFERENCED_TABLE_NAME, UPDATE_RULE, DELETE_RULE
FROM information_schema.REFERENTIAL_CONSTRAINTS
WHERE CONSTRAINT_SCHEMA = DATABASE()
  AND TABLE_NAME = 'bird_image_links'
ORDER BY CONSTRAINT_NAME;

-- Confirms the composite primary key and both foreign keys in the actual schema.
SHOW CREATE TABLE bird_image_links;

-- One comparison image, linked to TWO different species.
SELECT i.file_name, b.common_name, l.sex
FROM bird_image_links AS l
JOIN birds AS b ON b.id = l.bird_id
JOIN bird_images AS i ON i.id = l.image_id
WHERE i.file_name = 'towhee_cardinal_comparison.jpg'
ORDER BY b.common_name;

-- Expected: zero orphaned relationships.
SELECT COUNT(*) AS orphaned_links
FROM bird_image_links AS l
LEFT JOIN birds AS b ON b.id = l.bird_id
LEFT JOIN bird_images AS i ON i.id = l.image_id
WHERE b.id IS NULL OR i.id IS NULL;

-- Expected seed-only: 3 links for Towhee and Cardinal, 2 for other species.
-- This SQL is for inspection in the database tool, NOT a required PHP bird page.
SELECT b.common_name, COUNT(l.image_id) AS linked_images
FROM birds AS b
LEFT JOIN bird_image_links AS l ON l.bird_id = b.id
GROUP BY b.id, b.common_name
ORDER BY b.common_name;
