<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Illuminate\Support\Facades\File;

class TranslateMessages extends Command
{
    protected $signature = 'translate:messages {to}';
    protected $description = 'Terjemahkan messages.php ke bahasa lain (ex: en, pt, fr)';

    public function handle()
    {
        $toLang = $this->argument('to');
        $fromLang = 'id';

        $sourcePath = resource_path("lang/{$fromLang}/messages.php");
        $targetPath = resource_path("lang/{$toLang}/messages.php");

        if (!File::exists($sourcePath)) {
            $this->error("File source tidak ditemukan: {$sourcePath}");
            return;
        }

        $messages = include $sourcePath;
        $translated = [];

        $this->info("Menerjemahkan ke bahasa: {$toLang}...");

        $translator = new GoogleTranslate($toLang, $fromLang);

        foreach ($messages as $key => $value) {
            try {
                $translated[$key] = $translator->translate($value);
                $this->info("✔ {$value} → {$translated[$key]}");
                usleep(100000); // delay biar gak ke-ban
            } catch (\Exception $e) {
                $this->error("✖ Gagal translate '{$value}': " . $e->getMessage());
                $translated[$key] = $value; // fallback
            }
        }

        $phpCode = "<?php\n\nreturn [\n";
        foreach ($translated as $key => $val) {
            $val = addslashes($val);
            $phpCode .= "    '{$key}' => '{$val}',\n";
        }
        $phpCode .= "];\n";

        File::ensureDirectoryExists(dirname($targetPath));
        File::put($targetPath, $phpCode);

        $this->info("✅ Terjemahan berhasil disimpan di: {$targetPath}");
    }
}
