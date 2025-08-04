<?
require_once __DIR__ . '/../includes/config.php'; // Chemin relatif sécurisé

try {

    $option = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ];

    $pdo = new PDO($dns = "mysql:host=" . $DB_HOST . "; dbname=" . $DB_NAME . "; charset=utf8", $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Active les erreurs SQL
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC // Retourne des tableaux associatifs
    ]);
} catch (PDOException $e) {
    die("erreur de connexion : " . $e->getMessage());
}


