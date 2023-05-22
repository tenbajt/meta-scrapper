<?php

namespace App;

use App\Session;
use App\Scrapper;
use App\Logger;

class Controller
{
    /**
     * Display form.
     * 
     * @param  App\Session  $session
     * @return void
     */
    public static function index(Session $session, Logger $logger): void
    {
        include_once __DIR__.'/../resources/views/main.php';
    }

    /**
     * Download meta title and description from given URL.
     * 
     * @return void
     */
    public static function download(Session $session, Scrapper $scrapper, Logger $logger): void
    {
        if (!isset($_POST['nonce']) || $_POST['nonce'] !== $session->get('nonce')) {
            redirect();
        }
        
        if (!isset($_POST['url']) || empty($_POST['url'])) {
            $session->put('error_url', 'Adres URL jest wymagany');
            redirect();
        }

        $url = $session->put('url', htmlspecialchars($_POST['url']));

        $logger->save($url);
        $scrapper->scrap($url);

        if ($scrapper->error()) {
            $session->put('error_url', $scrapper->error());
            redirect();
        }

        $title = $session->put('title', $scrapper->title());
        $titleCount = $session->put('title_count', mb_strlen($title));
        $session->put('title_count_error', $titleCount > 75);

        $desc = $session->put('desc', $scrapper->desc());
        $descCount = $session->put('desc_count', mb_strlen($desc));
        $session->put('desc_count_error', $descCount > 160);

        redirect();
    }

    /**
     * Clears all session variables and redirects back to form.
     * 
     * @return void
     */
    public static function clear(Session $session): void
    {
        $session->flush();
        redirect();
    }
}