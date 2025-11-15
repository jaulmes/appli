<?php

namespace App\Livewire;

use App\Models\Produit;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class FrontEndNosProduitView extends Component
{
    public $produits;

    public function mount()
    {
        $this->produits = Produit::with(['images', 'categori'])
                                    ->inRandomOrder()
                                    ->take(9)
                                    ->get();
    }

    public function addProductToCart($id)
    {
        $produit = Produit::where('id', $id)->first();
        $cart = session()->get('frontEndCart', []);

        if(isset($cart[$produit->id])){
            $cart[$produit->id]['quantity'] += 1;
        } else {
            $cart[$produit->id] = [
                'quantity' => 1,
                'id' => $produit->id,
                'name' => $produit->name,
                'image' => $this->getPriorityImage($produit),
                'price' => $produit->price,
                'prix_catalogue' => $produit->price,
                'prix_promo' => $produit->prix_promo,
                'status_promo' => $produit->status_promo
            ];
        }
        
        Session::put('frontEndCart', $cart);
        
        // Dispatcher les événements
        $this->dispatch('ProduitAjoute');
        $this->dispatch('addToCartProduct', [$id]);
    }

    // Méthode helper pour obtenir l'image prioritaire (GIF d'abord)
    public function getPriorityImage($produit)
    {
        // Nouvelle logique : plusieurs images
        if ($produit->images && $produit->images->count() > 0) {
            // Chercher un GIF en priorité
            $gifImage = $produit->images->firstWhere('is_gif', true);
            
            if ($gifImage) {
                return asset('images/produits/' . $gifImage->path);
            }
            
            // Sinon, prendre la première image
            return asset('images/produits/' . $produit->images->first()->path);
        }
        
        // Ancienne logique : image unique
        if ($produit->image_produit) {
            $oldPath1 = public_path('storage/images/produits/' . $produit->image_produit);
            $oldPath2 = public_path('images/produits/' . $produit->image_produit);
            
            if (file_exists($oldPath1)) {
                return asset('storage/images/produits/' . $produit->image_produit);
            } elseif (file_exists($oldPath2)) {
                return asset('images/produits/' . $produit->image_produit);
            }
        }
        
        // Image par défaut
        return asset('images/default-product.png');
    }

    // Vérifier si l'image affichée est un GIF
    public function isDisplayedImageGif($produit)
    {
        // Nouvelle logique
        if ($produit->images && $produit->images->count() > 0) {
            $gifImage = $produit->images->firstWhere('is_gif', true);
            return $gifImage !== null;
        }
        
        // Ancienne logique
        if ($produit->image_produit) {
            return strtolower(pathinfo($produit->image_produit, PATHINFO_EXTENSION)) === 'gif';
        }
        
        return false;
    }

    // Compter le nombre d'images
    public function getImageCount($produit)
    {
        if ($produit->images && $produit->images->count() > 0) {
            return $produit->images->count();
        }
        return $produit->image_produit ? 1 : 0;
    }

    public function render()
    {
        return view('livewire.front-end-nos-produit-view');
    }
}
