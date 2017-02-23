<?php

namespace App\Http\Controllers;

use App\Category;
use App\Portfolio;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

    private function portfolioValidation($data)
    {
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

        return $tags;
    }

    private function populatePortfolioInput($request)
    {
        $except = ['tags', 'screenshots', 'category'];
        $category_id = $request->input('category');
        $inputs = $request->except($except);
        $inputs['category_id'] = $category_id;

        return $inputs;
    }

    function uploadScreenshots($portfolio, $screenshots)
    {
        $screenshotData = [];
        $count = 0;
        if (count($screenshots) > 0) {
            foreach ($screenshots as $screenshot):
                $name = $screenshot->hashName();
                $path = $screenshot->storeAs('public/screenshots', $name);

                array_push($screenshotData, [
                    'caption' => $screenshot->getClientOriginalName(),
                    'source' => $name,
                    'is_featured' => ($count++ == 0)
                ]);
            endforeach;

            $portfolio->screenshots()->createMany($screenshotData);
        }
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
        // perform validation and return tags
        $tags = $this->portfolioValidation($request->all());

        return DB::transaction(function () use ($user, $request, $tags) {
            try {
                // populating data and some adjustment (change field category into category_id
                $inputs = $this->populatePortfolioInput($request);

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
                $this->uploadScreenshots($portfolio, $request->file('screenshots'));

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
        dd('show');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
     * @param Portfolio $portfolio
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user, Portfolio $portfolio)
    {
        $this->authorize('view', $portfolio);

        $categories = Category::all()->pluck('category', 'id');

        return view('portfolio.edit', compact('user', 'categories', 'portfolio'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param User $user
     * @param Portfolio $portfolio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user, Portfolio $portfolio)
    {
        $this->authorize('update', $portfolio);

        // perform validation and return tags
        $tags = $this->portfolioValidation($request->all());

        return DB::transaction(function () use ($user, $request, $tags, $portfolio) {
            try {
                // populating data and some adjustment (change field category into category_id
                $inputs = $this->populatePortfolioInput($request);

                // update portfolio
                $portfolio->update($inputs);

                // persist tags into table (new or old one)
                $tagsTobeSync = [];
                foreach ($tags as $tag){
                    $oldOrNewTag = Tag::firstOrCreate(['tag' => $tag]);
                    array_push($tagsTobeSync, $oldOrNewTag->id);
                }

                // sync portfolio with collection of tags
                $portfolio->tags()->sync($tagsTobeSync);

                // insert screenshot
                $this->uploadScreenshots($portfolio, $request->file('screenshots'));

                // all good, send success message
                return redirect()->route('account.portfolio', [$user->username])->with([
                    'action' => 'success',
                    'message' => "Portfolio {$portfolio->title} was updated"
                ]);
            }
            catch (\Exception $e) {
                // something goes wrong
                return redirect()->back()
                    ->withErrors(['error' => env('APP_DEBUG') ? $e->getMessage() : "Something went wrong"])
                    ->withInput();
            }
        }, 5);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @param Portfolio $portfolio
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Portfolio $portfolio)
    {
        $this->authorize('delete', $portfolio);

        return DB::transaction(function () use ($user, $portfolio) {
            try {
                $screenshots = $portfolio->screenshots;
                $title = $portfolio->title;
                if ($portfolio->delete()) {
                    foreach ($screenshots as $screenshot) {
                        Storage::delete("public/screenshots/{$screenshot->source}");
                    }
                    return redirect(route('account.portfolio', [$user->username]))->with([
                        'action' => 'success',
                        'message' => "{$title} was successfully deleted"
                    ]);
                }
            } catch (\Exception $e) {
                logger($e->getMessage());
                return redirect()->back()
                    ->withErrors([
                        'error' => env('APP_DEBUG') ? $e->getMessage() : "Something went wrong"
                    ]);
            }
        });
    }
}
