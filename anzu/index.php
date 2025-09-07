<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login & Sign Up</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css">
    <style>
        body {
            background-color: #f5f5f5;
            display: flex;
            min-height: 100vh;
            flex-direction: column;
        }
        main {
            flex: 1 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 450px;
            margin: 2rem 0;
        }
        .card .card-tabs {
            border-bottom: 1px solid #e0e0e0;
        }
        .card .card-content {
            padding-top: 24px;
        }
        .oauth-buttons {
            margin-top: 20px;
            text-align: center;
        }
        .oauth-buttons .btn {
            width: 100%;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-transform: none; /* Keep original casing */
        }
        .oauth-buttons .btn img {
            width: 20px;
            margin-right: 15px;
        }
        /* Color classes for OAuth buttons */
        .btn-google { background-color: #DB4437 !important; }
        .btn-facebook { background-color: #1877F2 !important; }

        .divider-container {
            display: flex;
            align-items: center;
            text-align: center;
            color: #9e9e9e;
            margin: 20px 0;
        }
        .divider-container::before,
        .divider-container::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e0e0e0;
        }
        .divider-container:not(:empty)::before { margin-right: .5em; }
        .divider-container:not(:empty)::after { margin-left: .5em; }
        .forgot-password {
            text-align: right;
            margin-top: -15px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <main>
        <div class="login-card">
            <div class="card">
                <div class="card-tabs">
                    <ul class="tabs tabs-fixed-width">
                        <li class="tab"><a class="active" href="#login">Login</a></li>
                        <li class="tab"><a href="#signup">Sign Up</a></li>
                    </ul>
                </div>
                <div class="card-content">
                    <div id="login">
                        <form action="auth/login.php" method="POST">
                            <div class="input-field">
                                <i class="material-icons prefix">email</i>
                                <input id="login_email" type="email" name="email" class="validate" required>
                                <label for="login_email">Email</label>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">lock</i>
                                <input id="login_password" type="password" name="password" class="validate" required>
                                <label for="login_password">Password</label>
                            </div>
                            <div class="forgot-password">
                                <a href="#modal-forgot-password" class="modal-trigger">Forgot Password?</a>
                            </div>
                            <button class="btn waves-effect waves-light col s12" type="submit" style="width:100%;">Login</button>
                        </form>
                    </div>
                    <div id="signup">
                        <form action="auth/signup.php" method="POST">
                             <div class="input-field">
                                <i class="material-icons prefix">account_circle</i>
                                <input id="signup_name" type="text" name="name" class="validate" required>
                                <label for="signup_name">Full Name</label>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">email</i>
                                <input id="signup_email" type="email" name="email" class="validate" required>
                                <label for="signup_email">Email</label>
                            </div>
                            <div class="input-field">
                                <i class="material-icons prefix">lock</i>
                                <input id="signup_password" type="password" name="password" class="validate" required>
                                <label for="signup_password">Password</label>
                            </div>
                            <button class="btn waves-effect waves-light col s12" type="submit" style="width:100%;">Sign Up</button>
                        </form>
                    </div>

                    <div class="divider-container">OR</div>
                    <div class="oauth-buttons">
                        <a href="auth/oauth.php?provider=Google" class="btn waves-effect waves-light btn-google">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google logo">
                            Sign in with Google
                        </a>
                         <a href="auth/oauth.php?provider=Facebook" class="btn waves-effect waves-light btn-facebook">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/f/fb/Facebook_icon_2013.svg" alt="Facebook logo">
                            Sign in with Facebook
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <div id="modal-forgot-password" class="modal">
        <form action="auth/forgot_password.php" method="POST">
            <div class="modal-content">
                <h4>Reset Password</h4>
                <p>Enter the email address associated with your account, and we'll send you a link to reset your password.</p>
                 <div class="input-field">
                    <i class="material-icons prefix">email</i>
                    <input id="forgot_email" type="email" name="email" class="validate" required>
                    <label for="forgot_email">Email</label>
                </div>
            </div>
            <div class="modal-footer">
                <a href="#!" class="modal-close waves-effect waves-green btn-flat">Cancel</a>
                <button type="submit" class="waves-effect waves-green btn">Send Reset Link</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <script>
        // Initialize Materialize components
        document.addEventListener('DOMContentLoaded', function() {
            var tabs = document.querySelectorAll('.tabs');
            M.Tabs.init(tabs);

            var modals = document.querySelectorAll('.modal');
            M.Modal.init(modals);
        });
    </script>
</body>
</html>