<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class StorageMirrorCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'storage:mirror {--fresh : Bersihkan public/storage sebelum copy} {--only= : Mirror hanya subfolder, mis. home-sections atau school-profiles}';

    /**
     * The console command description.
     */
    protected $description = 'Mirror storage/app/public ke public/storage sebagai fallback jika symlink tidak tersedia (storage:link gagal).';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $sourceBase = storage_path('app/public');
        $targetBase = public_path('storage');

        if (!File::exists($sourceBase)) {
            $this->error('Sumber tidak ditemukan: ' . $sourceBase);
            return 1;
        }

        // Pastikan direktori target ada
        File::ensureDirectoryExists($targetBase);

        // Jika --fresh, bersihkan target terlebih dahulu
        if ($this->option('fresh')) {
            $this->info('Membersihkan public/storage ...');
            // Hapus isi target (tanpa menghapus direktori itu sendiri untuk keamanan)
            foreach (File::directories($targetBase) as $dir) {
                File::deleteDirectory($dir);
            }
            foreach (File::files($targetBase) as $file) {
                File::delete($file);
            }
        }

        $only = $this->option('only');
        if ($only) {
            $src = $sourceBase . DIRECTORY_SEPARATOR . $only;
            $dst = $targetBase . DIRECTORY_SEPARATOR . $only;

            if (!File::exists($src)) {
                $this->error("Subfolder sumber tidak ada: {$src}");
                return 1;
            }

            File::ensureDirectoryExists(dirname($dst));
            $this->info("Menyalin {$src} -> {$dst}");
            File::copyDirectory($src, $dst);
        } else {
            $this->info("Menyalin seluruh {$sourceBase} -> {$targetBase}");
            File::copyDirectory($sourceBase, $targetBase);
        }

        $this->info('Mirror selesai.');
        return 0;
    }
}