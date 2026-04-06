<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class FullUpdate extends Command
{
  /**
   * The name and signature of the console command.
   *
   * @var string
   */
  protected $signature = 'full_update {message : Commit message}';

  /**
   * The console command description.
   *
   * @var string
   */
  protected $description = 'Perform all update tasks.';

  /**
   * Execute the console command.
   *
   * @return int
   */
  public function handle()
  {
    $message = $this->argument('message');

    $this->info('***** Please Wait for the Full Update. *****');

    $this->line('Updating Git repository...');
    exec('git add .');
    exec('git pull');
    exec('git commit -m "' . addslashes($message) . '"');
    exec('git push');

    DB::beginTransaction();
    try {
      $this->line('Updating Composer repository...');
      exec('composer install');

      $this->line('Running migrations (force)...');
      Artisan::call('migrate', ['--force' => true]);

      $this->line('Create and Update permissions...');
      create_update_permissions();

      $this->line('Seeding database (force)...');
      Artisan::call('db:seed', ['--class' => 'CatalogueUpdate', '--force' => true]);

      DB::commit();

      $this->line('Clearing application cache...');
      Artisan::call('optimize:clear');

      $this->info('***** Full Update completed. *****');
    } catch (\Throwable $th) {
      DB::rollBack();
      $this->line($th->getMessage());
      $this->line('***** Full Update failed... *****');
    }

    return 0;
  }
}
