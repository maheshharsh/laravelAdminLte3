<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class CategoryController extends Controller
{
    /**
 * Display a listing of the resource.
 *
 * @return \Illuminate\Http\Response
 */
public function index(Request $request)
{
        if (!Auth::check()) {
        return response()->json(['message' => 'Unauthorized'], 401);
        }
        $selectCol = 'categories.' . Category::ID . ',' . 'categories.' . Category::NAME. ',' . 'categories.' . Category::SLUG;
        $category = Category::selectRaw($selectCol)->orderBy(Category::ID);
        
        $canView = Gate::allows(Category::VIEW_CATEGORY);
        $canUpdate = Gate::allows(Category::UPDATE_CATEGORY);
        $canDelete = Gate::allows(Category::DELETE_CATEGORY);

        if ($request->ajax()) {

            return Datatables::of($category)
                ->filterColumn('name', function ($query, $keyword) {
                    $sql = "categories.name like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('slug', function ($query, $keyword) {
                    $sql = "categories.slug like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->editColumn('action', function ($permission) use ($canView, $canUpdate, $canDelete) {
                    $action = '';
                    // if ($canUpdate) {
                        $action .= '<a href="' . route('admin.categories.edit', $permission->id) . '"> <i class="fa fa-edit"></i> </a>';
                    // }
                    // if ($canView) {
                        $action .= '<a href="' . route('admin.categories.show', $permission->id) . '"> <i class="fa fa-eye"></i> </a>';
                    // }
                    // if ($canDelete) {
                        $action .= "<a href='#' class='delete' title='Delete' data-id='$permission->id'> <i class='fa fa-trash'></i> </a>";
                    // }

                    return $action;
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.category.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('admin.category.add-edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());

        if ($category) {
            return redirect()->route('admin.categories.index')
                ->with('success', "Category \"$category->name\" added successfully");
        }

        return redirect()->back()
            ->withErrors(__('somethingwrong'))
            ->withInput();
    }


    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('admin.category.view', compact('category'));
    }
    
    /**
     * Show the form for editing the specified resource.
    */
    public function edit(Category $category)
    {
        return view('admin.category.add-edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        try {
            $categoryUp = $category->update($request->validated());

            if ($categoryUp) {
                return redirect()->route('admin.categories.index')
                    ->with('success', "Category \"{$category->name}\" updated successfully");
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
    public function destroy(Category $category)
    {
        $isDeleted = $category->delete();
        if ($isDeleted) {
            return redirect()->route('admin.categories.index')->with('success', "Category \"$category->name\" deleted successfully");
        } else {
            return redirect()->back()->withErrors(__('somethingwrong'))->withInput();
        }
    }
}
