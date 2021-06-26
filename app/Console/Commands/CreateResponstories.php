<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;
use File;

class CreateResponstories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'va:responstory {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tạo responstory cho model';


    /**
     * The path responsitory
     *
     * @var string
     */
    public $path_responsitory = "Console/Commands/forms/responsitory.txt";


    /**
     * The path responsitory eloquent
     *
     * @var string
     */
    public $path_responsitory_eloquent = "Console/Commands/forms/responsitory_eloquent.txt";


    /**
     * path_responsitory_eloquent
     *
     * @var string
     */
    public $path_form_route = "Console/Commands/forms/form_route.txt";

    /**
     * path_form_service
     *
     * @var string
     */
    public $path_form_service = "Console/Commands/forms/form_service.txt";


    /**
     * path_form_service
     *
     * @var string
     */
    public $path_form_controller = "Console/Commands/forms/form_controller.txt";


    /**
     * The path responsitory eloquent
     *
     * @var string
     */
    public $path_form_request = "Console/Commands/forms/form_request.txt";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $this->argument('name');
        $this->comment("Đang tạo responstory cho {$name} ....");
        if (! File::exists(app_path("Repositories"))) {
            File::makeDirectory(app_path("Repositories"));
        }
        $content = $this->getContextFileResponstory($name);
        File::put(app_path("Repositories/{$name}Repository.php"), $content);
        $contentEloquent = $this->getContextFileResponstoryEloquent($name);
        File::put(app_path("Repositories/{$name}RepositoryEloquent.php"), $contentEloquent);
        Artisan::call('make:bindings', ['name' => $name]);
        $this->comment("Create service to: " . app_path("Services/{$name}"));
        if (! File::exists(app_path("Services/{$name}"))) {
            File::makeDirectory(app_path("Services/{$name}"));
        }
        $this->info("Tạo thành công thư mục {$name} cho service");
        $contents = [
            [
                'type' => 'List',
                'content_function' => 'return $this->repository->all();'
            ],
            [
                'type' => 'Create',
                'content_function' => 'return $this->repository->create($request->all());'
            ],
            [
                'type' => 'Update',
                'content_function' => 'return $this->repository->update($request->all(), get_id_from_request($request));'
            ],
            [
                'type' => 'Delete',
                'content_function' => 'return $this->repository->delete(get_id_from_request($request));'
            ],
            [
                'type' => 'Detail',
                'content_function' => 'return $this->repository->findOrFail(get_id_from_request($request));'
            ]
        ];
        foreach($contents as $content_item) {
            $content = $this->getContentFileService($name, $content_item['type'], $content_item['content_function']);
            File::put(app_path("Services/{$name}/{$content_item['type']}Service.php"), $content);
            $this->info("Tạo thành công Service {$content_item['type']}Service.php");
        }

        $this->comment("Đang Tạo Validate Request Api: {$name}Request ....");
        if (! File::exists(app_path("Http/Requests/Api"))) {
            File::makeDirectory(app_path("Http/Requests/Api"));
        }
        $content = $this->getContentFileRequest($name);
        File::put(app_path("Http/Requests/Api/{$name}Request.php"), $content);
        $this->info("Tạo thành công Request Api {$name}Request.php");
        $this->comment("Đang Tạo Controller Api: {$name}Controller ....");

        if (! File::exists(app_path("Http/Controllers/Api"))) {
            File::makeDirectory(app_path("Http/Controllers/Api"));
        }

        $content = $this->getContentFileController($name);
        File::put(app_path("Http/Controllers/Api/{$name}Controller.php"), $content);
        $this->info("Tạo thành công Controller Api {$name}Controller.php");

        $content = $this->getContentFileRoute($name);
        File::put(base_path("routes/api.php"), $content);
        $this->info("Tạo thành công Route Api: {$name} Group");

    }

    /**
     * getContextFileResponstory
     *
     * @param  mixed $name
     * @return void
     */
    public function getContextFileResponstory($name)
    {
        $content = file_get_contents(app_path($this->path_responsitory));
        # Replace Name
        $content = str_replace('{$name}', $name, $content);
        return $content;
    }

    /**
     * getContextFileResponstoryEloquent
     *
     * @param  mixed $name
     * @return void
     */
    public function getContextFileResponstoryEloquent($name)
    {
        $content = file_get_contents(app_path($this->path_responsitory_eloquent));
        # Replace Name
        $content = str_replace('{$name}', $name, $content);
        return $content;
    }

    /**
     * getContentFileService
     *
     * @param  mixed $name
     * @param  mixed $type
     * @param  mixed $content_function
     * @return void
     */
    public function getContentFileService($name, $type, $content_function)
    {
        $content = file_get_contents(app_path($this->path_form_service));
        # Replace Name
        $content = str_replace('{$name}', $name, $content);
        // # Replace Type
        $content = str_replace('{$type}', $type, $content);
        // # Replace Handle Function
        $content = str_replace('{$content_function}', $content_function, $content);
        return $content;
    }


    /**
     * getContentFileRequest
     *
     * @param  mixed $name
     * @return void
     */
    public function getContentFileRequest($name)
    {
        $content = file_get_contents(app_path($this->path_form_request));
        $content = str_replace('{$name}', $name, $content);
        return $content;
    }

    /**
     * getContentFileController
     *
     * @param  mixed $name
     * @return void
     */
    public function getContentFileController($name)
    {
        $content = file_get_contents(app_path($this->path_form_controller));
        $content = str_replace('{$name}', $name, $content);

        return $content;
    }

    /**
     * getContentFileRoute
     *
     * @param  mixed $name
     * @return void
     */
    public function getContentFileRoute($name)
    {
        $content = file_get_contents(base_path("routes/api.php"));
        $content_replace = file_get_contents(app_path($this->path_form_route));
        $content_replace = str_replace('{$name}', $name, $content_replace);
        $content_replace = str_replace('{$name_strtoupper}', strtolower($name), $content_replace);
        $content = str_replace('#:end-routes-api-resource:#', $content_replace, $content);
        $content .= "\r\n";
        $content .= '#:end-routes-api-resource:#';
        return $content;
    }



}
