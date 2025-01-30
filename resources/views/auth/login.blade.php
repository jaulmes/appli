<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background-color: #f8f9fa; /* Couleur de fond moderne */
            height: 100vh;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
            padding: 20px;
        }
        .login-card {
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .login-card .card-body {
            padding: 30px;
        }
        .login-btn {
            width: 100%;
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
        }
        .logo {
            max-width: 150px;
        }
    </style>
</head>
<body class="d-flex justify-content-center align-items-center">

    <div class="login-container">
        <div class="text-center">
            <img src="{{ asset('logo.jpg') }}" alt="Logo" class="logo mb-3">
        </div>
        <div class="card login-card">
            <div class="card-body">
                <h4 class="text-center mb-4">Connexion</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Votre email..." required autofocus autocomplete="email">
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Votre mot de passe..." required autocomplete="current-password">
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary login-btn">Se connecter</button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>
