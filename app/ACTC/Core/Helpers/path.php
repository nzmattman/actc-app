<?php

declare(strict_types=1);

if (! function_exists('actc_path')) {
    function actc_path(string $path): string
    {
        return app_path('ACTC/'.$path);
    }
}
