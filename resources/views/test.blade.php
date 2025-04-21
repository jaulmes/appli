<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Confirmation de commande</title>
  <!-- Bootstrap CSS (pour les classes utilitaires) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* 1. Overlay pleine page */
    .overlay {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      backdrop-filter: blur(8px);
      background: rgba(0, 0, 0, 0.3); /* teinte pour contraste */
      display: flex;
      align-items: center;
      justify-content: center;
      z-index: 1050; /* au-dessus du contenu */
    }
    /* 2. Conteneur central */
    .overlay-content {
      background: #fff;
      border-radius: 12px;
      padding: 2rem;
      max-width: 500px;
      width: 90%;
      text-align: center;
      box-shadow: 0 8px 24px rgba(0,0,0,0.2);
      animation: slide-down 0.5s ease-out;
    }
    /* 3. Animation d'arrivée */
    @keyframes slide-down {
      from { transform: translateY(-30px); opacity: 0; }
      to   { transform: translateY(0);    opacity: 1; }
    }
    /* 4. Animation de coche */
    .checkmark {
      width: 100px; height: 100px;
      margin: 0 auto 1.5rem;
      stroke: #28a745; stroke-width: 4; fill: none;
      animation: pop 0.6s ease-out forwards;
    }
    .checkmark__circle {
      stroke-dasharray: 166; stroke-dashoffset: 166;
      animation: draw-circle 0.6s ease-out forwards;
    }
    .checkmark__check {
      stroke-dasharray: 48; stroke-dashoffset: 48;
      animation: draw-check 0.4s ease-out 0.6s forwards;
    }
    @keyframes draw-circle { to { stroke-dashoffset: 0; } }
    @keyframes draw-check  { to { stroke-dashoffset: 0; } }
    @keyframes pop {
      0%   { transform: scale(0.5); opacity: 0; }
      60%  { transform: scale(1.2); opacity: 1; }
      100% { transform: scale(1); }
    }
    /* 5. Groupe de boutons moderne */
    .btn-group-custom {
      display: flex;
      gap: 1rem;
      flex-wrap: wrap;
      justify-content: center;
      margin-top: 1.5rem;
    }
    .btn-group-custom .btn {
      flex: 1 1 120px;
      border-radius: 50px;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    .btn-group-custom .btn:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 18px rgba(0,0,0,0.15);
    }
  </style>
</head>
<body>
  <!-- Overlay activé : placez ceci dynamiquement selon votre logique -->
  <div class="overlay">
    <div class="overlay-content">
      <!-- Message de succès -->
      <h2 class="text-success fw-semibold mb-3">Commande passée avec succès !</h2>
      <!-- Animation SVG -->
      <svg class="checkmark" viewBox="0 0 52 52">
        <circle class="checkmark__circle" cx="26" cy="26" r="25"/>
        <path class="checkmark__check" d="M14 27 l7 7 l17 -17"/>
      </svg>
      <!-- Boutons -->
      <div class="btn-group-custom">
        <a href="/" class="btn btn-outline-secondary">
          <i class="fa fa-home"></i> Accueil
        </a>
        <a href="/commande/123456" class="btn btn-outline-info">
          <i class="fa fa-file-alt"></i> Voir détails
        </a>
        <a href="/telecharger/commande/123456" class="btn btn-outline-success">
          <i class="fa fa-download"></i> Télécharger
        </a>
      </div>
    </div>
  </div>

  <!-- (Optionnel) Font Awesome pour les icônes -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/js/all.min.js"></script>
</body>
</html>
