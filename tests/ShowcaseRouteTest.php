<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ShowcaseRouteTest extends BrowserKitTestCase
{
    /**
     * Test visiting portfolio detail
     */
    public function testPortfolioRoute()
    {
        $portfolio = \App\Portfolio::find(1);
        $tags = $portfolio->tags;

        $this->visit(route('profile.portfolio.show', [
            $portfolio->user->username,
            str_slug($portfolio->title) . '-' . $portfolio->id
        ]))
            ->see($portfolio->title)
            ->see($portfolio->company)
            ->see($portfolio->date->format('d F Y'))
            ->see($portfolio->description)
            ->see($portfolio->view + 1);

        $tags->each(function ($tag) {
            $this->see($tag->tag);
        });
    }

    /**
     * Test when portfolio does not exist
     */
    public function testPortfolioNotFound()
    {
        $user = \App\User::find(1);
        $this->get(route('profile.portfolio.show', [
            'user' => $user->username,
            'portfolio' => 'not-existed-portfolio-title-000'
        ]))
            ->seeStatusCode(404)
            ->see('Page Not Found');
    }

    /**
     * Visitor should able to navigate filter company from detail of portfolio.
     */
    public function testVisitCompanyFromPortfolio()
    {
        $portfolio = \App\Portfolio::find(1);
        $this->visit(route('profile.portfolio.show', [
            'user' => $portfolio->user->username,
            'portfolio' => str_slug($portfolio->title) . '-' . $portfolio->id
        ]))
            ->click($portfolio->category->category)
            ->seePageIs(route('portfolio.search.category', [
                'category' => str_slug($portfolio->category->category) . '-' . $portfolio->category->id
            ]));
    }

    /**
     * Discover category in main menu.
     */
    public function testCategoryFilter()
    {
        $category = \App\Category::find(1);

        $this->visitRoute('portfolio.search.category', [
            str_slug($category->category) . '-' . $category->id
        ])
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
