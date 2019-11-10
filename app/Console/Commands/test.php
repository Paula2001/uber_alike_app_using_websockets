<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Libraries\BinaryTree\BinaryTree;
class test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:test';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return mixed
     */
    public function handle()
    {
        $tree = new BinaryTree();
        $tree->insert(1 ,"id_1");
        $tree->insert(3,"id_2");
        $tree->insert(10,"id_2");
        $tree->insert(2,"id_3");
        $tree->display_tree($tree->find(3));
//        $tree->display();
    }
}
