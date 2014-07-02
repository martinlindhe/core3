<?php
/**
 * Force generates all scss -> css in app/scss
 */

echo "Generating css files, base dir ".getcwd()." ...\n";

$scss = new \Writer\Scss();
$scss->setImportPath(getcwd().'/scss');


$files = glob('scss/*.{scss}', GLOB_BRACE);
foreach ($files as $file) {
    $viewName = substr(basename($file), 0, -5);
    echo 'Rendering '.$viewName."\n";
    $scss->renderView($viewName, false);
}
