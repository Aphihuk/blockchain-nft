<?php
// Firebase Project Configuration
define('FIREBASE_API_KEY',       'AIzaSyBzwd4izWlMhHPiax2_x6t0v-giT8PK97w');
define('FIREBASE_AUTH_DOMAIN',   'mylove-416f6.firebaseapp.com');
define('FIREBASE_PROJECT_ID',    'mylove-416f6');
define('FIREBASE_STORAGE_BUCKET','mylove-416f6.firebasestorage.app');
define('FIREBASE_MSG_SENDER_ID', '687580348706');
define('FIREBASE_APP_ID',        '1:687580348706:web:6faa031a63812ae01f257b');
define('FIREBASE_MEASUREMENT_ID','G-5KMB7JMHX4');

// Output JS firebaseConfig object (call this inside a <script> tag)
function echoFirebaseJsConfig(): void {
    echo "const firebaseConfig = {\n";
    echo "  apiKey:            \"" . FIREBASE_API_KEY . "\",\n";
    echo "  authDomain:        \"" . FIREBASE_AUTH_DOMAIN . "\",\n";
    echo "  projectId:         \"" . FIREBASE_PROJECT_ID . "\",\n";
    echo "  storageBucket:     \"" . FIREBASE_STORAGE_BUCKET . "\",\n";
    echo "  messagingSenderId: \"" . FIREBASE_MSG_SENDER_ID . "\",\n";
    echo "  appId:             \"" . FIREBASE_APP_ID . "\",\n";
    echo "  measurementId:     \"" . FIREBASE_MEASUREMENT_ID . "\"\n";
    echo "};\n";
}
