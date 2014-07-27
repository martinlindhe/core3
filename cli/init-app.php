<?php
/**
 * Initial setup for a new app using core3,
 * copies skeleton files into place and creates directory structure
 */

// TODO another tool that echos out a useable apache vhost entry
// TODO check permissions


echo "Initial setup for ".getcwd()." ...\n";

$defaultDirectories = array('api', 'cli', 'css', 'class', 'img', 'fonts', 'js', 'scss', 'test', 'view');
foreach ($defaultDirectories as $dirName) {
    if (!is_dir($dirName)) {
        mkdir($dirName);
    } else {
        echo "NOTICE: directory ".$dirName." already exists\n";
    }
}

$skeletonDir = __DIR__.'/../app_skeleton';

$filesToCopy = array(
    'Makefile' => 'Makefile',
    'index.php' => 'index.php',
    'gitignore' => '.gitignore',
    'htaccess' => '.htaccess'
);

foreach ($filesToCopy as $srcFileName => $dstFileName) {

    if (file_exists($dstFileName)) {
        echo "NOTICE: skipping ".$dstFileName." creation, file exists\n";
    } else {
        echo "Creating ".$dstFileName."\n";
        if (copy($skeletonDir.'/'.$srcFileName, $dstFileName) === false) {
            echo "ERROR copy failed\n";
        }
    }
}

echo "Setup complete.\n";
