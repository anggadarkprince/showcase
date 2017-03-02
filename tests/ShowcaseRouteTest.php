<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowcaseRouteTest extends TestCase
{

    /**
     * Discover category in main menu.
     */
    public function testCategoryFilter()
    {
        $category = \App\Category::find(1);

        $this->visitRoute('portfolio.search.category', [str_slug($category->category) . '-' . $category->id])
            ->see('Category')
            ->see($category->category);
    }

    /**
     * Filter portfolio by one of tag in showcase.
     */
    public function testTagFilter()
    {
        $tag = \App\Tag::find(1);

        $this->visitRoute('portfolio.search.tag', [str_slug($tag->tag)])
            ->see('Tag')
            ->see($tag->tag);
    }

    /**
     * Company filter by visiting or clicking company link in portfolio.
     */
    public function testCompanyFilter()
    {
        $company = \App\Portfolio::find(1)->company;

        $this->visitRoute('portfolio.search.company', [urlencode($company)])
            ->see('Company')
            ->see($company);
    }

    /**
     * Test functionality of search,
     * application could search portfolio or people independently,
     * default search is showing portfolio, then user can switch result set for people.
     */
    public function searchPortfolio()
    {
        $query = 'angga';
        // search from particular page
        $this->visit(route('page.explore'))
            ->type($query, 'q')
            ->press('Search')
            ->assertRedirectedTo(route('page.search'), ['q' => $query])
            ->seePageIs(route('page.search'))
            ->see('Result of')
            ->see($query)
            ->seeElement('input', ['value' => $query]);

        // switch search result for people
        $this->press('PEOPLE')
            ->assertRedirectedTo(route('page.search'), ['q' => $query, 'type' => 'people'])
            ->see('Angga Ari Wijaya');

        // back show result of showcases
        $this->press('SHOWCASE')
            ->assertRedirectedTo(route('page.search'), ['q' => $query, 'type' => 'showcase']);

        // type search directly from url
        $this->visitRoute('page.search', ['q' => $query, 'type' => 'people'])
            ->see('Result of');
    }
}
