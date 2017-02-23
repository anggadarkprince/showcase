<?php
namespace App\Http\ViewComposers;

use App\Category;
use Illuminate\View\View;

/**
 * Created by PhpStorm.
 * User: angga
 * Date: 23/02/17
 * Time: 17:25
 */
class CategoryMenuComposer
{
    /**
     * The user repository implementation.
     *
     * @var UserRepository
     */
    protected $category;

    /**
     * Create a new profile composer.
     *
     * @param Category $category
     */
    public function __construct(Category $category)
    {
        // Dependencies automatically resolved by service container...
        $this->category = $category;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('categoryMenu', $this->category->all());
    }
}