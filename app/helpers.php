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
    return dirname(public_path())."/storage{$path}";
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