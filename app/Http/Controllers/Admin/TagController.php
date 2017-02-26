<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Tag;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    /**
     * The attributes that object of Tag.
     *
     * @var Tag
     */
    private $tag;

    /**
     * TagController constructor.
     *
     * @param Tag $tag
     */
    public function __construct(Tag $tag)
    {
        $this->tag = $tag;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = $this->tag->latest()->paginate(10);

        return view('admin.tags.index', compact('tags'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'unique' => 'The :attribute was available in database',
            'tag.required' => 'The :attribute must be not empty.',
        ];

        $validator = Validator::make($request->all(), [
            'tag' => 'sometimes|required|unique:tags|max:255',
        ], $messages);

        if ($validator->fails()) {
            if ($request->expectsJson()) {
                return new JsonResponse($validator->errors()->getMessages(), 422);
            }
            return redirect(route('admin.tag'))
                ->withErrors($validator)
                ->withInput();
        }

        $this->tag->fill($request->all());
        if ($this->tag->save()) {
            $dataMessages = [
                'action' => 'success',
                'message' => 'Tag was created successfully'
            ];

            if ($request->expectsJson()) {
                return response($dataMessages);
            }
            return redirect(route('admin.tag'))->with($dataMessages);
        }

        $dataErrorMessages = [
            'error' => 'Create new tag failed, Try again!'
        ];
        if ($request->expectsJson()) {
            return new JsonResponse($dataErrorMessages, 500);
        }
        return redirect()->back()->withErrors($dataErrorMessages);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $tag
     * @return \Illuminate\Http\Response
     */
    public function destroy($tag)
    {
        $tag = $this->tag->findOrFail($tag);
        try {
            if ($tag->delete()) {
                return redirect(route('admin.tag'))->with([
                    'action' => 'success',
                    'message' => Lang::get('page.message.deleted', ['item' => ucfirst($tag->tag)])
                ]);
            }
        } catch (QueryException $e) {
            logger('Failed delete tag', $e->errorInfo);
            if ($e->errorInfo[0] == 23000) {
                return redirect()->back()->withErrors([
                    'message' => trans('page.message.error_related')
                ]);
            }
        }
        return redirect()->back()->withErrors([
            'message' => 'Failed to perform delete tag, Try again!'
        ]);
    }
}
