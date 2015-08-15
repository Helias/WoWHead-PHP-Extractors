# WoWHead-PHP-Extractors

## Extractors

This project contains extractors about:

- creature loot
- pickpocketloot
- skinloot
- vendor
- trainer
- creature queststarter

The script to extract the missing vendor and trainer are in the same file php (vendor-trainer.php) to extract them you must use this file.

While the loot are in 3 files loot.php, skinloot.php and pickpocketloot.php but I made one file to check all the loot in the same time to check once a page of wowhead instead of 3.

## Usage

First of all you must configure it by modify the data on "connect.php".

Pay attention about the param '$start = "";' where you should put the entry where the tool start to compare.

To use this tool you can run the file php from terminal (suggested) or from web.

To use via terminal you can execute the follow command.

```
php file.php
```

If you have Linux or Mac OS check that the folder of the project and the files have the permissions 777.


Why via terminal? Because there you can read the logs.

Well, while the extractors compare the data they will add the entries (with missing data) in some files.txt.
