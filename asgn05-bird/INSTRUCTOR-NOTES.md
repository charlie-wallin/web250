# Instructor Notes

## What this solution covers

This package focuses on **Part 2 — Bird Challenge**, which was the portion requested for the instructor solution.

The original assignment's Part 1 Bike Challenge is based on the Chapter 7 tutorial code and is not duplicated here.

## Quick rubric map

- Bird properties, visibility, constants, constructor: `private/classes/bird.class.php`
- Required conversion and display methods: `private/classes/bird.class.php`
- Parser reused with external delimiter setting: `public/birds.php`
- Escaped semantic table output: `public/birds.php`
- Missing file, blank row, and invalid conservation ID handling: parser + Bird + `birds.php`
- Go further #2 habitat filter: `public/birds.php`
- Go further #3 static finder: `Bird::find_by_habitat()`
- Concept checks: `README-INSTRUCTOR-SOLUTION.md`

## One grading detail worth noticing

`Bird::$count` counts object construction, while `ParseCSV::row_count()` counts parsed records. They happen to match here, but they measure different events. That distinction is useful when reviewing student explanations.
