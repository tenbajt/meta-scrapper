<?php

namespace App;

class Session
{
    /**
     * Initialize.
     * 
     * @return void
     */
    public function __construct()
    {
        session_start();
    }

    /**
     * Set and return csrf token.
     * 
     * @return string
     */
    public function nonce(): string
    {
        return $this->put('nonce', md5(uniqid(mt_rand(), true)));
    }

    /**
     * Set value for the given key and return it.
     * 
     * @param  string  $key
     * @param  string  $value
     * @return mixed
     */
    public function put(string $key, string $value)
    {
        $_SESSION[$key] = $value;
        return $value;
    }

    /**
     * Return the value for the given key.
     * 
     * @param  string  $key
     * @param  mixed  $ddefault
     * @return mixed
     */
    public function get(string $key, $default = '')
    {
        if (!$this->has($key)) {
            return $default;
        }
        return $_SESSION[$key];
    }

    /**
     * Return the value for the given key and flashes it.
     * 
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    public function flash(string $key, $default = '')
    {
        $value = $this->get($key, $default);

        unset($_SESSION[$key]);

        return $value;
    }

    /**
     * Check if value is set for given key.
     * 
     * @param  string  $key
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Remove all data from session.
     * 
     * @return void
     */
    public function flush(): void
    {
        session_unset();
    }
}