<?php

## TODO : looks in current dir/scss/*.scss, creates scss/compiled/*.css

echo "Generating css files ...\n";

$files = glob('scss/*.{scss}', GLOB_BRACE);
foreach ($files as $file) {
    echo $file."\n";
}
