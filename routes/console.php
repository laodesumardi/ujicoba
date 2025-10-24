<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

use Illuminate\Support\Facades\File;

Artisan::command('storage:mirror {--fresh} {--only=}', function () {
    $sourceBase = storage_path('app/public');
    $targetBase = public_path('storage');

    if (!File::exists($sourceBase)) {
        $this->error('Sumber tidak ditemukan: ' . $sourceBase);
        return 1;
    }

    File::ensureDirectoryExists($targetBase);

    if ($this->option('fresh')) {
        $this->info('Membersihkan public/storage ...');
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
})->purpose('Mirror storage/app/public ke public/storage (fallback untuk storage:link).');
