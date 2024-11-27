<?php

namespace App\Console\Commands;

use App\Models\Permission;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class GeneratePermissions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    // protected $signature = 'command:name';
    protected $signature = 'permissions:generate';
    protected $description = 'Generate permissions for all tables in the database';
    /**
     * The console command description.
     *
     * @var string
     */
    // protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // return Command::SUCCESS;

        // $modelPath = app_path('Models');

        // // Ensure the path exists
        // if (!File::isDirectory($modelPath)) {
        //     $this->error("The models directory does not exist at: {$modelPath}");
        //     return;
        // }

        // $modelFiles = File::allFiles($modelPath);

        // $models = [];
        // foreach ($modelFiles as $file) {
        //     // Get the model class name based on the file name
        //     $modelName = 'App\\Models\\' . $file->getFilenameWithoutExtension();

        //     // Ensure the class exists and is a subclass of Eloquent Model
        //     if (class_exists($modelName) && is_subclass_of($modelName, 'Illuminate\Database\Eloquent\Model')) {
        //         $models[] = $modelName;
        //     }
        // }

        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();
        // $modelFiles = File::allFiles($modelPath);
        $actions = ['view', 'create', 'update', 'delete','show'];
        // $actions_ar = ['عرض', 'انشاء', 'تعديل', 'مسح'];

        foreach ($tables as $table) {
            $p= Permission::firstOrCreate([
                'title_ar' => $table,
                'title_en' => $table,
                'parent_id' => null,
                'created_by' =>Auth::user()->id ?? null,
                'updated_by' =>Auth::user()->id ?? null,
            ]);
            foreach ($actions as $action) {
                Permission::firstOrCreate([
                    'title_ar' => $action,
                    'title_en' => $action,
                    'parent_id' => $p->id,
                    'created_by' =>Auth::user()->id ?? null,
                    'updated_by' =>Auth::user()->id ?? null,
                ]);
            }
        }

        $this->info('Permissions generated for all tables.');
    }
}
