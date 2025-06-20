<?


use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MetadataSeeder extends Seeder
{
    public function run()
    {
        DB::table('metadata')->insert([
            ['nama' => 'Data 1', 'created_at' => now(), 'updated_at' => now()],
            ['nama' => 'Data 2', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
