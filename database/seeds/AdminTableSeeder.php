<?php
use Illuminate\Database\Seeder;
use App\Models\Admin;

class AdminTableSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data[] = factory(Admin::class)->states('admin_default')->make()->setHidden([])->toArray();
        Admin::insert($data);
    }
}
