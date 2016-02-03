<?php

global $project;
$project = 'app';

global $database;
if(defined('SS_DATABASE_NAME') && SS_DATABASE_NAME) {
	$database = SS_DATABASE_NAME;
} else {
	$database = 'SS_userhelp';
}

require_once('conf/ConfigureFromEnv.php');

MySQLDatabase::set_connection_charset('utf8');

// This line set's the current theme. More themes can be
// downloaded from http://www.silverstripe.org/themes/
SSViewer::set_theme('userhelp');

Config::inst()->update('DocumentationManifest', 'automatic_registration', false);
Config::inst()->update('DocumentationViewer', 'link_base', '');
Config::inst()->update('DocumentationViewer', 'check_permission', false);

if(Director::isLive()) {
	Director::forceSSL();
	ControllerExtension::$google_analytics_code = 'UA-84547-10';
}

DocumentationViewer::set_edit_link(
	'framework',
	'https://github.com/silverstripe/silverstripe-userhelp-content/edit/%version%/docs/%lang%/%path%',
	array(
		'rewritetrunktomaster' => true
	)
);
DocumentationSearch::set_meta_data(array(
	'ShortName' => 'SilverStripe Userhelp',
	'Description' => 'Userhelp for SilverStripe CMS / Framework',
	'Tags' => 'silverstripe sapphire php framework cms content management system'
));

// Set shared index (avoid issues with different temp paths between CLI and web users)
if(file_exists(BASE_PATH . '/.lucene-index')) {
	Config::inst()->update('DocumentationSearch', 'index_location', BASE_PATH . '/.lucene-index');
}

// Fix invalid character in iconv
// see http://stackoverflow.com/questions/4723135/invalid-characters-for-lucene-text-search
Zend_Search_Lucene_Search_QueryParser::setDefaultEncoding('utf-8');
Zend_Search_Lucene_Analysis_Analyzer::setDefault(
    new Zend_Search_Lucene_Analysis_Analyzer_Common_Utf8_CaseInsensitive ()
);
