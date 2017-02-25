<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;

class CategoryController extends Controller
{
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = $this->category->latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoryRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $this->category->fill($request->all());
        if ($this->category->save()) {
            return redirect(route('admin.category'))->with([
                'action' => 'success',
                'message' => 'Category was created successfully'
            ]);
        }
        return redirect()->back()->withErrors([
            'error' => 'Create new category failed, Try again!'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);

        try {
            if ($category->delete()) {
                return redirect(route('admin.category'))->with([
                    'action' => 'success',
                    'message' => Lang::get('page.message.deleted', ['item' => ucfirst($category->category)])
                ]);
            }
        } catch (QueryException $e) {
            logger('Failed delete category', $e->errorInfo);
            if($e->errorInfo[0] == 23000){
                return redirect()->back()->withErrors([
                    'message' => trans('page.message.error_related')
                ]);
            }
        }
        return redirect()->back()->withErrors([
            'message' => 'Failed to perform delete category'
        ]);
    }
}
