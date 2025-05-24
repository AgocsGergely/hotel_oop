<?php

namespace App\Views;
use App\Database\Database;
use App\Database\Install;
use Exception;

class Layout
{
    public static function header($title = "Hotel") {
        echo <<<HTML
        <!DOCTYPE html>
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>$title</title>

                <link href="/fontawesome/css/all.css" rel="stylesheet" type="text/css">
                <link href="/css/school.css" rel="stylesheet" type="text/css">
                <style>
                    body {
                        background: beige;
                    }
                </style>

            </head>

            <body>
        HTML;
        self::navbar();
        self::handleMessage();
        echo '<div class="container">';
    }

    private static function handleMessage(): void
    {
        $message = [
            'success_message' => 'success',
        ];
    }

    public static function navbar() {
        echo <<<HTML
    <nav class="navbar">
        <ul class="nav-list">
            <li class="nav-button"><a href="/"><button style="button" title="Kezdőlap">Kezdőlap</button></a></li>
            <!--<li class="nav-button"><a href="/subjects"><button style="button" title="Tantárgyak">Tantárgyak</button></a></li>
            <li class="nav-button"><a href="/classes"><button style="button" title="Osztályok">Osztályok</button></a></li>-->
            <li class="nav-button"><a href="/rooms"><button style="button" title="Osztályok">Szobák</button></a></li>
            <li class="nav-button"><a href="/guests"><button style="button" title="Osztályok">Vendégek</button></a></li>
            <li class="nav-button">
                <form action="/install" method="post">
                    <input type="hidden" name="action" value="create_database">
                    <button type="submit" title="Adatbázis létrehozása">Adatbázis létrehozása</button>
                </form>
            </li>
        </ul>
    </nav>
    HTML;

    /*if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_database') {
        try {
                $install = new Install(); // Instantiate the Install class
                $install->createDatabase(); // Call the instance method
                echo "Database created successfully!";
            } catch (Exception $e) {
                echo "Error creating database: " . $e->getMessage();
            }
    }*/
    }

    public static function footer() {
        echo <<<HTML
        </div>
            <footer>
                <hr>
                <p>2025 &copy; Agócs Gergely</p>
            </footer>
        </body>
        </html>
        HTML;
    }
}