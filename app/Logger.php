<?php

namespace App;

class Logger
{
    /**
     * Path to log file.
     * 
     * @var string
     */
    protected $path;

    /**
     * Initialize.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->path = storage_path('/logs.txt');
    }

    /**
     * Save new entry to the log file.
     * 
     * @param  string  $url
     * @return void
     */
    public function save(string $url): void
    {
        $entries = $this->entries();
        $entries[] = $this->makeEntry($url);

        if (count($entries) > 10) {
            array_shift($entries);
        }

        $file = fopen($this->path, "w");
        if (!$file) {
            error_log(print_r("Can't write log file at: {$this->path}", true));
        }

        $content = implode($entries);

        fwrite($file, $content);
        fclose($file);
    }

    /**
     * Return log file entries.
     * 
     * @return array
     */
    public function entries(): array
    {
        if (!is_file($this->path)) {
            return [];
        }
        return file($this->path);
    }

    /**
     * Make new entry.
     * 
     * @param  $string  $url
     * @return string
     */
    protected function makeEntry($url): string
    {
        return date("H:i:s d-m-Y")." ".$url."\n";
    }
}