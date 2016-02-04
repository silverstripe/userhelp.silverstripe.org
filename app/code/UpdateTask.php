<?php

class UpdateTask extends BuildTask
{
    /**
     * @var string
     */
    protected $title = "Updates source markdown files";

    /**
     * @var string
     */
    protected $description = "Downloads and cleans source markdown documentation files";

    /**
     * @var bool
     */
    protected $enabled = true;

    /**
     * @var SS_HTTPRequest $request
     *
     * @todo test the initial unlink works with cloned modules
     */
    public function run($request)
    {
        $this->printLine("updating...");

        $path = $this->getPath();
        chdir("{$path}/src");

        $repositories = $this->getRepositories();

        foreach ($repositories as $repository) {
            $this->cloneRepository($repository);
            //$this->cleanRepository($repository);
        }
    }

    /**
     * @return string
     *
     * @todo document this new configuration parameter
     */
    private function getPath()
    {
        return ASSETS_PATH;
    }

    /**
     * @param string $message
     */
    private function printLine($message)
    {
        print $message . "\n";
        flush();
    }

    /**
     * @return array
     *
     * @todo put these modules in config
     */
    private function getRepositories()
    {
        return [
            ["silverstripe/silverstripe-userhelp-content", "userhelp", "3.2"],
            ["silverstripe/silverstripe-userhelp-content", "userhelp", "3.1"],
            ["silverstripe/silverstripe-userhelp-content", "userhelp", "3.0"],
            ["silverstripe-australia/silverstripe-versionedfiles", "versionedfiles", "master"],
            ["silverstripe-australia/advancedworkflow", "advancedworkflow", "master"],
            ["silverstripe-labs/silverstripe-registry", "registry", "master"],
            ["silverstripe/silverstripe-forum", "forum", "0.8"],
            ["silverstripe/silverstripe-contentreview", "contentreview", "master"],
            ["silverstripe/silverstripe-sitewidecontent-report", "sitewidecontent-report", "master"],
            ["silverstripe/silverstripe-blog", "blog", "master"],
            ["camfindlay/silverstripe-userforms", "userforms", "master"],
            ["camfindlay/silverstripe-translatable", "translatable", "2.0"],
            ["camfindlay/silverstripe-translatable", "translatable", "2.1"],
            ["mandrew/silverstripe-subsites", "subsites", "1.0"],
            ["mandrew/silverstripe-subsites", "subsites", "1.1"],
            ["mandrew/silverstripe-secureassets", "secureassets", "master"],
            ["mandrew/silverstripe-taxonomy", "taxonomy", "master"],
            ["mandrew/silverstripe-iframe", "iframe", "master"],
            ["mandrew/silverstripe-versionfeed", "versionfeed", "master"],
            ["mandrew/silverstripe-securityreport", "securityreport", "master"],
        ];
    }

    /**
     * @param array $repository
     *
     * @todo test this works with all modules
     */
    private function cloneRepository(array $repository)
    {
        list($remote, $folder, $branch) = $repository;

        $path = $this->getPath();

        if (!file_exists("{$path}/src")) {
            mkdir("{$path}/src");
        }

        if (!file_exists("{$path}/src/{$folder}_{$branch}")) {
            $this->printLine("cloning " . $remote);

            chdir("{$path}/src");
            exec("git clone -q git://github.com/{$remote}.git {$folder}_{$branch} --quiet");
        }

        chdir("{$path}/src/{$folder}_{$branch}");
        exec("git fetch origin");
        exec("git checkout -q origin/{$branch}");
    }

    /**
     * @param array $repository
     *
     * @todo test this works with all modules
     */
    private function cleanRepository(array $repository)
    {
        $files = array_merge(glob("*"), glob(".*"));

        foreach ($files as $file) {
            if ($file !== "docs" && $file !== "." && $file !== "..") {
                unlink($file);
            }
        }
    }
}