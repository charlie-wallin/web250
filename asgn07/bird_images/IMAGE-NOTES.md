# Image notes - WNC Birds teaching assets

These are **AI-generated illustrations**, not downloaded wildlife photographs.
They are supplied as real local JPEG files for database-linking and future
image-resizing practice. They are **not a scientific identification guide**.
The filenames and male/female labels describe the intended illustrations;
they do not document the sex of photographed animals.

There is one male illustration and one female illustration for each of the
eight species, plus one comparison image: **17 JPEG files in total**.
The comparison image contains an Eastern Towhee and a Northern Cardinal.
It is a side-by-side composite, not an observation of two birds together.

The images were separated from generated sheets and encoded as JPEG files.
The individual panels have not been resampled to a uniform display size.
Their differing widths and heights are recorded in the SQL seed data and
`image_manifest.json`. Keep these source files unchanged; a later assignment
can create smaller derivatives in a separate folder. Do not enlarge a small
image and assume that it has gained photographic detail.

## A note about male and female birds

Some species have more obvious plumage differences than others. Blue Jays and
Carolina Wrens should not be taught as having sharply different male/female
color patterns. Robin and junco plumage can also overlap by sex and age.
Consult real identification references instead of treating generated artwork
or a filename as proof of sex. The junco artwork is intended as the eastern,
slate-colored form, not a catalog of all geographic forms.

## References for bird information, not sources of the image files

The Cornell Lab pages below are useful identification references. Their
photographs have **not** been copied into this package, and Cornell does not
endorse or supply these generated images.

- [Eastern Towhee](https://www.allaboutbirds.org/guide/Eastern_Towhee/id)
- [American Robin](https://www.allaboutbirds.org/guide/American_Robin/id)
- [Blue Jay](https://www.allaboutbirds.org/guide/Blue_Jay/id)
- [Carolina Wren](https://www.allaboutbirds.org/guide/Carolina_Wren/id)
- [Northern Cardinal](https://www.allaboutbirds.org/guide/Northern_Cardinal/id)
- [Red-bellied Woodpecker](https://www.allaboutbirds.org/guide/Red-bellied_Woodpecker/id)
- [Dark-eyed Junco](https://www.allaboutbirds.org/guide/Dark-eyed_Junco/id)
- [Rose-breasted Grosbeak](https://www.allaboutbirds.org/guide/Rose-breasted_Grosbeak/id)

## File inventory

| Filename | Intended content | Width | Height |
|---|---|---:|---:|
| `eastern_towhee_male.jpg` | Eastern Towhee: male teaching illustration | 594 | 296 |
| `eastern_towhee_female.jpg` | Eastern Towhee: female teaching illustration | 593 | 296 |
| `american_robin_male.jpg` | American Robin: male teaching illustration | 594 | 325 |
| `american_robin_female.jpg` | American Robin: female teaching illustration | 593 | 325 |
| `blue_jay_male.jpg` | Blue Jay: male teaching illustration | 594 | 324 |
| `blue_jay_female.jpg` | Blue Jay: female teaching illustration | 593 | 324 |
| `carolina_wren_male.jpg` | Carolina Wren: male teaching illustration | 594 | 343 |
| `carolina_wren_female.jpg` | Carolina Wren: female teaching illustration | 593 | 343 |
| `northern_cardinal_male.jpg` | Northern Cardinal: male teaching illustration | 506 | 378 |
| `northern_cardinal_female.jpg` | Northern Cardinal: female teaching illustration | 506 | 378 |
| `red_bellied_woodpecker_male.jpg` | Red-bellied Woodpecker: male teaching illustration | 506 | 384 |
| `red_bellied_woodpecker_female.jpg` | Red-bellied Woodpecker: female teaching illustration | 506 | 384 |
| `dark_eyed_junco_male.jpg` | Dark-eyed Junco: male teaching illustration | 506 | 344 |
| `dark_eyed_junco_female.jpg` | Dark-eyed Junco: female teaching illustration | 506 | 344 |
| `rose_breasted_grosbeak_male.jpg` | Rose-breasted Grosbeak: male teaching illustration | 506 | 406 |
| `rose_breasted_grosbeak_female.jpg` | Rose-breasted Grosbeak: female teaching illustration | 506 | 406 |
| `towhee_cardinal_comparison.jpg` | Eastern Towhee and Northern Cardinal: comparison illustration | 1120 | 378 |

## Storage contract

The SQL `file_name` values match these JPEG filenames exactly, including case.
Only names, descriptions, dimensions, and credits belong in the database.
The JPEG bytes stay in this directory. The application does not display or
resize any of these images in asgn07.

`image_manifest.json` is an inventory for the instructor and future assignments;
students do not need to write JSON-processing code now. Its hashes describe the
supplied originals, not any future resized versions.
