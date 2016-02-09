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
 * Run the docs crontask in the browser `dev/tasks/UpdateDocsCronTask` to check out the documentation repositories, which builds the docs (this will take a while the first time it is run) and then updates the Lucene search index. If you have sake installed then run the build tasks directly, first run `sake dev/tasks/UpdateTask flush=1` and then run `sake dev/tasks/RebuildLuceneDocsIndex flush=1` to rebuild the search index.
 * Make sure to flush the cache for markdown content to show up

## Source Documentation Files

Documentation for each module is stored on the filesystem via a full git clone
of the module to the `assets/src/` subdirectory. These checkouts are ignored from this repository 
to allow for easier updating and to keep this project small. For the main documentation a branch
 is used for each minor version of SilverStripe CMS.

To update or download the source documentation at any time run the following
BuildTask command with sake:

	cd /Sites/userhelp.silverstripe.org/
	sake dev/tasks/UpdateTask flush=1

This build task will download / update each module as listed
in the `app/_config/docs-repositories.yml` file. Running `sake dev/tasks/RebuildLuceneDocsIndex flush=1` will also create a search index and reindex the documentation 
so that searching works (part of the docsviewer module that uses Lucene search). 

Once the build task has executed and downloaded the latest files,
those files are registered along with the module version the folder relates to.
through the `app/_config/docsviewer.yml` file.

```yaml
DocumentationManifest:
  register_entities:
    -
      Path: "assets/src/userhelp_3.2/docs/"
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

The cron job keeps userhelp.silverstripe.org up to date with the latest code. The crontask `app/code/UpdateDocsCronTask.php` fetches the latest documentation for each module from git and rebuilds the search indexes.

	public function getSchedule() {
    return "0 20 * * *"; // runs process() function every hour at 8pm
  }

## Deployment

Deploy is via the SilverStripe Platform deployment tool and uses StackShare