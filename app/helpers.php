<?php

use App\Vite;

/**
 * Return public path.
 * 
 * @param  string  $path
 * @return string
 */
function public_path(string $path = ''): string
{
    return realpath('').$path;
}

/**
 * Return storage path.
 * 
 * @param  string  $path
 * @return string
 */
function storage_path(string $path = ''): string
{
    $storage_path = dirname(public_path())."/storage";

    if (!file_exists($storage_path)) {
        mkdir($storage_path, 0777, true);
    }
    return $storage_path.$path;
}

/**
 * Resolve Vite asset tag.
 * 
 * @param  string $path
 * @return string
 */
function vite(string $path): string
{
    return Vite::getInstance()->resource($path);
}

/**
 * Redirects to base url.
 * 
 * @return void
 */
function redirect(): void
{
    header('Location: '.$_SERVER['HTTP_REFERER']);
    die;
}