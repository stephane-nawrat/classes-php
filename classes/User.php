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

    /**
     * Inscription d'un nouvel utilisateur
     * 
     * @param string $login Nom d'utilisateur
     * @param string $password Mot de passe (sera haché)
     * @param string $email Email
     * @param string $firstname Prénom
     * @param string $lastname Nom
     * @return array Tableau avec les informations de l'utilisateur créé
     */
    public function register($login, $password, $email, $firstname, $lastname)
    {
        // 1. Hachage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // 2. Préparation de la requête SQL
        $sql = "INSERT INTO users (login, password, email, firstname, lastname) 
                VALUES (?, ?, ?, ?, ?)";

        // 3. Préparation du statement
        $stmt = mysqli_prepare($this->conn, $sql);

        // Vérification de la préparation
        if (!$stmt) {
            die("Erreur de préparation : " . mysqli_error($this->conn));
        }

        // 4. Binding des paramètres (5 strings = "sssss")
        mysqli_stmt_bind_param($stmt, "sssss", $login, $hashedPassword, $email, $firstname, $lastname);

        // 5. Exécution
        if (!mysqli_stmt_execute($stmt)) {
            die("Erreur d'exécution : " . mysqli_stmt_error($stmt));
        }

        // 6. Récupération de l'ID auto-incrémenté
        $this->id = mysqli_insert_id($this->conn);

        // 7. Remplissage des attributs de l'objet
        $this->login = $login;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;

        // 8. Fermeture du statement
        mysqli_stmt_close($stmt);

        // 9. Retour des informations
        return [
            'id' => $this->id,
            'login' => $this->login,
            'email' => $this->email,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname
        ];
    }


    /**
     * Connexion d'un utilisateur
     * 
     * @param string $login Nom d'utilisateur
     * @param string $password Mot de passe en clair
     * @return bool True si connexion réussie, False sinon
     */
    public function connect($login, $password)
    {
        // 1. Préparation de la requête SELECT
        $sql = "SELECT id, login, password, email, firstname, lastname 
                FROM users 
                WHERE login = ?";

        $stmt = mysqli_prepare($this->conn, $sql);

        if (!$stmt) {
            die("Erreur de préparation : " . mysqli_error($this->conn));
        }

        // 2. Binding du paramètre
        mysqli_stmt_bind_param($stmt, "s", $login);

        // 3. Exécution
        mysqli_stmt_execute($stmt);

        // 4. Liaison des résultats aux variables
        mysqli_stmt_bind_result($stmt, $id, $dbLogin, $hashedPassword, $email, $firstname, $lastname);

        // 5. Récupération de la ligne
        if (mysqli_stmt_fetch($stmt)) {
            // L'utilisateur existe

            // 6. Vérification du mot de passe
            if (password_verify($password, $hashedPassword)) {
                // ✅ Mot de passe correct

                // 7. Remplissage des attributs de l'objet
                $this->id = $id;
                $this->login = $dbLogin;
                $this->email = $email;
                $this->firstname = $firstname;
                $this->lastname = $lastname;

                // 8. Fermeture et retour
                mysqli_stmt_close($stmt);
                return true;
            } else {
                // ❌ Mauvais mot de passe
                mysqli_stmt_close($stmt);
                return false;
            }
        } else {
            // ❌ Utilisateur inexistant
            mysqli_stmt_close($stmt);
            return false;
        }
    }
}
