@extends('dashboard.main')

@section('content')

<div>
    <livewire:produit-livewire/>
</div>

@endsection

@section('javascript')
    <script>
        // Confirmation de suppression améliorée
        function confirmDelete(event) {
            event.preventDefault();
            const form = event.target.closest('form');
            
            const modal = new bootstrap.Modal(document.getElementById('deleteModal'));
            modal.show();
            
            document.getElementById('deleteForm').action = form.action;
        }
    </script>
    <style>
        /* Styles améliorés pour l'en-tête fixe */
        .table-responsive {
            scroll-padding-top: 45px; /* Hauteur de l'en-tête */
        }

        thead {
            backdrop-filter: blur(5px);
            box-shadow: 0 2px 15px rgba(0,0,0,0.1);
        }

        .table-hover tbody tr:hover {
            background-color: #f8fafc !important;
            transform: translateX(3px);
            transition: all 0.2s ease;
            position: relative;
            z-index: 0;
        }

        .img-thumbnail {
            object-fit: cover;
            padding: 0;
            border-radius: 8px;
        }

        .card-header {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            position: sticky;
            top: 0;
            z-index: 2;
        }

        @media (max-width: 768px) {
            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .table td, .table th {
                padding: 0.75rem;
                font-size: 0.9rem;
            }
            
            .btn-sm {
                padding: 0.25rem 0.5rem;
            }
            
            /* Adaptation mobile pour l'en-tête fixe */
            .table-responsive {
                max-height: 400px;
            }
        }
    </style>
@endsection