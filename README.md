# userhelp.silverstripe.org

This is the source code powering http://userhelp.silverstripe.org.  It primarily
consists of the SilverStripe framework and [docsviewer](https://github.com/silverstripe/silverstripe-docsviewer)
module with minimal configuration.

It's mostly copied off the existing [userhelp.silverstripe.org codebase](https://github.com/silverstripe/userhelp.silverstripe.org).

For adding functionality or editing the style of the documentation see the 
[docsviewer](http://github.com/silverstripe/silverstripe-docsviewer) module.

## Development

To set up a test instance:

 * Clone this repository to a LAMP server.
 * Install [Composer](http://userhelp.silverstripe.org/framework/en/installation/composer)
 * After installing composer run `composer install --prefer-source` to grab the modules.
 * Run "make update" to check out the repositories from which is builds the
 docs (this will take a while the first time)

## Source Documentation Files

Documentation for each module is stored on the filesystem via a full git clone
of the module to the `src/` subdirectory in this project. These checkouts are
ignored from this repository to allow for easier updating and to keep this
project small.

To update or download the source documentation at any time run the following
make command in your terminal:

	cd /Sites/userhelp.silverstripe.org/
	make fetch

`make fetch` will call bin/update.sh to download / update each module as listed
in the bin/update.sh file.

Once the `make fetch` command has executed and downloaded the latest files,
those files are registered along with the module version the folder relates to.
through the `app/_config.php` file.

	DocumentationService::register("sapphire", BASE_PATH ."/src/github/master/sapphire/docs/", '2.4');

## Contribution

To contribute an improvement to the userhelp.silverstripe.org functionality or
theme, submit a pull request on GitHub. Any approved pull requests will make
their way onto the userhelp.silverstripe.org site in the next release.

The content for userhelp.silverstripe.org is stored in a separate repository:
[https://github.com/silverstripe/silverstripe-userhelp-content](https://github.com/silverstripe/silverstripe-userhelp-content). If you wish to edit the documentation content, submit a pull request on that
Github project. Updates to the content are synced regularly with
userhelp.silverstripe.org via a cron job.

## Cron job

The cron job keeps userhelp.silverstripe.org up to date with the latest code. This
cron task calls `make update`, a script that fetches the latest documentation
for each module from git and rebuilds the search indexes.

	05 * * * * sites make -f /sites/userhelp.silverstripe.org/www/Makefile -C /sites/userhelp.silverstripe.org/www update