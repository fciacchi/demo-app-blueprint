<?php

use Leaf\Vite;

// Apply the Vite configuration directly
Vite::config([
    'hotFile' => './public',
    'build' => './public', // Set the build path to /public/build
    'assets' => './public',
]);
