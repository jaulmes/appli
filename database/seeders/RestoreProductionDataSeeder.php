<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestoreProductionDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
echo "🔄 Début de l'import des données de production...\n\n";
        
        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            
            $sqlFile = base_path('backup_production.sql');
            
            if (!file_exists($sqlFile)) {
                throw new \Exception("❌ Le fichier {$sqlFile} n'existe pas");
            }
            
            echo "📁 Lecture du fichier SQL...\n";
            $sql = file_get_contents($sqlFile);
            
            // Nettoyer
            $sql = preg_replace('/DROP TABLE.*?;/is', '', $sql);
            $sql = preg_replace('/CREATE TABLE.*?ENGINE=\w+.*?;/is', '', $sql);
            $sql = preg_replace('/^--.*$/m', '', $sql); // Enlever commentaires
            
            // Séparer les requêtes INSERT
            $queries = explode(';', $sql);
            $queries = array_filter(array_map('trim', $queries));
            
            $success = 0;
            $errors = 0;
            
            foreach ($queries as $query) {
                if (empty($query) || stripos($query, 'INSERT INTO') === false) {
                    continue;
                }
                
                try {
                    DB::unprepared($query);
                    $success++;
                    
                    // Afficher la table importée
                    if (preg_match('/INSERT INTO `?(\w+)`?/i', $query, $matches)) {
                        echo "✅ {$matches[1]}\n";
                    }
                    
                } catch (\Exception $e) {
                    $errors++;
                    if (preg_match('/INSERT INTO `?(\w+)`?/i', $query, $matches)) {
                        echo "⚠️  Erreur pour {$matches[1]}: " . $e->getMessage() . "\n";
                    }
                }
            }
            
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            
            echo "\n✨ Import terminé!\n";
            echo "   ✅ Succès: $success insertions\n";
            echo "   ⚠️  Erreurs: $errors insertions\n";
            
        } catch (\Exception $e) {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            echo "\n❌ Erreur fatale: " . $e->getMessage() . "\n";
            throw $e;
        }
    }
}
