#!/bin/bash

dir=$1

if [ ! "$dir" ]; then
  echo "Usage: $0 /base/folder/to/docs"
  exit 1
fi

#=== FUNCTION ================================================================
# NAME: 		checkout
# DESCRIPTION:	Checks out a specific branch of a module into a folder. Not
#				particular good for taking up space, but at the moment separate
#				folders for each version we need will do.
#
#				The master branch will checked out by default
# PARAMETERS:
#				$1 - module path on github (e.g silverstripe/sapphire.git)
#				$2 - branch name (e.g 3.0)
#				$3 - module name (e.g sapphire)
#
#===============================================================================
# Parameters: github path
function checkout {
	if [ ! -d $dir/src/$2 ]; then
		echo "Cloning $1 "
		if [ ! -d $dir/src ]; then
			mkdir $dir/src
		fi
		cd $dir/src
		git clone -q git://github.com/$1 $2 --quiet
		cd $2
		git checkout -q origin/master
	else
		cd $dir/src/$2
		git pull -q origin master
		git checkout -q origin/master 
	fi

	if [ $# == 3 ]; then
		echo "Checking out $2 from $1 into $2_$3"

		if [ -d $dir/src/$2_$3 ]; then
			cd $dir/src/$2_$3
		else
			cp -R $dir/src/$2 $dir/src/$2_$3
			cd $dir/src/$2_$3
		fi

		git reset --hard -q
		git checkout $3 -q
		git pull -q
	else
		echo "Checking out $2 from $1 into $2"
	fi
}

#Clear out the src folder
cd $dir
rm -rf $dir/src/

# Get the versions of userhelp docs
checkout 'camfindlay/silverstripe-userhelp-content.git' 'userhelp' '3.2'
checkout 'camfindlay/silverstripe-userhelp-content.git' 'userhelp' '3.1'
checkout 'camfindlay/silverstripe-userhelp-content.git' 'userhelp' '3.0'

# Get the supported module versions - we look at latest stable version branch for the version of CMS.
checkout 'camfindlay/silverstripe-blog.git' 'blog' 'master'
checkout 'camfindlay/silverstripe-userforms.git' 'userforms' 'master'
checkout 'camfindlay/silverstripe-translatable.git' 'translatable' '2.0' #3.1 compatible
checkout 'camfindlay/silverstripe-translatable.git' 'translatable' '2.1' #3.2 compatible
checkout 'camfindlay/advancedworkflow.git' 'advancedworkflow' 'master'

checkout 'mandrew/silverstripe-subsites.git' 'subsites' '1.0' #3.1 compatible
checkout 'mandrew/silverstripe-subsites.git' 'subsites' '1.1' #3.2 compatible
checkout 'mandrew/silverstripe-secureassets.git' 'secureassets' 'master'
checkout 'mandrew/silverstripe-forum.git' 'forum' '0.8'
checkout 'mandrew/silverstripe-taxonomy.git' 'taxonomy' 'master'
checkout 'mandrew/silverstripe-iframe.git' 'iframe' 'master'
checkout 'mandrew/silverstripe-registry.git' 'registry' 'master'

echo "Done."