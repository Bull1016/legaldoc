<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CatalogueUpdate extends Seeder
{
    private function executeSeeder(string $seederName, callable $callback)
    {
        // Vérifie si le seeder a déjà été exécuté
        if (!DB::table('seeder_history')->where('seeder_name', $seederName)->exists()) {
            // Exécute le code du seeder
            $callback();

            // Enregistre l'exécution dans la table
            DB::table('seeder_history')->insert([
                'seeder_name' => $seederName,
                'executed_at' => now(),
            ]);

            $this->command->info("Seeder '$seederName' exécuté avec succès.");
        } else {
            $this->command->info("Seeder '$seederName' a déjà été exécuté, ignoré.");
        }
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'email' => 'superadmin@mail.com',
        ], [
            'name' => 'superadmin',
            'email' => 'superadmin@mail.com',
            'password' => bcrypt('mypasse'),
        ])->assignRole('superadmin');
    }
}
