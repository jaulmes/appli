@extends('frontend.layout.index')

<!-- Meta Open Graph & product pour Facebook -->
@section('head')
    <!-- Balises Open Graph obligatoires -->
    <meta property="og:type" content="product" />
    <meta property="og:title" content="{{ $produit->name }}" />
    <meta property="og:description" content="{{ Str::limit($produit->description, 100) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:image" content="{{ $produit->getImageUrl() }}" />

    <!-- Balises produit spécifiques (Meta Commerce) -->
    <meta property="product:brand" content="{{ $produit->fabricant }}" />
    <meta property="product:availability" content="{{ 'in stock' }}" />
    <meta property="product:condition" content="new" />
    <meta property="product:price:amount" content="{{ $produit->status_promo ? $produit->prix_promo : $produit->price }}" />
    <meta property="product:price:currency" content="XAF" />
    <meta property="product:retailer_item_id" content="{{ $produit->id }}" />
    <meta property="product:item_group_id" content="{{ $produit->categori->id }}" />
    
    <!-- Optionnel : Catégorie structurée -->
    <meta property="product:category" content="{{ $produit->categori->titre }}" />
    
  <script>
    fbq('track', 'ViewContent', {
      content_ids: ['{{ $produit->id }}'],
      content_type: 'product',
    });
  </script>                     
@endsection

@section('content')
<div class="container py-5" style="margin-top: 10em;">
  <form action="{{ route('add-to-cart', $produit->id) }}" method="post">
    @csrf
    <div class="row">
        <div class="col-md-6">
          <div class="position-relative overflow-hidden image-zoom-container rounded shadow">
            <img src="{{$produit->getImageUrl() }}"
                  class="card-img-top img-fluid h-100"
                  alt="{{ $produit->name }}"
                  style="object-fit: cover;">
          </div>
        </div>

        <div class="col-md-6">
          <h1 class="fw-bold">{{ $produit->name }}</h1>
          
          <!-- Prix dynamique avec promotion -->
          <div class="row">
            <div class=" col mb-3">
              @if($produit->status_promo)
                <del class="text-muted me-2">{{ number_format($produit->price, 0, ',', ' ') }} FCFA</del>
                <span class="badge bg-success" style="font-size: x-large;">
                  {{ number_format($produit->prix_promo, 0, ',', ' ') }} FCFA
                </span>
              @else
                <span class="badge bg-success" style="font-size: x-large;">
                  {{ number_format($produit->price, 0, ',', ' ') }} FCFA
                </span>
              @endif
            </div>
            <!-- Actions d'achat (première instance) -->
            <div class=" col mb-3">
              @if($produit->stock > 0)
                <button type="submit" class="btn cta-button cta-primary animated-cta">
                  <span class="btn-content">
                    <i class="fas fa-cart-plus me-2"></i>
                    <span class="btn-text">Ajouter au panier</span>
                  </span>
                  <div class="btn-shine"></div>
                </button>
              @else
                <button type="submit" class="btn cta-button cta-reserve animated-cta">
                  <span class="btn-content">
                    <i class="fas fa-bolt me-2 pulse-icon"></i>
                    <span class="btn-text">Réserver maintenant</span>
                  </span>
                  <div class="btn-shine"></div>
                </button>
              @endif
            </div>
          </div>

          <!-- Description formatée -->
          <div class="mb-4 product-description">
            {!! str_replace(';', '<br>', e($produit->description)) !!}
          </div>

          <!-- Actions d'achat (deuxième instance - version élargie) -->
          <div class="d-flex gap-3 mb-4">
            @if($produit->stock > 0)
              <button type="submit" class="btn cta-button cta-primary animated-cta large-cta">
                <span class="btn-content">
                  <i class="fas fa-cart-plus me-2"></i>
                  <span class="btn-text">Ajouter au panier</span>
                </span>
                <div class="btn-shine"></div>
                <div class="success-ripple"></div>
              </button>
            @else
              <button type="submit" class="btn cta-button cta-reserve animated-cta large-cta">
                <span class="btn-content">
                  <i class="fas fa-bolt me-2 pulse-icon"></i>
                  <span class="btn-text">Réserver maintenant</span>
                </span>
                <div class="btn-shine"></div>
                <div class="urgent-glow"></div>
              </button>
            @endif
          </div>

          <!-- Métadonnées structurées -->
          <div class="mt-4 text-muted small">
            <div>
              <i class="fas fa-layer-group me-2"></i>Catégorie : {{ $produit->categori->titre }}
            </div>
          </div>
        </div>
    </div>
  </form>
</div>

<style>
  .image-zoom-container {
    transition: transform 0.3s;
    overflow: hidden;
    max-height: 500px;
  }

  .zoom-image {
    transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    min-height: 300px;
    object-position: center;
  }

  .product-description {
    line-height: 1.6;
    white-space: pre-line;
  }

  /* === STYLES DES BOUTONS CTA ANIMÉS === */
  .cta-button {
    position: relative;
    overflow: hidden;
    border: none;
    border-radius: 50px;
    padding: 12px 28px;
    font-weight: 600;
    font-size: 16px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    cursor: pointer;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    min-width: 200px;
    z-index: 1;
  }

  .large-cta {
    padding: 16px 35px;
    font-size: 18px;
    min-width: 250px;
  }

  .btn-content {
    position: relative;
    z-index: 3;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: transform 0.3s ease;
  }

  /* Bouton principal - Ajouter au panier */
  .cta-primary {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    color: white;
    animation: breathe 3s ease-in-out infinite;
  }

  .cta-primary:hover {
    background: linear-gradient(135deg, #20c997 0%, #17a2b8 100%);
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 15px 35px rgba(40, 167, 69, 0.4);
    color: white;
  }

  /* Bouton réservation */
  .cta-reserve {
    background: linear-gradient(135deg, #fd7e14 0%, #dc3545 100%);
    color: white;
    animation: urgentPulse 2s ease-in-out infinite;
  }

  .cta-reserve:hover {
    background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 15px 35px rgba(220, 53, 69, 0.4);
    color: white;
  }

  /* Animation de respiration pour le bouton principal */
  @keyframes breathe {
    0%, 100% { 
      transform: scale(1);
      box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    50% { 
      transform: scale(1.02);
      box-shadow: 0 12px 35px rgba(40, 167, 69, 0.25);
    }
  }

  /* Animation d'urgence pour réservation */
  @keyframes urgentPulse {
    0%, 100% { 
      transform: scale(1);
      box-shadow: 0 8px 25px rgba(220, 53, 69, 0.2);
    }
    25% { 
      transform: scale(1.03);
      box-shadow: 0 12px 35px rgba(220, 53, 69, 0.35);
    }
    75% { 
      transform: scale(1.01);
      box-shadow: 0 10px 30px rgba(220, 53, 69, 0.3);
    }
  }

  /* Effet de brillance */
  .btn-shine {
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
    transition: left 0.6s;
    z-index: 2;
  }

  .cta-button:hover .btn-shine {
    left: 100%;
  }

  /* Animation de l'icône panier */
  .cta-primary:hover .fa-cart-plus {
    animation: cartBounce 0.6s ease-in-out;
  }

  @keyframes cartBounce {
    0%, 100% { transform: scale(1) rotate(0deg); }
    25% { transform: scale(1.2) rotate(-5deg); }
    75% { transform: scale(1.1) rotate(5deg); }
  }

  /* Animation de l'icône éclair pour réservation */
  .pulse-icon {
    animation: iconPulse 1.5s ease-in-out infinite;
  }

  @keyframes iconPulse {
    0%, 100% { 
      transform: scale(1);
      color: rgba(255,255,255,1);
    }
    50% { 
      transform: scale(1.2);
      color: rgba(255,255,255,0.8);
      filter: drop-shadow(0 0 8px rgba(255,255,255,0.8));
    }
  }

  /* Effet de click - ondulation de succès */
  .success-ripple {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255,255,255,0.6);
    transform: translate(-50%, -50%);
    z-index: 1;
  }

  .cta-primary:active .success-ripple {
    animation: successRipple 0.8s ease-out;
  }

  @keyframes successRipple {
    0% {
      width: 0;
      height: 0;
      opacity: 1;
    }
    100% {
      width: 300px;
      height: 300px;
      opacity: 0;
    }
  }

  /* Lueur urgente pour réservation */
  .urgent-glow {
    position: absolute;
    top: -2px;
    left: -2px;
    right: -2px;
    bottom: -2px;
    border-radius: 50px;
    background: linear-gradient(45deg, #ff6b6b, #ee5a24, #ff6b6b, #ee5a24);
    background-size: 400% 400%;
    opacity: 0;
    z-index: -1;
    animation: urgentGlow 3s ease-in-out infinite;
  }

  @keyframes urgentGlow {
    0%, 100% { 
      opacity: 0;
      background-position: 0% 50%;
    }
    25% { 
      opacity: 0.3;
      background-position: 100% 50%;
    }
    75% { 
      opacity: 0.1;
      background-position: 0% 50%;
    }
  }

  /* Effet hover sur le texte */
  .cta-button:hover .btn-text {
    animation: textWiggle 0.5s ease-in-out;
  }

  @keyframes textWiggle {
    0%, 100% { transform: translateX(0); }
    25% { transform: translateX(-2px); }
    75% { transform: translateX(2px); }
  }

  /* Animation au focus (accessibilité) */
  .cta-button:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.3);
    animation: focusGlow 1s ease-in-out infinite alternate;
  }

  .cta-reserve:focus {
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.3);
  }

  @keyframes focusGlow {
    0% { box-shadow: 0 0 0 3px rgba(40, 167, 69, 0.3); }
    100% { box-shadow: 0 0 0 5px rgba(40, 167, 69, 0.1); }
  }

  /* États désactivé */
  .cta-button:disabled {
    opacity: 0.6;
    cursor: not-allowed;
    animation: none;
  }

  .cta-button:disabled:hover {
    transform: none;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
  }

  /* Responsive */
  @media (max-width: 768px) {
    .container {
      margin-top: 5em !important;
    }
    
    .image-zoom-container {
      max-height: 300px;
    }

    .cta-button {
      padding: 10px 20px;
      font-size: 14px;
      min-width: 180px;
    }

    .large-cta {
      padding: 14px 25px;
      font-size: 16px;
      min-width: 200px;
    }

    /* Réduire les animations sur mobile pour les performances */
    .cta-button {
      animation-duration: 4s;
    }
  }

  /* Animation d'entrée pour les boutons */
  .animated-cta {
    animation-delay: 0.3s;
    animation-fill-mode: both;
  }

  @keyframes fadeInUp {
    from {
      opacity: 0;
      transform: translateY(30px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .animated-cta {
    animation: fadeInUp 0.6s ease-out, breathe 3s ease-in-out infinite 1s;
  }

  .cta-reserve.animated-cta {
    animation: fadeInUp 0.6s ease-out, urgentPulse 2s ease-in-out infinite 1s;
  }
</style>
@endsection