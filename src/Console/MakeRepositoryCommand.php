<?php

namespace Zentnova\Repository\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;

class MakeRepositoryCommand extends Command
{
    protected $signature = 'make:repository {name} {--model=} {--empty} {--test} {--path=app/Repositories}';
    protected $description = 'Generate a new repository class with an optional model and test files';

    public function handle()
    {
        $name = $this->argument('name');
        $className = Str::studly($name);
        $modelName = $this->option('model')
            ? Str::studly($this->option('model'))
            : str_replace('Repository', '', $className);

        $stubFile = $this->option('empty')
            ? 'repository.empty.stub'
            : 'repository.stub';

        $path = base_path($this->option('path') . "/{$className}.php");

        if (file_exists($path)) {
            $this->error("Repository {$className} already exists!");
            return;
        }

        // โหลดไฟล์ stub จาก package หรือจาก publish
        $stubPath = base_path("stubs/zentnova-repository/{$stubFile}");
        if (!file_exists($stubPath)) {
            $stubPath = __DIR__ . "/../../stubs/{$stubFile}";
        }

        if (!file_exists($stubPath)) {
            $this->warn("⚠️ Stub file not found: {$stubPath}");
            return;
        }

        $stub = file_get_contents($stubPath);
        $stub = str_replace('{{className}}', $className, $stub);
        $stub = str_replace('{{modelName}}', $modelName, $stub);

        (new Filesystem)->ensureDirectoryExists(base_path($this->option('path')));
        file_put_contents($path, $stub);

        $this->info("\n ✅ Repository: {$className} created successfully!");

        if ($this->option('test')) {
            $this->createPestTest($className, $modelName);
        }
    }

    protected function createPestTest($className, $modelName)
    {
        $testPath = base_path("tests/Feature/Repositories/{$className}Test.php");

        if (file_exists($testPath)) {
            $this->warn("⚠️ Test file {$className}Test.php already exists!");
            return;
        }

        $stubPath = __DIR__ . "/../../stubs/tests/repository.pest.stub";
        if (!file_exists($stubPath)) {
            $this->warn("⚠️ Stub file for Pest test not found: {$stubPath}");
            return;
        }

        $stub = file_get_contents($stubPath);
        $stub = str_replace('{{className}}', $className, $stub);
        $stub = str_replace('{{modelName}}', $modelName, $stub);

        (new Filesystem)->ensureDirectoryExists(base_path('tests/Feature/Repositories'));
        file_put_contents($testPath, $stub);

        $this->info("\n ✅ Pest test for {$className} created successfully!");
    }
}
