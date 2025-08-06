<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommoditiesRequest;
use App\Models\Commodities;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class CommoditiesController extends BaseController
{
    public function __construct()
    {
        // $this->middleware('auth');

        // Apply permissions to specific methods
        $this->middleware('can:' . Commodities::BROWSE_COMMODITIES)->only(['index']);
        $this->middleware('can:' . Commodities::CREATE_COMMODITIES)->only(['create', 'store']);
        $this->middleware('can:' . Commodities::VIEW_COMMODITIES)->only(['show']);
        $this->middleware('can:' . Commodities::UPDATE_COMMODITIES)->only(['edit', 'update']);
        $this->middleware('can:' . Commodities::DELETE_COMMODITIES)->only(['destroy']);
    }

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
        $selectCol = 'categories.' . Commodities::ID . ',' . 'categories.' . Commodities::TITLE. ',' . 'categories.' . Commodities::PRICE;
        $category = Commodities::selectRaw($selectCol)->orderBy(Commodities::ID);

        $canView = Gate::allows(Commodities::VIEW_COMMODITIES);
        $canUpdate = Gate::allows(Commodities::UPDATE_COMMODITIES);
        $canDelete = Gate::allows(Commodities::DELETE_COMMODITIES);

        if ($request->ajax()) {

            return Datatables::of($category)
                ->filterColumn('title', function ($query, $keyword) {
                    $sql = "commodities.title like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->filterColumn('price', function ($query, $keyword) {
                    $sql = "commodities.price like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                ->editColumn('action', function ($permission) use ($canView, $canUpdate, $canDelete) {
                    $action = '';
                    if ($canUpdate) {
                        $action .= '<a href="' . route('admin.commodities.edit', $permission->id) . '"> <i class="fa fa-edit"></i> </a>';
                    }
                    if ($canView) {
                        $action .= '<a href="' . route('admin.commodities.show', $permission->id) . '"> <i class="fa fa-eye"></i> </a>';
                    }
                    if ($canDelete) {
                        $action .= "<a href='#' class='delete' title='Delete' data-id='$permission->id'> <i class='fa fa-trash'></i> </a>";
                    }

                    return $action;
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.commodities.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       return view('admin.commodities.add-edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CommoditiesRequest $request)
    {
        $commodities = Commodities::create($request->validated());

        if ($commodities) {
            return redirect()->route('admin.commodities.index')
                ->with('success', "Commodity \"$commodities->title\" added successfully");
        }

        return redirect()->back()
            ->withErrors(__('somethingwrong'))
            ->withInput();
    }


    /**
     * Display the specified resource.
     */
    public function show(Commodities $commodities)
    {
        return view('admin.commodities.view', compact('commodities'));
    }

    /**
     * Show the form for editing the specified resource.
    */
    public function edit(Commodities $commodities)
    {
        return view('admin.commodities.add-edit', compact('commodities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommoditiesRequest $request, Commodities $commodities)
    {
        try {
            $commoditiesUp = $commodities->update($request->validated());

            if ($commoditiesUp) {
                return redirect()->route('admin.commodities.index')
                    ->with('success', "Commodity \"{$commodities->title}\" updated successfully");
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
    public function destroy(Commodities $commodities)
    {
        $isDeleted = $commodities->delete();
        if ($isDeleted) {
            return redirect()->route('admin.commodities.index')->with('success', "Commodity \"$commodities->title\" deleted successfully");
        } else {
            return redirect()->back()->withErrors(__('somethingwrong'))->withInput();
        }
    }
}
