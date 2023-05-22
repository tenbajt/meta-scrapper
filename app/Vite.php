<?php

namespace App;

class Vite
{
    /**
     * Instance.
     * 
     * @var App\Vite;
     */
    private static $instance;

    /**
     * The url of hot server.
     * 
     * @var string
     */
    protected $hotServer;

    /**
     * The resources manifest.
     * 
     * @var array
     */
    protected $manifest;

    /**
     * Initialize.
     * 
     * @return void
     */
    private function __construct()
    {
        $this->hotServer = $this->hotServer();

        if (!$this->hotServer) {
            $this->manifest = $this->manifest();
        }
    }

    /**
     * Return the hot server url or null if not running.
     * 
     * @return string|null
     */
    protected function hotServer()
    {
        $path = public_path('/hot');

        if (!is_file($path)) {
            return null;
        }

        return rtrim(file_get_contents($path));
    }

    /**
     * Return a list of resources in the manifest.
     * 
     * @return array
     */
    protected function manifest(): array
    {
        $path = public_path('/build/manifest.json');

        if (!is_file($path)) {
            throw new \Exception("Vite manifest not found at: {$path}");
        }

        return json_decode(file_get_contents($path), true);
    }

    /**
     * Return a resource tags.
     * 
     * @param  string  $path
     * @return string
     */
    public function resource(string $path): string
    {
        if ($this->hotServer) {
            return '<script type="module" src="'.$this->hotServer."/".$path.'"></script>';
        }

        if (!isset($this->manifest[$path]['file'])) {
            throw new \Exception("Unknown Vite resource: {$path}");
        }

        $tags = '<script src="build/'.$this->manifest[$path]['file'].'" defer></script>';

        if (!isset($this->manifest[$path]['css'])) {
            return $tags;
        }

        foreach ($this->manifest[$path]['css'] as $entry) {
            $tags .= "\n".'<link rel="stylesheet" href="build/'.$entry.'">';
        }

        return $tags;
    }

    /**
     * Return singleton instance.
     * 
     * @return App\Vite
     */
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new static();
        }

        return self::$instance;
    }
}