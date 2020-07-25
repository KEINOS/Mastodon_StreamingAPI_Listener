# Init scripts

This directory places script files that are needed only for initialization process of this package.

- `setup-composer.sh`: Used in /.devcontainer and /.testcontainer
- `box.json`: Used for Phar archiving the /samples/Main.php script.
  - Run `$ composer compile` to generate a Phar app.
  - [Box3](https://github.com/humbug/box) is required. Install `composer global require humbug/box`
