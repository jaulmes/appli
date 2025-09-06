@extends('frontend.layout.index')

@section('content')
    <!-- Section Contact -->
    <section class="py-5 bg-light">
        <div class="container">
            <!-- Titre -->
            <div class="row mb-5 text-center">
                <div class="col-lg-8 mx-auto">
                    <h2 class="fw-bold display-6">Contactez-nous</h2>
                    <p class="text-muted fs-5">
                        Vous avez un projet ou une question ?  
                        L’équipe de <span class="fw-semibold text-success">Solergy Solutions SARL</span> est à votre écoute.
                    </p>
                </div>
            </div>

            <div class="row g-4 justify-content-center">
                <!-- Informations de contact -->
                <div class="col-md-6 col-lg-5">
                    <div class="card shadow-sm h-100 border-0 rounded-4">
                        <div class="card-body p-4">
                            <h5 class="fw-bold mb-4">Nos coordonnées</h5>
                            
                            <p class="mb-3">
                                <i class="bi bi-geo-alt-fill text-success me-2"></i>
                                <span>Douala, Cameroun</span>
                            </p>
                            <p class="mb-3">
                                <i class="bi bi-envelope-fill text-success me-2"></i>
                                <a href="mailto:solutionssolergy@gmail.com" class="text-decoration-none text-dark">
                                    solutionssolergy@gmail.com
                                </a>
                            </p>
                            <p class="mb-3">
                                <i class="bi bi-telephone-fill text-success me-2"></i>
                                <a href="https://wa.me/237657248925" class="text-decoration-none text-dark">
                                    +237 6 57 24 89 25
                                </a>
                            </p>
                            <p>
                                <i class="bi bi-clock-fill text-success me-2"></i>
                                Lun - Ven : 08h - 18h
                            </p>

                            <hr class="my-4">

                            <h6 class="fw-bold mb-3">Suivez-nous</h6>
                            <div class="d-flex gap-3 fs-4">
                                <a href="https://facebook.com/solergysolutions" class="text-success" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
                                <a href="#" class="text-success" aria-label="LinkedIn"><i class="bi bi-linkedin"></i></a>
                                <a href="#" class="text-success" aria-label="Twitter"><i class="bi bi-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Carte Google Maps -->
                <div class="col-md-6 col-lg-7">
                    <div class="card shadow-sm h-100 border-0 rounded-4">
                        <div class="card-body p-0">
                            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d527.0664342704274!2d9.735041197282555!3d4.046038743360167!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x10610d866a33e1ef%3A0x27fb21898bc44607!2sSOLERGY%20SOLUTIONS%20SARL!5e0!3m2!1sfr!2scm!4v1757043903008!5m2!1sfr!2scm" 
                                width="600" height="450" style="border:0;" 
                                allowfullscreen="" loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                                
                            </iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
