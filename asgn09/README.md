# WEB-250 asgn09 - Create a Record

This solution builds on the completed asgn08 Active Record project. It keeps the existing read methods and adds one new database operation: creating a bird record with PDO.

## Main asgn09 changes

- `Bird::create()` performs an explicit `INSERT` with named placeholders.
- `public/bird_new.php` displays the form on GET and creates the record on POST.
- After a successful insert, the page redirects to `bird.php?id=<new id>`.
- `public/birds.php` includes a **Create Bird** link above the table.

## Request flow

```text
birds.php
   |
   | click Create Bird
   v
bird_new.php  (GET)
   |
   | submit form
   v
bird_new.php  (POST)
   |
   | Bird::create()
   v
MySQL INSERT -> new auto-increment ID
   |
   | redirect
   v
bird.php?id=<new id>
```

## Database credentials

The included `private/db_credentials.php` contains placeholders only. Replace them with the local values used by your asgn08 project. Keep the credentials file out of GitHub.

## Git workflow used in the assignment

```bash
git switch -c dev-create
# make and test the asgn09 changes
git add .
git commit -m "asgn09: add create bird workflow"
git push -u origin dev-create

git switch main
git merge --no-ff dev-create
git push origin main
```

Deploy the finished asgn09 site to the webhost, update the course/asgn09 index links, and confirm that the live Create Bird workflow works.

## Scope

This assignment creates records only. Update and delete are intentionally left for asgn10.
