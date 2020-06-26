<?php

namespace Modules\Blog\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Blog\Entities\Post;

class PostTableSeeder extends Seeder
{
    use \TruncateTable, \DisableForeignKeys;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        $this->truncate('posts');

        factory(Post::class, 10)->create();

        $this->enableForeignKeys();
    }
}
