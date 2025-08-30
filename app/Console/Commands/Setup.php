<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup-jasaku';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
 public function handle()
    {
        $this->info('🚀 Gas Mulai Setup Cuyy');

        // 1. Install Dependensi JavaScript (NPM)
        $this->comment('Menjalankan npm install...');
        $npmProcess = Process::fromShellCommandline('npm install');
        $npmProcess->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });
        if (!$npmProcess->isSuccessful()) {
            $this->error('❌ NPM install gagal. Pastikan Node.js dan NPM terinstal.');
            return Command::FAILURE;
        }
        $this->info('✅ NPM install selesai.');

        $this->info('❗ Jangan lupa jalankan laragon atau xamppnya dulu sebelum menjalankan setup');
        $this->comment('Menjalankan migrasi database dan seeder...');
        Artisan::call('migrate:fresh', ['--seed' => true]);
        $this->info('✅ Migrasi dan seeder selesai.');

        // 2. Buat Symlink Storage
        $this->comment('Membuat symlink storage...');
        Artisan::call('storage:link');
        $this->info('✅ Symlink storage selesai dibuat.');

        // 3. Buat Key Aplikasi
        $this->comment('Membuat key aplikasi...');
        Artisan::call('key:generate');
        $this->info('✅ Key aplikasi selesai dibuat.');

        $this->info('🎉 Setup proyek selesai! ');
        $this->warn('--- CATATAN PENTING ---');
        $this->warn('Untuk menjalankan server pengembangan lokal:');
        $this->warn('1. Buka terminal lain dan jalankan: php artisan serve');
        $this->warn('2. Buka terminal baru dan jalankan: npm run dev');
        $this->warn('3. Buka terminal lain dan jalankan: php artisan reverb:start');
        $this->warn('4. Buka terminal lain dan jalankan: php artisan queue:work');
        $this->warn('Kemudian Anda bisa mengakses admin panel di http://127.0.0.1:8000/mitra.');
        $this->warn('Login dengan akun super admin yang telah dibuat');
        $this->warn('email: superadmin@gmail.com');
        $this->warn('password: superadminabis');

        return Command::SUCCESS;
    }
}
