<?php 

session_start();
require_once __DIR__ . '/../includes/config.php'; // Chemin relatif sécurisé


define('TOKEN_EXPIRATION', 3600); // 1 heure en secondes
define('SECRET_KEY', $SECRET_KEY);
// Génère un token sécurisé 
function   generateAuthToken(int $user_id) : string{
    $tokenData = [
        'user_id' => $user_id,
        'created' => time(),
        'expires' => time() + TOKEN_EXPIRATION, 
        'ip' => $_SERVER['REMOTE_ADDR'],
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? ''  
    ];

    // Encodage et signature du token
    $encodedData =  base64_encode(json_encode($tokenData));
    $signature = hash_hmac('sha256', $encodedData, SECRET_KEY);

    return $encodedData . '.' . $signature;
};

// Validation du token 
function validateAuthToken(mixed $token) : mixed {
    if (strpos($token, ".") === false) return false;

    list($encodedData, $signature) =  explode('.', $token);

    // Vérification de la signature 
    $expectedSignature = hash_hmac('sha256', $encodedData, SECRET_KEY);
    if (!hash_equals($signature, $expectedSignature)) return false;

    // Vérification supplémentaires
    $currentTime = time();
    if($token['expire'] < $currentTime) return false;
    if($token['ip'] !== $_SERVER['REMOTE_ADDR']) return false;
    if($token['user_agent'] !== ($_SERVER['HTTP_USER_AGENT'] ?? '')) return false;
    
    return $token;
}


// Authentifie l'utilisateur
function authenticate(string $email, string $password): bool
{
    global $pdo;
    $stmt = $pdo->prepare("SELECT id, password FROM user where email = ?");
    $stmt->execute([$email]);
    $admin = $stmt->fetch();

    

    if ($admin) {

        var_dump('jaime la saucisse chaude');
        // $email && password_verify($password, $admin['password']) // code de verification password 
        // creation de token
        $token = bin2hex(random_bytes(32));
        $expires = time() + TOKEN_EXPIRATION;

        // Stockage de session
        $_SESSION['auth'] = [
            'user_id' => $admin['id'],
            'token' => $token,
            'expires' => $expires
        ];

        return true;
    };

    return false;
};

// Verifie si l'utilisateur est auhentifié 
function is_authenticated(): bool
{
    if (!isset($_SESSION['auth'])) {
        return false;
    }

    // Vérification de l'expiration
    if ($_SESSION['auth']['expires'] < time()) {
        unset($_SESSION['auth']);
        return false;
    }

    return true;
}

// Redirection si non authentfié
function require_auth()
{
    if (!is_authenticated()) {
        header('Location: ../login.php');
        exit();
    }
};


?>