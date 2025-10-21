<?php

/**
 * Classe UserPDO - Gestion des utilisateurs (PDO)
 * Phase 01 - Projet Classes PHP
 */

class UserPDO
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
     * Se connecte automatiquement à la base de données avec PDO
     */
    public function __construct()
    {
        // Inclusion de la configuration
        require_once __DIR__ . '/../config/database.php';

        // Connexion PDO
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";port=" . DB_PORT . ";charset=" . DB_CHARSET;
            $this->conn = new PDO($dsn, DB_USER, DB_PASS);

            // Mode d'erreur : exceptions
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion PDO : " . $e->getMessage());
        }
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
                VALUES (:login, :password, :email, :firstname, :lastname)";

        // 3. Préparation du statement
        $stmt = $this->conn->prepare($sql);

        // 4. Exécution avec tableau associatif
        $stmt->execute([
            ':login' => $login,
            ':password' => $hashedPassword,
            ':email' => $email,
            ':firstname' => $firstname,
            ':lastname' => $lastname
        ]);

        // 5. Récupération de l'ID auto-incrémenté
        $this->id = $this->conn->lastInsertId();

        // 6. Remplissage des attributs de l'objet
        $this->login = $login;
        $this->email = $email;
        $this->firstname = $firstname;
        $this->lastname = $lastname;

        // 7. Retour des informations
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
                WHERE login = :login";

        $stmt = $this->conn->prepare($sql);

        // 2. Exécution
        $stmt->execute([':login' => $login]);

        // 3. Récupération de la ligne
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // L'utilisateur existe

            // 4. Vérification du mot de passe
            if (password_verify($password, $user['password'])) {
                // ✅ Mot de passe correct

                // 5. Remplissage des attributs de l'objet
                $this->id = $user['id'];
                $this->login = $user['login'];
                $this->email = $user['email'];
                $this->firstname = $user['firstname'];
                $this->lastname = $user['lastname'];

                return true;
            } else {
                // ❌ Mauvais mot de passe
                return false;
            }
        } else {
            // ❌ Utilisateur inexistant
            return false;
        }
    }

    /**
     * Déconnexion de l'utilisateur
     * Réinitialise tous les attributs
     * 
     * @return void
     */
    public function disconnect()
    {
        // Réinitialisation de tous les attributs
        $this->id = null;
        $this->login = null;
        $this->email = null;
        $this->firstname = null;
        $this->lastname = null;
    }

    /**
     * Suppression de l'utilisateur
     * Supprime l'utilisateur de la BDD et le déconnecte
     * 
     * @return bool True si suppression réussie, False sinon
     */
    public function delete()
    {
        // 1. Vérifier que l'utilisateur est connecté
        if ($this->id === null) {
            return false;
        }

        // 2. Préparation de la requête DELETE
        $sql = "DELETE FROM users WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        // 3. Exécution
        $success = $stmt->execute([':id' => $this->id]);

        // 4. Si suppression réussie, déconnexion
        if ($success) {
            $this->disconnect();
            return true;
        }

        return false;
    }

    /**
     * Mise à jour des informations de l'utilisateur
     * 
     * @param string $login Nouveau nom d'utilisateur
     * @param string $password Nouveau mot de passe (sera haché)
     * @param string $email Nouvel email
     * @param string $firstname Nouveau prénom
     * @param string $lastname Nouveau nom
     * @return bool True si mise à jour réussie, False sinon
     */
    public function update($login, $password, $email, $firstname, $lastname)
    {
        // 1. Vérifier que l'utilisateur est connecté
        if ($this->id === null) {
            return false;
        }

        // 2. Hachage du nouveau mot de passe
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // 3. Préparation de la requête UPDATE
        $sql = "UPDATE users 
                SET login = :login, password = :password, email = :email, 
                    firstname = :firstname, lastname = :lastname 
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        // 4. Exécution
        $success = $stmt->execute([
            ':login' => $login,
            ':password' => $hashedPassword,
            ':email' => $email,
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':id' => $this->id
        ]);

        // 5. Si mise à jour réussie, synchroniser l'objet
        if ($success) {
            $this->login = $login;
            $this->email = $email;
            $this->firstname = $firstname;
            $this->lastname = $lastname;
            return true;
        }

        return false;
    }

    /**
     * Vérifie si l'utilisateur est connecté
     * 
     * @return bool True si connecté, False sinon
     */
    public function isConnected()
    {
        return $this->id !== null;
    }

    /**
     * Retourne toutes les informations de l'utilisateur
     * 
     * @return array|null Tableau avec les infos ou null si non connecté
     */
    public function getAllInfos()
    {
        if ($this->id === null) {
            return null;
        }

        return [
            'id' => $this->id,
            'login' => $this->login,
            'email' => $this->email,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname
        ];
    }

    /**
     * Retourne le login de l'utilisateur
     * 
     * @return string|null
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Retourne l'email de l'utilisateur
     * 
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Retourne le prénom de l'utilisateur
     * 
     * @return string|null
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Retourne le nom de l'utilisateur
     * 
     * @return string|null
     */
    public function getLastname()
    {
        return $this->lastname;
    }
}
