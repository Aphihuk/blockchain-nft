<?php
// auth/register.php
session_start();
require_once __DIR__ . '/firebase-config.php';

// Already logged in → go to gallery
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
  <title>Create Account — NFT Gallery</title>
  <meta name="description" content="Create a free NFT Gallery account to view and manage your digital collectibles.">
  <link rel="stylesheet" href="/css/auth.css">
</head>
<body>
<main class="auth-page">

  <a href="/" class="auth-logo">NFT<span>.</span>Gallery</a>

  <div class="auth-card">
    <h1>Create account</h1>
    <p class="subtitle">Join the NFT Gallery — it's free</p>

    <!-- Message box -->
    <div class="auth-msg" id="authMsg">
      <span id="authMsgText"></span>
    </div>

    <!-- Google Sign-Up -->
    <button class="btn-google" id="googleBtn" onclick="signUpWithGoogle()">
      <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
        <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
        <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z" fill="#FBBC05"/>
        <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
      </svg>
      Sign up with Google
    </button>

    <div class="divider">or register with email</div>

    <!-- Registration form -->
    <form id="registerForm" onsubmit="registerEmail(event)" novalidate>

      <div class="form-group">
        <label for="regName">Display Name</label>
        <input type="text" id="regName" placeholder="Your Name" autocomplete="name" required>
      </div>

      <div class="form-group">
        <label for="regEmail">Email</label>
        <input type="email" id="regEmail" placeholder="you@example.com" autocomplete="email" required>
      </div>

      <div class="form-group">
        <label for="regPassword">Password</label>
        <div class="input-wrap">
          <input type="password" id="regPassword" placeholder="min. 8 characters"
                 autocomplete="new-password" required oninput="checkStrength(this.value)">
          <button type="button" class="toggle-pw" onclick="togglePw('regPassword',this)" aria-label="Show password">👁</button>
        </div>
        <!-- Strength bar -->
        <div class="pw-strength" id="pwStrength" style="display:none;">
          <div class="pw-strength-bar" id="pwStrengthBar"></div>
        </div>
      </div>

      <div class="form-group">
        <label for="regConfirm">Confirm Password</label>
        <div class="input-wrap">
          <input type="password" id="regConfirm" placeholder="••••••••"
                 autocomplete="new-password" required>
          <button type="button" class="toggle-pw" onclick="togglePw('regConfirm',this)" aria-label="Show password">👁</button>
        </div>
      </div>

      <button type="submit" class="btn-primary" id="registerBtn" style="margin-top:.5rem;">Create Account</button>
    </form>

    <p class="terms-text">
      By registering you agree to our
      <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.
    </p>

    <p class="auth-footer">Already have an account? <a href="/auth/login.php">Sign in</a></p>
  </div>

</main>

<script type="module">
import { initializeApp }                           from "https://www.gstatic.com/firebasejs/12.12.1/firebase-app.js";
import { getAuth, createUserWithEmailAndPassword,
         updateProfile,
         GoogleAuthProvider, signInWithPopup }     from "https://www.gstatic.com/firebasejs/12.12.1/firebase-auth.js";

<?php echoFirebaseJsConfig(); ?>

const app      = initializeApp(firebaseConfig);
const auth     = getAuth(app);
const provider = new GoogleAuthProvider();

// ── Helper: show message ─────────────────────
function showMsg(text, type = 'error') {
  const box  = document.getElementById('authMsg');
  const span = document.getElementById('authMsgText');
  box.className  = `auth-msg ${type} show`;
  span.textContent = text;
}

// ── Helper: set button state ─────────────────
function setLoading(loading) {
  const btn = document.getElementById('registerBtn');
  if (loading) {
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-btn"></span> Creating account…';
  } else {
    btn.disabled = false;
    btn.textContent = 'Create Account';
  }
}

// ── Verify token with PHP ────────────────────
async function verifyToken(idToken) {
  const res = await fetch('/auth/verify.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ idToken }),
  });
  return res.json();
}

// ── Email registration ────────────────────────
window.registerEmail = async function(e) {
  e.preventDefault();
  const name     = document.getElementById('regName').value.trim();
  const email    = document.getElementById('regEmail').value.trim();
  const password = document.getElementById('regPassword').value;
  const confirm  = document.getElementById('regConfirm').value;

  if (!name || !email || !password || !confirm) {
    showMsg('Please fill in all fields.'); return;
  }
  if (password.length < 8) {
    showMsg('Password must be at least 8 characters.'); return;
  }
  if (password !== confirm) {
    showMsg('Passwords do not match.'); return;
  }

  setLoading(true);
  try {
    const cred = await createUserWithEmailAndPassword(auth, email, password);
    await updateProfile(cred.user, { displayName: name });
    const idToken = await cred.user.getIdToken(true);
    const result  = await verifyToken(idToken);
    if (result.success) {
      showMsg('🎉 Account created! Redirecting…', 'success');
      setTimeout(() => { window.location.href = '/index.php'; }, 1000);
    } else {
      setLoading(false);
      showMsg('Account created but server session failed. Please sign in.');
    }
  } catch (err) {
    setLoading(false);
    const messages = {
      'auth/email-already-in-use': 'This email is already registered. <a href="/auth/login.php" style="color:var(--accent1)">Sign in instead?</a>',
      'auth/invalid-email':        'Invalid email address.',
      'auth/weak-password':        'Password is too weak. Use at least 8 characters.',
    };
    const box  = document.getElementById('authMsg');
    const span = document.getElementById('authMsgText');
    box.className = 'auth-msg error show';
    span.innerHTML = messages[err.code] || err.message;
  }
};

// ── Google Sign-Up ────────────────────────────
window.signUpWithGoogle = async function() {
  const btn = document.getElementById('googleBtn');
  btn.disabled = true;
  btn.textContent = 'Opening Google…';
  try {
    const cred    = await signInWithPopup(auth, provider);
    const idToken = await cred.user.getIdToken();
    const result  = await verifyToken(idToken);
    if (result.success) {
      window.location.href = '/index.php';
    } else {
      btn.disabled = false;
      btn.textContent = 'Sign up with Google';
      showMsg('Google sign-up succeeded but session failed. Please try again.');
    }
  } catch (err) {
    btn.disabled = false;
    btn.textContent = 'Sign up with Google';
    if (err.code !== 'auth/popup-closed-by-user') {
      showMsg('Google sign-up failed: ' + err.message);
    }
  }
};

// ── Toggle password visibility ────────────────
window.togglePw = function(inputId, btn) {
  const input = document.getElementById(inputId);
  if (input.type === 'password') { input.type = 'text'; btn.textContent = '🙈'; }
  else                           { input.type = 'password'; btn.textContent = '👁'; }
};

// ── Password strength meter ───────────────────
window.checkStrength = function(val) {
  const bar      = document.getElementById('pwStrengthBar');
  const wrap     = document.getElementById('pwStrength');
  wrap.style.display = val.length ? 'block' : 'none';
  let score = 0;
  if (val.length >= 8)              score++;
  if (/[A-Z]/.test(val))           score++;
  if (/[0-9]/.test(val))           score++;
  if (/[^A-Za-z0-9]/.test(val))   score++;

  const pct    = (score / 4) * 100;
  const colors = ['#f87171','#fb923c','#facc15','#34d399'];
  bar.style.width      = pct + '%';
  bar.style.background = colors[score - 1] || '#f87171';
};
</script>
</body>
</html>
