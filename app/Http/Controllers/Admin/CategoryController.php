<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

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
        $categories = $this->category->paginate(10);
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
        try {
            if ($category->delete()) {
                return redirect(route('admin.category'))->with([
                    'action' => 'success',
                    'message' => "Category {$category->category} was successfully deleted"
                ]);
            }
        } catch (QueryException $e) {
            logger('Failed delete category', $e->errorInfo);
            if($e->errorInfo[0] == 23000){
                return redirect()->back()->withErrors([
                    'message' => 'You cannot delete category with existing related data'
                ]);
            }
        }
        return redirect()->back()->withErrors([
            'message' => 'Failed to perform delete category'
        ]);
    }
}
