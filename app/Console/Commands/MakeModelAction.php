<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Artisan;
use File;

class MakeModelAction extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'va:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Thực hiện cập nhật model và các mối quan hệ trong model';

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
        $this->comment("Thực hiện cập nhật model và các mối quan hệ trong model");
        Artisan::call("code:models");
        $this->comment("Thực hiện thay đổi Model User");
        $content_user_model = file_get_contents(base_path("app/Models/User.php"));
        $content_user_model = str_replace('Illuminate\Database\Eloquent\Model', 'App\Models\Authencation as Model', $content_user_model);
        File::put(base_path("app/Models/User.php"), $content_user_model);
        $this->info("Thực hiện hành động thành công");
    }
}
