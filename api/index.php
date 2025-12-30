<?php

// Masukkan ini untuk mematikan cache yang bermasalah di Vercel
putenv('APP_CONFIG_CACHE=/tmp/config.php');
putenv('APP_ROUTES_CACHE=/tmp/routes.php');
putenv('APP_SERVICES_CACHE=/tmp/services.php');
putenv('APP_PACKAGES_CACHE=/tmp/packages.php');
putenv('VIEW_COMPILED_PATH=/tmp');

require __DIR__ . '/../public/index.php';
