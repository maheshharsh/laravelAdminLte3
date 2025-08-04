<?php

namespace App\Http\Controllers;

use App\Http\Requests\HeadlineRequest;
use App\Models\Category;
use App\Models\Headline;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;

class HeadlineController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth');
        
        // Apply permissions to specific methods
        $this->middleware('can:' . Headline::BROWSE_HEADLINE)->only(['index']);
        $this->middleware('can:' . Headline::CREATE_HEADLINE)->only(['create', 'store']);
        $this->middleware('can:' . Headline::VIEW_HEADLINE)->only(['show']);
        $this->middleware('can:' . Headline::UPDATE_HEADLINE)->only(['edit', 'update']);
        $this->middleware('can:' . Headline::DELETE_HEADLINE)->only(['destroy']);
    }


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Auth::check()) {
        return response()->json(['message' => 'Unauthorized'], 401);
        }
        $selectCol = 'headlines.' . Headline::ID . ',' . 'headlines.' . Headline::TITLE. ',' . 'headlines.' . Headline::CONTENT . ',' . 'headlines.' . Headline::CATEGORY_ID;
        $headline = Headline::selectRaw($selectCol)->orderBy(Headline::ID);
        
        $canView = Gate::allows(Headline::VIEW_HEADLINE);
        $canUpdate = Gate::allows(Headline::UPDATE_HEADLINE);
        $canDelete = Gate::allows(Headline::DELETE_HEADLINE);

        if ($request->ajax()) {

            return Datatables::of($headline)
                ->filterColumn('title', function ($query, $keyword) {
                    $sql = "headlines.title like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('category_id', function ($query, $keyword) {
                    $sql = "headlines.category_id like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('content', function ($query, $keyword) {
                    $sql = "headlines.content like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('slug', function ($query, $keyword) {
                    $sql = "headlines.slug like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->editColumn('action', function ($headline) use ($canView, $canUpdate, $canDelete) {
                    $action = '';
                    if ($canUpdate) {
                        $action .= '<a href="' . route('admin.headlines.edit', $headline->id) . '"> <i class="fa fa-edit"></i> </a>';
                    }
                    if ($canView) {
                        $action .= '<a href="' . route('admin.headlines.show', $headline->id) . '"> <i class="fa fa-eye"></i> </a>';
                    }
                    if ($canDelete) {
                        $action .= "<a href='#' class='delete' title='Delete' data-id='$headline->id'> <i class='fa fa-trash'></i> </a>";
                    }

                    return $action;
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.headline.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::all();
        return view('admin.headline.add-edit', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(HeadlineRequest $request)
    {
        try {
            $headline = Headline::create($request->validated());
            
            if ($headline) {
                return redirect()->route('admin.headlines.index')
                ->with('success', "Headline \"$headline->title\" added successfully");
            }
            
        } catch (\Exception $ex) {
            Log::error($ex);
            return redirect()->back()
            ->withErrors(__('somethingwrong'))
            ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Headline $headline)
    {
        return view('admin.headline.view', compact('headline'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Headline $headline)
    {
        $category = Category::all();

        return view('admin.headline.add-edit', compact('headline', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HeadlineRequest $request, Headline $headline)
    {
        try {
            $headlineUp = $headline->update($request->validated());

            if ($headlineUp) {
                return redirect()->route('admin.headlines.index')
                    ->with('success', "Headline \"{$headline->title}\" updated successfully");
            } else {
                return redirect()->back()
                    ->withErrors(__('Update failed'))
                    ->withInput();
            }

        } catch (\Exception $ex) {
            // Optionally log the error for debugging
            // Log::error($ex->getMessage());

            return redirect()->back()
                ->withErrors(__('somethingwrong'))
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Headline $headline)
    {
        $isDeleted = $headline->delete();
        if ($isDeleted) {
            return redirect()->route('admin.headlines.index')->with('success', "Headline \"$headline->title\" deleted successfully");
        } else {
            return redirect()->back()->withErrors(__('somethingwrong'))->withInput();
        }
    }

    public function showData(Request $request)
    {    
        $headline = Headline::findOrFail($request->id);
        return Inertia::render('headlines/show', [
            'headlines' => $headline,
        ]);
    }
}
