# userhelp.silverstripe.org

This is the source code powering https://userhelp.silverstripe.org.  It primarily
consists of the SilverStripe framework and [docsviewer](https://github.com/silverstripe/silverstripe-docsviewer)
module with minimal configuration.

For adding functionality or editing the style of the documentation see the 
[docsviewer](http://github.com/silverstripe/silverstripe-docsviewer) module.

## Development

To set up a test instance:

 * Clone this repository to a LAMP server.
 * Install [Composer](http://userhelp.silverstripe.org/framework/en/installation/composer)
 * After installing composer run `composer install --prefer-source` to grab the modules.
 * Run "make update" to check out the repositories from which is builds the
 docs (this will take a while the first time)
 * Make sure to flush the cache for markdown content to show up

## Source Documentation Files

Documentation for each module is stored on the filesystem via a full git clone
of the module to the `src/` subdirectory. These checkouts are ignored from this repository 
to allow for easier updating and to keep this project small. For the main documentation a branch
 is used for each minor version of SilverStripe CMS.

To update or download the source documentation at any time run the following
make command in your terminal:

	cd /Sites/userhelp.silverstripe.org/
	make update

`make update` will call bin/update.sh to download / update each module as listed
in the bin/update.sh file. This will also create a search index and reindex the documentation 
so that searching works (part of the docsviewer module that uses Lucene search). 

Once the `make update` command has executed and downloaded the latest files,
those files are registered along with the module version the folder relates to.
through the `app/_config/docsviewer.yml` file.

```yaml
DocumentationManifest:
  register_entities:
    -
      Path: "src/userhelp_3.2/docs/"
      Title: "User Help"
      Version: "3.2"
      Stable: true
      DefaultEntity: true
```

Set `Stable: true` on the set of documentation relating the current stable version of SilverStripe CMS.


## Contribution

To contribute an improvement to the userhelp.silverstripe.org functionality or
theme, submit a pull request on GitHub. Any approved pull requests will make
their way onto the userhelp.silverstripe.org site in the next release.

The content for userhelp.silverstripe.org is stored in a separate repository:
[https://github.com/silverstripe/silverstripe-userhelp-content](https://github.com/silverstripe/silverstripe-userhelp-content). 
If you wish to edit the documentation content, submit a pull request on that Github project. Updates 
to the content are synced regularly with userhelp.silverstripe.org via a cron job.

## Cron job

The cron job keeps userhelp.silverstripe.org up to date with the latest code. This
cron task calls `make update`, a script that fetches the latest documentation
for each module from git and rebuilds the search indexes.

	05 * * * * sites make -f /sites/userhelp.silverstripe.org/www/Makefile -C /sites/userhelp.silverstripe.org/www update

## Deployment

Deploy is via the SilverStripe Platform deployment tool (note: the site is not currently running on SilverStripe Platform and has a custom environment).
This requires someone internally at SilverStripe Ltd. to carry out deploymets for new features (the documentation however automatically updates).