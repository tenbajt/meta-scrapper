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
     * List of log entries.
     * 
     * @var array
     */
    protected $entries = [];

    /**
     * Initialize.
     * 
     * @return void
     */
    public function __construct()
    {
        $this->path = storage_path('/logs.txt');
        $this->loadEntries();
    }

    /**
     * Load current entries from log file.
     * 
     * @return void
     */
    protected function loadEntries(): void
    {
        if (!is_file($this->path)) {
            $this->entries = [];
        }

        $this->entries = file($this->path);
    }

    /**
     * Save new entry to the log file.
     * 
     * @param  string  $url
     * @return void
     */
    public function save(string $url): void
    {
        $this->entries[] = $this->makeEntry($url);

        if (count($this->entries) > 10) {
            array_shift($this->$entries);
        }

        $file = fopen($this->path, "w");
        if (!$file) {
            error_log(print_r("Can't write log file at: {$this->path}", true));
            return;
        }

        $content = implode($this->entries);

        fwrite($file, $content);
        fclose($file);
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

    /**
     * Return log file entries.
     * 
     * @return array
     */
    public function entries(): array
    {
        return $this->entries;
    }
}