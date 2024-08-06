<?php

namespace Shortener;

use PDOException;

class Shortener
{
    private DatabaseFactory $databaseFactory;
    private Database $database;

    public function __construct()
    {
        $this->databaseFactory = new DatabaseFactory();
        $this->database = $this->databaseFactory->create();
    }

    public function redirect(): void {
        $shortenedUrl = trim($_SERVER['REQUEST_URI'], '/');

        try {
            $baseUrl = $this->database->query("SELECT base_url FROM urls WHERE shortened_url LIKE ?", ['%'. $shortenedUrl])[0]["base_url"];

            if (empty($baseUrl)) {
                echo "URL not found!";
                die();
            }

            header("Location: " . $baseUrl);
        } catch (PDOException $e) {
            echo "Failed to redirect!";
            die();
        }
    }

    public function createNewEntry(string $baseUrl): string
    {
        $shortenedUrl = $this->createMapping($baseUrl);

        try {
            $this->database->beginTransaction();

            $this->database->query("INSERT INTO urls (base_url, shortened_url) VALUES (?, ?)", [$shortenedUrl[0], $shortenedUrl[1]]);

            $this->database->commit();
        } catch (PDOException $e) {
            $this->database->rollBack();
            return "Failed to shorten the URL!";
        }
        try {
            $id = $this->database->getLastInsertId();
            return $this->database->query("SELECT shortened_url FROM urls WHERE id = ?", [$id])[0]["shortened_url"];
        } catch (PDOException $e) {
            return "Failed to shorten the URL!";
        }
    }

    private function createMapping(string $url): array
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

        $shortenedUrl = "http://localhost:8000/" . substr(str_shuffle($characters), 0, 6);
        return [$url, $shortenedUrl];
    }


}