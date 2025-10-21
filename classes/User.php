<?php

/**
 * Classe User - Gestion des utilisateurs (MySQLi)
 */

class User
{

    // Attributs
    private $id;
    public $login;
    public $email;
    public $firstname;
    public $lastname;

    // Connexion à la base de données
    private $conn;

    /**
     * Constructeur
     * Se connecte automatiquement à la base de données
     */
    public function __construct()
    {
        // Inclusion de la configuration
        require_once __DIR__ . '/../config/database.php';

        // Connexion MySQLi
        $this->conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME, DB_PORT);

        // Vérification de la connexion
        if (!$this->conn) {
            die("Erreur de connexion : " . mysqli_connect_error());
        }

        // Configuration du charset
        mysqli_set_charset($this->conn, DB_CHARSET);
    }
}
