<?php
/**
 * Initial setup for a new app using core3,
 * copies skeleton files into place and creates directory structure
 */

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


// allow apache to write into compiled dir
mkdir('scss/compiled');
chmod('scss/compiled', 0777);  // FIXME what is proper flags?


$skeletonDir = __DIR__.'/../app_skeleton';

$filesToCopy = array(
    'Makefile' => 'Makefile',
    'bootstrap.php' => 'bootstrap.php',
    'index.php' => 'index.php',
    'composer.json' => 'composer.json',
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
