<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>passer la commande</title>
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{asset('frontend-assets/lib/lightbox/css/lightbox.min.css')}}" rel="stylesheet">
    <link href="{{ asset('frontend-assets/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{asset('frontend-assets/css/bootstrap.min.css')}}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('frontend-assets/css/style.css')}}" rel="stylesheet">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="../favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../favicon/favicon-16x16.png">
    <link rel="manifest" href="../favicon/site.webmanifest">
    <meta name="theme-color" content="#ffffff">


</head>

<body>
    <div class="container">
        <div class="py-5 text-center">
            <img class="d-block mx-auto mb-4" src="{{ asset('logo.jpg') }}" alt="" width="72" height="72">
            <h2>Formulaire de commande</h2>
            <p class="lead">Remplissez le formulaire ci-dessous pour passer votre commande.</p>
        </div>
        <div class="row">
            <!-- Order Summary -->
            <div class="col-md-4 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Votre panier</span>
                    <span class="badge badge-secondary badge-pill">{{ count($cart) }}</span>
                </h4>
                <ul class="list-group mb-3 sticky-top">
                    @foreach($cart as $item)
                    <li class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h6 class="my-0">{{ $item['name'] }}</h6>
                            @if($item['status_promo'] == 0)
                                <small class="text-muted">
                                    {{ $item['quantity'] }} x {{ number_format($item['price']) }}
                                </small>
                            @else
                                <small class="text-muted">
                                    {{ $item['quantity'] }} x {{ number_format($item['prix_promo']) }}
                                </small>
                            @endif
                        </div>
                        <span class="text-muted">
                            @if($item['status_promo'] == 0)
                                {{ number_format($item['quantity'] * $item['price'],0,',',' ') }} FCFA
                            @else
                                {{ number_format($item['quantity'] * $item['prix_promo'],0,',',' ') }} FCFA
                            @endif
                        </span>
                    </li>
                    @endforeach
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total</span>
                        <strong>{{ number_format($montantTotal,0,',',' ') }} FCFA</strong>
                    </li>
                </ul>
            </div>
            <!-- Billing Form -->
            <div class="col-lg-8">
                <div class="card checkout-card shadow-sm border-0">
                    <div class="card-header bg-white border-0 py-3">
                        <h4 class="mb-0 fw-bold text-primary">
                            <i class="fas fa-address-card me-2"></i>Adresse de facturation
                        </h4>
                    </div>

                    <div class="card-body">
                        <form class="needs-validation" novalidate method="POST" action=" {{ route('valider.commande')}}">
                            @csrf

                            <!-- Nom et Prénom -->
                            <div class="row g-3 mb-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text"
                                            class="form-control rounded-3 @error('name') is-invalid @enderror"
                                            id="name"
                                            name="name"
                                            value="{{ old('name') }}"
                                            placeholder=" "
                                            required>
                                        <label for="name">Nom</label>
                                        <div class="invalid-feedback">
                                            @error('name') {{ $message }} @else name requis @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number"
                                            class="form-control rounded-3 @error('numero') is-invalid @enderror"
                                            id="numero"
                                            name="numero"
                                            value="{{ old('numero') }}"
                                            placeholder=" "
                                            required>
                                        <label for="numero">Numero</label>
                                        <div class="invalid-feedback">
                                            @error('numero') {{ $message }} @else numero requis @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="email"
                                        class="form-control rounded-3 @error('email') is-invalid @enderror"
                                        id="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        placeholder=" ">
                                    <label for="email">Email <span class="text-muted">(Optionnel)</span></label>
                                    <div class="invalid-feedback">
                                        @error('email') {{ $message }} @else Adresse email invalide @enderror
                                    </div>
                                </div>
                                <small class="text-muted ms-2">Pour recevoir votre facture</small>
                            </div>

                            <!-- Adresse -->
                            <div class="mb-4">
                                <div class="form-floating">
                                    <input type="text"
                                        class="form-control rounded-3 @error('address') is-invalid @enderror"
                                        id="address"
                                        name="address"
                                        value="{{ old('address') }}"
                                        placeholder=" "
                                        required>
                                    <label for="address">Adresse complète</label>
                                    <div class="invalid-feedback">
                                        @error('address') {{ $message }} @else Adresse requise @enderror
                                    </div>
                                </div>
                                <small class="text-muted ms-2">Ex: ESG, pk8, Douala</small>
                            </div>

                            <!-- Bouton de soumission -->
                            <div class="d-grid mt-5">
                                <button id="addToCartButton" class="btn btn-primary btn-lg py-3 fw-bold rounded-3"
                                    type="submit"
                                    id="submitBtn">
                                    <span class="submit-text">Valider la commande</span>
                                    <span class="spinner-border spinner-border-sm ms-2 d-none"
                                        role="status"
                                        aria-hidden="true"></span>
                                </button>
                                <!-- Facebook Pixel Event -->
                                <script type="text/javascript">
                                    document.getElementById('addToCartButton').addEventListener('click', function() {
                                        fbq('track', 'Purchase');
                                    }, false);
                                </script>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <style>
                .checkout-card {
                    border-radius: 16px;
                    overflow: hidden;
                    transition: transform 0.3s ease;
                }

                .checkout-card:hover {
                    transform: translateY(-5px);
                    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
                }

                .form-control {
                    transition: all 0.3s;
                    border: 1px solid #dee2e6;
                    padding: 1rem;
                }

                .form-control:focus {
                    border-color: #0d6efd;
                    box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.15);
                }

                .form-floating>label {
                    padding: 1rem;
                }

                #submitBtn:hover {
                    transform: translateY(-2px);
                }
            </style>

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const form = document.querySelector('.needs-validation');
                    const submitBtn = document.getElementById('submitBtn');

                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault();
                            event.stopPropagation();
                        } else {
                            // Show loading state
                            submitBtn.querySelector('.submit-text').textContent = 'Traitement...';
                            submitBtn.querySelector('.spinner-border').classList.remove('d-none');
                            submitBtn.disabled = true;
                        }

                        form.classList.add('was-validated');
                    }, false);

                    // Animation for invalid fields
                    document.querySelectorAll('.is-invalid').forEach(el => {
                        el.addEventListener('input', function() {
                            if (this.checkValidity()) {
                                this.classList.remove('is-invalid');
                            }
                        });
                    });
                });
            </script>
        </div>
        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">© {{ date('Y') }} Solergy Solution Sarl</p>
            <ul class="list-inline">
                <li class="list-inline-item"><a href="#">Privacy</a></li>
                <li class="list-inline-item"><a href="#">Terms</a></li>
                <li class="list-inline-item"><a href="#">Support</a></li>
            </ul>
        </footer>
    </div>
</body>

</html>