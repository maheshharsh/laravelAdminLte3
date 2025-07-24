<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Requests\AdvertisementRequest;
use App\Models\Advertisement;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class AdvertisementController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['permission:browse_user']);
        // $this->middleware('permission:create_user', ['only' => ['create', 'store']]);
        // $this->middleware('permission:update_user', ['only' => ['update', 'edit']]);
        // $this->middleware('permission:delete_user', ['only' => ['destroy']]);
        // $this->middleware('permission:view_user',   ['only' => ['show']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Auth::check()) {
        return response()->json(['message' => 'Unauthorized'], 401);
        }
        $selectCol = 'advertisements.' . Advertisement::ID . ',' . 'advertisements.' . Advertisement::TITLE;
        $advertisement = Advertisement::selectRaw($selectCol)->orderBy(Advertisement::ID);
        
        $canView = Gate::allows(Advertisement::VIEW_ADVERTISEMENT);
        $canUpdate = Gate::allows(Advertisement::UPDATE_ADVERTISEMENT);
        $canDelete = Gate::allows(Advertisement::DELETE_ADVERTISEMENT);

        if ($request->ajax()) {

            return Datatables::of($advertisement)
                ->filterColumn('title', function ($query, $keyword) {
                    $sql = "advertisements.title like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                // ->filterColumn('category_id', function ($query, $keyword) {
                //     $sql = "headlines.category_id like ?";
                //     $query->whereRaw($sql, ["%{$keyword}%"]);
                // })
                ->editColumn('action', function ($advertisement) use ($canView, $canUpdate, $canDelete) {
                    $action = '';
                    // if ($canUpdate) {
                        $action .= '<a href="' . route('admin.advertisements.edit', $advertisement->id) . '"> <i class="fa fa-edit"></i> </a>';
                    // }
                    // if ($canView) {
                        $action .= '<a href="' . route('admin.advertisements.show', $advertisement->id) . '"> <i class="fa fa-eye"></i> </a>';
                    // }
                    // if ($canDelete) {
                        $action .= "<a href='#' class='delete' title='Delete' data-id='$advertisement->id'> <i class='fa fa-trash'></i> </a>";
                    // }

                    return $action;
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.advertisement.index');
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.advertisement.add-edit');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AdvertisementRequest $request)
    {
        try {
            // Upload profile image if present
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filePath = CommonHelper::uploadFile($image, config('constants.upload_path.adv_img'));
                $request->merge(['adv_image' => $filePath]);
            }
            
            // Create the adv
            $advertisement = Advertisement::create($request->all());
                   
            return redirect()
                ->route('admin.advertisements.index')
                ->with('success', __("Advertisement \"{$advertisement->title}\" added successfully."));
    
        } catch (\Exception $e) {
            // Optionally log the error
            Log::error('Advertisement creation failed: ' . $e->getMessage());
    
            return redirect()
                ->back()
                ->with('error', __("message.somethingwrong"))
                ->withInput();
        }
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Advertisement $advertisement)
    {
        return view('admin.advertisement.view', compact('advertisement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advertisement $advertisement)
    {
        return view('admin.advertisement.add-edit', compact('advertisement'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AdvertisementRequest $request, Advertisement $advertisement)
    {
        /* Upload user image to storage. */
        if ($request->file('image')) {
            $image = $request->file('image');
            $filePath = CommonHelper::uploadFile($image, config('constants.upload_path.adv_img'));
            if ($advertisement->adv_image){
                Storage::delete($advertisement->adv_image);
            }
            $request->merge(['adv_image' => $filePath]);
        }

        $advertisementUpdate = $advertisement->update($request->all());
        if ($advertisementUpdate) {
            return redirect()->route('admin.advertisements.index')->with('success', __("Advertisement \"$advertisement->title\" updated successfully"));
        } else {
            return redirect()->back()->with('error', __("message.somethingwrong"))->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advertisement $advertisement)
    {
        if ($advertisement->delete()) {
            Storage::delete($advertisement->adv_image);
            return redirect()->back()->with('success', __("Advertisement \"$advertisement->name\" deleted successfully"));
        } else {
            return redirect()->back()->with('error',__("message.somethingwrong"))->withInput();
        }
    }
}
