<?php

namespace App\Http\Controllers;

use App\Category;
use App\Portfolio;
use App\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    function searchByCompany($companySlug)
    {
        $companyGuess = urldecode($companySlug);
        $portfolios = Portfolio::where('company', 'like', "%{$companyGuess}%")->paginate(12);
        $title = "Company: <strong>{$companyGuess}</strong>";
        return view('portfolio.discover', compact('portfolios', 'title'));
    }

    function searchByCategory($categorySlug)
    {
        $slugPart = explode('-', $categorySlug);
        $id = array_pop($slugPart);

        $categoryActive = Category::find($id);
        $portfolios = $categoryActive->portfolios()->paginate(12);
        $title = "Category: <strong>{$categoryActive->category}</strong>";
        return view('portfolio.discover', compact('portfolios', 'title', 'categoryActive'));
    }

    function searchByTag($tagSlug)
    {
        $tagGuess = str_replace('-', ' ', $tagSlug);
        $portfolio = new Portfolio();
        $portfolios = $portfolio->portfolioByTag($tagGuess);
        $title = "Tag: <strong>{$tagGuess}</strong>";
        return view('portfolio.discover', compact('portfolios', 'title'));
    }

    function searchQuery(Request $request)
    {
        $query = $request->get('q');
        $type = $request->get('type', 'showcase');

        if ($type == 'showcase') {
            //$portfolio = new Portfolio();
            //$portfolios = $portfolio->searchManual($query);
            $portfolios = Portfolio::search($query)->paginate(12);
            return view('misc.search', compact('portfolios'));
        } else {
            //$user = new User();
            //$users = $user->searchManual($query);
            $users = User::search($query)->paginate(12);
            return view('misc.search', compact('users'));
        }
    }
}
