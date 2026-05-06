<?php
// auth/forgot.php
session_start();
require_once __DIR__ . '/firebase-config.php';

if (!empty($_SESSION['uid'])) {
    header('Location: /index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password — NFT Gallery</title>
  <meta name="description" content="Reset your NFT Gallery account password.">
  <link rel="stylesheet" href="/css/auth.css">
</head>
<body>
<main class="auth-page">

  <a href="/" class="auth-logo">NFT<span>.</span>Gallery</a>

  <div class="auth-card">
    <h1>Reset password</h1>
    <p class="subtitle">We'll send a reset link to your email</p>

    <div class="auth-msg" id="authMsg">
      <span id="authMsgText"></span>
    </div>

    <form id="forgotForm" onsubmit="sendReset(event)" novalidate>
      <div class="form-group">
        <label for="forgotEmail">Email address</label>
        <input type="email" id="forgotEmail" placeholder="you@example.com" autocomplete="email" required>
      </div>
      <button type="submit" class="btn-primary" id="resetBtn">Send Reset Link</button>
    </form>

    <p class="auth-footer">
      Remembered it? <a href="/auth/login.php">Sign in</a>
    </p>
  </div>

</main>

<script type="module">
import { initializeApp }                from "https://www.gstatic.com/firebasejs/12.12.1/firebase-app.js";
import { getAuth, sendPasswordResetEmail } from "https://www.gstatic.com/firebasejs/12.12.1/firebase-auth.js";

<?php echoFirebaseJsConfig(); ?>

const app  = initializeApp(firebaseConfig);
const auth = getAuth(app);

window.sendReset = async function(e) {
  e.preventDefault();
  const email = document.getElementById('forgotEmail').value.trim();
  const btn   = document.getElementById('resetBtn');
  const box   = document.getElementById('authMsg');
  const span  = document.getElementById('authMsgText');

  if (!email) {
    box.className = 'auth-msg error show';
    span.textContent = 'Please enter your email address.';
    return;
  }

  btn.disabled = true;
  btn.innerHTML = '<span class="spinner-btn"></span> Sending…';

  try {
    await sendPasswordResetEmail(auth, email);
    box.className = 'auth-msg success show';
    span.textContent = '✅ Reset email sent! Check your inbox (and spam folder).';
    btn.textContent = 'Email sent ✓';
  } catch (err) {
    btn.disabled = false;
    btn.textContent = 'Send Reset Link';
    const messages = {
      'auth/user-not-found': 'No account found with this email.',
      'auth/invalid-email':  'Invalid email address.',
    };
    box.className = 'auth-msg error show';
    span.textContent = messages[err.code] || err.message;
  }
};
</script>
</body>
</html>
