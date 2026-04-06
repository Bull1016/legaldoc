<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
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
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->executeSeeder('UsersSeeder', function () {
        //     User::factory(10)->create();
        // });
    }
}
