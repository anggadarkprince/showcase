<?php

namespace App\Http\Controllers;

use App\Category;
use App\Portfolio;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    function searchByCompany($companySlug){
        $companyGuess = str_replace('-', ' ', $companySlug);
        $portfolios = Portfolio::where('company', 'like', "{$companyGuess}%")->paginate(12);
        $title = "Company: {$companyGuess}";
        return view('portfolio.discover', compact('portfolios', 'title'));
    }

    function searchByCategory($categorySlug){
        $categoryGuess = str_replace('-', ' ', $categorySlug);
        $category = Category::where('category', 'like', "{$categoryGuess}%")->firstOrFail();
        $portfolios = $category->portfolios()->paginate(12);
        $title = "Category: {$category->category}";
        return view('portfolio.discover', compact('portfolios', 'title'));
    }

    function searchByTag($tagSlug){
        $tagGuess = str_replace('-', ' ', $tagSlug);
        $portfolio = new Portfolio();
        $portfolios = $portfolio->portfolioByTag($tagGuess);
        $title = "Tag: {$tagGuess}";
        return view('portfolio.discover', compact('portfolios', 'title'));
    }

    function searchQuery($query){

    }
}
