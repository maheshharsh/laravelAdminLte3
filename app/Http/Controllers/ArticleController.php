<?php

namespace App\Http\Controllers;

use App\Helpers\CommonHelper;
use App\Http\Requests\ArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Commodities;
use App\Models\Headline;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\Media;
use Illuminate\Routing\Controller as BaseController;
use Inertia\Inertia;

class ArticleController extends BaseController
{
    public function __construct()
    {
        // $this->middleware('auth');

        // // Apply permissions to specific methods
        // $this->middleware('can:' . Article::BROWSE_ARTICLE)->only(['index']);
        // $this->middleware('can:' . Article::CREATE_ARTICLE)->only(['create', 'store']);
        // $this->middleware('can:' . Article::VIEW_ARTICLE)->only(['show']);
        // $this->middleware('can:' . Article::UPDATE_ARTICLE)->only(['edit', 'update']);
        // $this->middleware('can:' . Article::DELETE_ARTICLE)->only(['destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        $selectCol = 'articles.' . Article::ID . ',' . 'articles.' . Article::TITLE . ',' . 'articles.' . Article::PUBLISHEDAT . ',' . 'articles.' . Article::ISFEATURED . ',' . 'articles.' . Article::ISPUBLISHED . ',' . 'articles.' . Article::ISCAROUSEL . ',' . 'articles.' . Article::SLUG . ',' . 'articles.' . Article::SUBCONTENT;
        $article = Article::selectRaw($selectCol)->orderBy(Article::ID);

        $canView = Gate::allows(Article::VIEW_ARTICLE);
        $canUpdate = Gate::allows(Article::UPDATE_ARTICLE);
        $canDelete = Gate::allows(Article::DELETE_ARTICLE);

        if ($request->ajax()) {

            return Datatables::of($article)
                ->filterColumn('title', function ($query, $keyword) {
                    $sql = "articles.title like ?";
                    $query->whereRaw($sql, ["%{$keyword}%"]);
                })
                // ->filterColumn('category_id', function ($query, $keyword) {
                //     $sql = "headlines.category_id like ?";
                //     $query->whereRaw($sql, ["%{$keyword}%"]);
                // })
                ->editColumn('action', function ($article) use ($canView, $canUpdate, $canDelete) {
                    $action = '';
                    // if ($canUpdate) {
                    $action .= '<a href="' . route('admin.articles.edit', $article->id) . '"> <i class="fa fa-edit"></i> </a>';
                    // }
                    // if ($canView) {
                    $action .= '<a href="' . route('admin.articles.show', $article->id) . '"> <i class="fa fa-eye"></i> </a>';
                    // }
                    // if ($canDelete) {
                    $action .= "<a href='#' class='delete' title='Delete' data-id='$article->id'> <i class='fa fa-trash'></i> </a>";
                    // }

                    return $action;
                })
                ->addIndexColumn()
                ->make(true);
        }
        return view('admin.article.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $users = User::all();

        return view('admin.article.add-edit', compact('categories', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {
        DB::beginTransaction();

        try {
            // Handle featured image
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $filePath = CommonHelper::uploadFile($image, config('constants.upload_path.article.featured_image'));
                $request->merge(['featured_image' => $filePath]);
            }

            // Create article
            $article = Article::create($request->all());

            // Handle gallery images
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $galleryImage) {
                    $filePath = CommonHelper::uploadFile($galleryImage, config('constants.upload_path.article.gallery_images'));

                    Media::create([
                        'article_id' => $article->id,
                        'user_id'    => Auth::id(),
                        'path'       => $image->getClientOriginalName(),
                        'file_name'  => $filePath,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.articles.index') // fixed: was 'articless'
                ->with('success', __("Article \"{$article->title}\" added successfully."));
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Article creation failed: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', __("message.somethingwrong"))
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        return view('admin.article.view', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        $categories = Category::all();
        $users = User::all();

        return view('admin.article.add-edit', compact('article', 'categories', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticleRequest $request, Article $article)
    {
        DB::beginTransaction();

        try {
            // Update featured image
            if ($request->hasFile('image')) {
                if (!empty($article->featured_image) && Storage::exists($article->featured_image)) {
                    Storage::delete($article->featured_image);
                }

                $image = $request->file('image');
                $filePath = CommonHelper::uploadFile($image, config('constants.upload_path.article.featured_image'));
                $article->featured_image = $filePath;
            }

            // Update fields
            $article->fill($request->except(['image', 'gallery_images', 'delete_gallery_images']));

            // Checkbox handling
            $article->is_featured = $request->has('is_featured');
            $article->is_published = $request->has('is_published');
            $article->is_carousel = $request->has('is_carousel');

            $article->save();

            // Delete gallery images
            if ($request->filled('delete_gallery_images')) {
                $mediaToDelete = Media::whereIn('id', $request->delete_gallery_images)->get();

                foreach ($mediaToDelete as $media) {
                    if (!empty($media->file_name) && Storage::exists($media->file_name)) {
                        Storage::delete($media->file_name);
                    }
                }

                Media::whereIn('id', $request->delete_gallery_images)->delete();
            }

            // Add new gallery images
            if ($request->hasFile('gallery_images')) {
                foreach ($request->file('gallery_images') as $galleryImage) {
                    $filePath = CommonHelper::uploadFile($galleryImage, config('constants.upload_path.article.gallery_images'));

                    Media::create([
                        'article_id' => $article->id,
                        'user_id'    => Auth::id(),
                        'path'       => $galleryImage->getClientOriginalName(),
                        'file_name'  => $filePath,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.articles.index')
                ->with('success', __("Article \"{$article->title}\" updated successfully."));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Article update failed: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', __("message.somethingwrong"))
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        DB::beginTransaction();

        try {
            // Delete featured image if exists
            if (!empty($article->featured_image) && Storage::exists($article->featured_image)) {
                Storage::delete($article->featured_image);
            }

            // Fetch related gallery images from Media table
            $mediaFiles = Media::where(Media::ARTICLE_ID, $article->id)->get();

            foreach ($mediaFiles as $media) {
                if (!empty($media->path) && Storage::exists($media->path)) {
                    Storage::delete($media->path);
                }
            }

            // Delete media records
            Media::where(Media::ARTICLE_ID, $article->id)->delete();

            // Delete the article
            $article->delete();

            DB::commit();

            return redirect()
                ->back()
                ->with('success', __("Article \"{$article->title}\" deleted successfully."));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Article deletion failed: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', __("message.somethingwrong"))
                ->withInput();
        }
    }


    /**
     * Display the home page with articles, headlines, and commodities.
     */
    public function home()
    {
        // dd('asdf');
        $articles = Article::with('category')
            ->where('is_published', true)
            ->latest()
            ->get();

        $headlines = Headline::with('category')
            ->latest()
            ->get();

        $commodities = Commodities::latest()
            ->get();

        return Inertia::render('Home', [
            'articles' => $articles,
            'headlines' => $headlines,
            'commodities' => $commodities,
        ]);
    }

    // public function politicsIndex()
    // {
    //     $politics = Article::with('category')
    //         ->where('is_published', true)
    //         ->latest()
    //         ->get();

    //     $headlines = Headline::with('category')
    //         ->whereHas('category', function ($query) {
    //             $query->where('slug', 'Politics');
    //         })
    //         ->latest()
    //         ->get();

    //     return Inertia::render('politics/Index', [
    //         'articles' => $politics,
    //         'headlines' => $headlines,
    //     ]);
    // }

    // public function sportsIndex()
    // {
    //     $politics = Article::with('category')
    //         ->where('is_published', true)
    //         ->latest()
    //         ->get();

    //     $headlines = Headline::with('category')
    //         ->whereHas('category', function ($query) {
    //             $query->where('slug', 'Sports');
    //         })
    //         ->latest()
    //         ->get();

    //     return Inertia::render('sports/Index', [
    //         'articles' => $politics,
    //         'headlines' => $headlines,
    //     ]);
    // }

    public function showData(Request $request)
    {
        $article = Article::with('media')->findorFail($request->id);
        return Inertia::render('article/show', [
            'article' => $article,
        ]);
    }

    public function category(Request $request)
    {
        // Fetch articles filtered by category slug and is_published
        $articles = Article::with('category')
            ->where('is_published', true)
            ->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->slug);
            })
            ->latest()
            ->get();

        // Fetch headlines filtered by category slug
        $headlines = Headline::with('category')
            ->whereHas('category', function ($query) use ($request) {
                $query->where('slug', $request->slug);
            })
            ->latest()
            ->get();

        return Inertia::render('category/Index', [
            'articles' => $articles,
            'headlines' => $headlines,
        ]);
    }
}
