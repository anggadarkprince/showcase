<?php

namespace App\Http\Controllers;

use App\Category;
use App\Portfolio;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $portfolios = $user->portfolios()->orderBy('date', 'desc')->get();

        return view('portfolio.index', compact('user', 'portfolios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function create(User $user)
    {
        $categories = Category::all()->pluck('category', 'id');

        return view('portfolio.create', compact('user', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, User $user)
    {
        $data = $request->all();

        // turn tags to array
        $tags = explode(',', $data['tags']);
        $data['tags'] = count($tags);

        $rules = [
            'title' => 'required|max:255',
            'description' => 'required|max:500',
            'category' => 'required',
            'tags' => 'required|max:10',
            'company' => 'max:50',
            'date' => 'date_format:Y-m-d',
            'reference' => 'url'
        ];

        Validator::make($data, $rules)->validate();

        return DB::transaction(function () use ($user, $request, $tags) {
            try {
                // populating data and some adjustment (change field category into category_id
                $except = ['tags', 'screenshots', 'category'];
                $category_id = $request->input('category');
                $inputs = $request->except($except);
                $inputs['category_id'] = $category_id;

                // insert portfolio
                $portfolio = $user->portfolios()->create($inputs);

                // insert tags
                $existingTags = Tag::whereIn('tag', $tags);

                $existingTagsId = $existingTags->pluck('id')->toArray();
                $existingTagsName = $existingTags->pluck('tag')->toArray();

                $newTagsName = array_diff($tags, $existingTagsName);

                foreach ($newTagsName as $tag):
                    $newTag = Tag::create([
                        'tag' => $tag
                    ]);
                    array_push($existingTagsId, $newTag->id);
                endforeach;

                $portfolio->tags()->attach($existingTagsId);

                // insert screenshot
                $screenshotData = [];
                $screenshots = $request->file('screenshots');
                $count = 0;
                foreach ($screenshots as $screenshot):
                    $name = $screenshot->hashName();
                    $path = $screenshot->storeAs('public/screenshots', $name);

                    array_push($screenshotData, [
                        'caption' => $screenshot->getClientOriginalName(),
                        'source' => $name,
                        'is_featured' => ($count++ == 0)
                    ]);
                endforeach;

                if(count($screenshotData) > 0){
                    $portfolio->screenshots()->createMany($screenshotData);
                }

                // all good, send success message
                return redirect()->route('account.portfolio', [$user->username])->with([
                    'action' => 'success',
                    'message' => 'Portfolio was created'
                ]);
            } catch (\Exception $e) {
                // something goes wrong
                return redirect()->back()
                    ->withErrors(['error' => $e->getMessage()])
                    ->withInput();
            }
        }, 5);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
