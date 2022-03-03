<?php

namespace Tests\Feature\Http\Controllers\Pages;

use App\Models\Shop\Page;
use Tests\TestCase;

class PageControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testPage(): void
    {
        $pages = Page::all();
        $page = $pages->last();

        $response = $this->get('page/' . $page->slug);
        //$this->withoutMiddleware('checkIsEmptyCart');
        $response->assertOk(); // 200
    }
}
