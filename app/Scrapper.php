<?php

namespace App;

require_once __DIR__.'/simple_html_dom.php';

class Scrapper
{
    /**
     * The error message.
     * 
     * @var string|bool
     */
    protected $error = false;

    /**
     * The title.
     * 
     * @var string
     */
    protected $title = '';

    /**
     * The description.
     * 
     * @var string
     */
    protected $desc = '';

    /**
     * @param  string  $url
     * @return void
     */
    public function scrap(string $url): void
    {
        $html = file_get_html($url);

        if (!$html) {
            $this->error = 'Nieprawidłowy link. Sprawdź link i spróbuj pobrać ponownie.';
            return;
        }

        $titleTag = $html->find('title', 0);
        if ($titleTag) {
            $this->title = trim(htmlspecialchars($titleTag->innertext));
        }

        $descTag = $html->find('meta[name="description"]', 0);
        if ($descTag) {
            $this->desc = trim(htmlspecialchars($descTag->content));
        }
    }

    /**
     * Return the error message or null if there is none.
     * 
     * @return string|bool
     */
    public function error()
    {
        return $this->error;
    }

    /**
     * Return title.
     * 
     * @return string
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * Return description.
     * 
     * @return string
     */
    public function desc()
    {
        return $this->desc;
    }
}