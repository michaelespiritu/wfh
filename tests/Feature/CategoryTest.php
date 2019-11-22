<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function categoryWillBeOutput()
    {
        $this->withoutExceptionHandling();

        factory('App\Model\Category')->create();

        $cat = $this->get('/api/category');
        
        $cat->assertJsonFragment(
            [
                'name' => 'Accounting/Finance' ,
                'slug' => 'accounting-finance',
            ]
        );
    }
}
