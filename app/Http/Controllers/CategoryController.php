<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryController extends Controller
{
    use AuthorizesRequests, SoftDeletes; // Trait

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::withCount('posts')->withTrashed()->paginate(3);

        return view('backend.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('backend.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        try {
            $category = Category::create([
                'name' => $request->name,
                'slug' => str()->slug($request->name),
            ]);

            return redirect()->route('categories.index')
                ->with('message', 'Category created successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to create category. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // Removed as we're using a modal form
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);
        try {
            $category->update([
                'name' => $request->name,
                'slug' => str()->slug($request->name),
            ]);

            return redirect()->route('categories.index')
                ->with('message', 'Category updated successfully!');
        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Failed to update category. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        $category->delete();

        return redirect()->route('categories.index')->with('message', 'Category deleted successfully!');
    }

    public function restore($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $this->authorize('restore', $category);

        $category->restore();

        return back()->with('message', 'Category restored successfully!');
    }

    public function forceDelete($id)
    {
        $category = Category::withTrashed()->findOrFail($id);
        $this->authorize('forceDelete', $category);
        if ($category->posts()->exists()) {
            return back()->with('message', 'Category has posts, cannot delete!');
        }
        $category->forceDelete();

        return back()->with('message', 'Category deleted permanently!');
    }
}
