# Politicians registering

A package to registers politicians in your platform.

This code is designed to be integrated to your own framework.

clear.sh: This file removes the compiled vendor folder from app folder.

## Note about migrations

This package comes with migrations. You can perform migration *in solo*, just executing `migrate.php` to make database migrations or `migrate_undo.php` to undo migration. 

You may integrate the database migrations to your framework. Just check `Migrations` table and use `Migrate` class inside your framework project.

## Requirements

This package should allow politicians data registering:

* name
* photos
* videos
* political parties

The package should store the historic of political parties changes. One politician may change its party.

The photos storaging may understands that a single photo may be frame several politicians.

## Technical requirements

Check [technical requirements](technical_requirements.md).

## Others READMEs

* [src](src/README.md)
* [src/CRUD](src/CRUD/README.md)
