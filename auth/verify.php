<?php
// ─────────────────────────────────────────────
// auth/verify.php
// AJAX endpoint: receives Firebase ID Token,
// verifies via Firebase REST API, starts PHP session
// ─────────────────────────────────────────────
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/firebase-config.php';

// Only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method not allowed']);
    exit;
}

// Read raw JSON body
$body    = json_decode(file_get_contents('php://input'), true);
$idToken = isset($body['idToken']) ? trim($body['idToken']) : '';

if (empty($idToken)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Missing idToken']);
    exit;
}

// ── Verify token via Firebase REST API ───────
$url     = 'https://identitytoolkit.googleapis.com/v1/accounts:lookup?key=' . FIREBASE_API_KEY;
$payload = json_encode(['idToken' => $idToken]);

$opts = [
    'http' => [
        'method'  => 'POST',
        'header'  => "Content-Type: application/json\r\nContent-Length: " . strlen($payload),
        'content' => $payload,
        'ignore_errors' => true,
    ],
];
$context  = stream_context_create($opts);
$response = file_get_contents($url, false, $context);
$data     = json_decode($response, true);

if (!isset($data['users'][0])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'error' => 'Invalid or expired token']);
    exit;
}

$user = $data['users'][0];

// ── Store user in PHP session ─────────────────
$_SESSION['uid']          = $user['localId']       ?? '';
$_SESSION['email']        = $user['email']          ?? '';
$_SESSION['displayName']  = $user['displayName']    ?? explode('@', $user['email'] ?? '')[0];
$_SESSION['photoUrl']     = $user['photoUrl']       ?? '';
$_SESSION['emailVerified']= $user['emailVerified']  ?? false;

echo json_encode([
    'success'     => true,
    'uid'         => $_SESSION['uid'],
    'email'       => $_SESSION['email'],
    'displayName' => $_SESSION['displayName'],
    'photoUrl'    => $_SESSION['photoUrl'],
]);
