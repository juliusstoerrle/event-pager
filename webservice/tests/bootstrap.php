<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

/* @phpstan-ignore function.alreadyNarrowedType */
if (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}

// @phpstan-ignore-next-line if.condNotBoolean
if ($_SERVER['APP_DEBUG']) {
    umask(0000);
}
