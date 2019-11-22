<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('categories')->delete();
      DB::table('categories')->insert(array(
          [
            'name' => 'Design/Graphics',
            'slug' => 'design-graphics',
          ],
          [
            'name' => 'Programming',
            'slug' => 'programming',
          ],
          [
            'name' => 'Customer Support' ,
            'slug' => 'customer-support',
          ],
          [
            'name' => 'Copywriting' ,
            'slug' => 'Ccopywriting',
          ],
          [
            'name' => 'DevOps & Sysadmin' ,
            'slug' => 'devops-Sysadmin',
          ],
          [
            'name' => 'Sales & Marketing' ,
            'slug' => 'sales-marketing',
          ],
          [
            'name' => 'Business & Management' ,
            'slug' => 'business-management',
          ],
          [
            'name' => 'Finance & Legal' ,
            'slug' => 'finance-legal',
          ],
          [
            'name' => 'Product' ,
            'slug' => 'product',
          ],
          [
            'name' => 'Administrative' ,
            'slug' => 'administrative',
          ],
          [
            'name' => 'Education' ,
            'slug' => 'education',
          ],
          [
            'name' => 'Translation & Transcription' ,
            'slug' => 'translation-transcription',
          ],
          [
            'name' => 'Virtual Assistant' ,
            'slug' => 'virtual-assistant',
          ],
          [
            'name' => 'Others',
            'slug' => 'others',
          ]
      ));
    }
}
