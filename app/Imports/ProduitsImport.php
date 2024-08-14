<?php

namespace App\Imports;

use App\Models\Produit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProduitsImport implements ToModel, SkipsEmptyRows, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


    public function model(array $row)
    {
        return new Produit([
            'titre' => $row[0],
            'categori_id' => $row[1],
            'description' => $row[2],
            'prix_achat' => $row[3],
            'prix_vente' => $row[4],
            'prix_technicien' => $row[5],
            'prix_minimum' => $row[6],
            'stock' => $row[7],
            'image_produit' => $row[8],
        ]);
    }

    
    
    public function rules(): array
    {
        return [
            'prix_achat' =>
                'integer',
    
            'prix_vente' => 
                
                'integer',
         
            'prix_technicien' => 
                
                'integer',
          
            'prix_minimum' => 
                
                'integer',
          
            'stock' =>
                'integer',
         
        ];
    }
}
