# Instructor Solution — asgn05 Bird Challenge

This folder is a complete reference solution for the **Bird** portion of the Bike and Bird Challenge.

## Go Further Options Completed

This solution completes:

1. **Option 2 — Habitat filter**
   - `birds.php` accepts `?habitat=...`.
   - The filter links are built from the bird data.
   - The incoming query-string value is validated against the known habitats before it is used.
   - `u()` is used when a habitat is placed into a URL and `h()` is used when values are placed into HTML.

2. **Option 3 — Static finder**
   - `Bird::find_by_habitat($birds, $habitat)` returns a filtered array of `Bird` objects.
   - It is static because the operation works on a collection supplied to the class; it is not behavior belonging to one specific Bird object.

## Design Notes

### `display_name()` and escaping

`Bird::display_name()` returns **plain text**, not HTML. That keeps presentation markup in `birds.php`, where output can be escaped with `h()` before the scientific name is wrapped in `<em>`. If the model returned HTML, the view would have to decide whether to trust that HTML or escape it, which makes output safety harder to reason about.

### Static object counter

`Bird::$count` increases whenever a `Bird` object is constructed. `ParseCSV::row_count()` counts records accepted by the parser. The two values are equal in this solution because every parsed record becomes exactly one Bird object. They would differ if code created an extra Bird manually, parsed records without creating objects, or deliberately skipped some records during object creation.

### Size classes

The `Small`, `Medium`, and `Large` thresholds are teaching categories for this data set. They are not scientific bird-size classifications.

## Concept Check Answers

### 1. Why is `ParseCSV::$delimiter` a static property while a category list is a constant?

The delimiter is configuration: it can legitimately change from one data file to another. A static property gives the parser one class-wide setting that can be changed before `parse()` runs. A category allow-list such as `Bicycle::CATEGORIES` is meant to describe a fixed set of valid values, so a constant is a better fit because application code should not change it while the program runs.

### 2. What happens if someone reorders the CSV columns when the constructor receives one `$args` array?

The parser combines the header row with each data row, so the constructor receives named keys such as `common_name` and `wingspan_cm`. If the columns are reordered but the header moves with the data, the named keys still identify the correct values. With a ten-parameter positional constructor, reordering the source data could silently send the right values into the wrong parameters.

### 3. What does protecting `$wingspan_cm` accomplish?

A protected measurement forces outside code to use methods instead of assigning anything directly. The setter can convert or validate incoming values and the getter can format them consistently. A public measurement could be changed to an invalid string or to a value in the wrong unit without the class having a chance to correct it.

### 4. Why is `reset()` private? What could go wrong if page code could call it?

`reset()` exists only to prepare the parser for a new parse operation. If outside code could call it at the wrong time, it could erase the parser's stored results and row count, leaving `last_results()` and `row_count()` inconsistent with what the page expects. Keeping it private protects the parser's internal state.

### 5. Why use `self::CONSERVATION_OPTIONS` rather than `$this->CONSERVATION_OPTIONS`?

`CONSERVATION_OPTIONS` is a class constant, not an instance property. PHP accesses class constants with the scope-resolution operator `::`. `self::` makes it clear that the method is reading a value defined on the class itself rather than data stored separately on each object.

### 6. What did `money_format()` do that `number_format()` does not, and how would you handle German currency formatting?

`money_format()` used locale-aware monetary formatting; `number_format()` only formats a numeric value using separators and decimal places that the programmer supplies. In a modern PHP application that needs German currency rules, use the Intl extension's `NumberFormatter` with a locale such as `de_DE` and format the value as currency, for example EUR.

## Defensive Tests to Try

- Temporarily rename `private/wnc-birds.csv`. The page should still render its header/footer and show a readable error message.
- Put a blank line at the end of the CSV. No empty Bird row should appear.
- Temporarily change one `conservation_id` to `99`. The page should display `Unknown` for that bird.
- Try an invalid URL such as `birds.php?habitat=NotARealHabitat`. The page should reject that filter and show all birds.

## Instructor AI Note

This reference solution was generated with ChatGPT at the instructor's request and then syntax-checked and smoke-tested. It is intended as an instructor/grading reference rather than a student submission.
