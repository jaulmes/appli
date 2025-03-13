<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Produit extends Model
{
    use HasFactory;
    protected $fillable = [
        'description',
        'name',
        'prix_achat',
        'price',
        'prix_technicien',
        'prix_minimum',
        'stock',
        'categori_id',
        'fabricant',
        'image_produit'
    ];

    public function categori(){
        return $this->belongsTo(Categori::class);
    }

    public function achats(): BelongsToMany
    {
        return $this->belongsToMany(Achat::class, 'produit_achat')
                                            ->withPivot('quantity', 'price');
    }

    
    public function ventes(): BelongsToMany
    {
        return $this->belongsToMany(Vente::class, 'produit_vente')
                                        ->withPivot('quantity', 'price');
    }

    public function proformats(): BelongsToMany
    {
        return $this->belongsToMany(Proformat::class, 'produit_proformats')
                                        ->withPivot('quantity', 'price');
    }

    public function installations(): BelongsToMany
    {
        return $this->belongsToMany(Installation::class, 'installation_produit')
                                        ->withPivot('quantity');
    }

    public function fournisseurs(): BelongsToMany
    {
        return $this->belongsToMany(Fournisseur::class, 'fournisseur_produit')
                                        ->withPivot('price');
    }

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'produit_transaction')
                    ->withPivot('quantity', 'price', 'name');
    }

    public function getPrice(){
        $prix = $this->price;

        return number_format($prix, 0, ',', ' ') . '   Francs CFA';
    }
    
    public function getPrixAchat(){
        $prix = $this->prix_achat;

        return number_format($prix, 0, ',', ' ') . '   Francs CFA';
    }

    public function getDescription()
    {
        $name= $this->description;
        $maxLength = 20; 
        if (strlen($name) > $maxLength) {
            return substr($name, 0, $maxLength) . '...'; 
        } else {
            return $name; 
        }
    }

    public function getStock(){
        $stock = $this->stock;
        if($stock <=0){
            return 'indisponible';
        }
        else{
            return 'disponible';
        }
    }

    public function getAlert(){

        $stock = $this->stock;
        if($stock <=5){
            return 'alert';
        }
    }
}
