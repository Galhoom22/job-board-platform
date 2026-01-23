<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JobCategory;
use App\Http\Requests\JobCategoryCreateRequest;
use App\Http\Requests\JobCategoryUpdateRequest;

class JobCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->boolean('archived')) {
            $categories = JobCategory::onlyTrashed()->latest()->paginate(10)->onEachSide(1);
        } else {
            $categories = JobCategory::latest()->paginate(10)->onEachSide(1);
        }
        
        return view('job-category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('job-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(JobCategoryCreateRequest $request)
    {
        $category = JobCategory::create($request->validated());
        return redirect()->route('job-categories.index')->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = JobCategory::findOrFail($id);
        return view('job-category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(JobCategoryUpdateRequest $request, string $id)
    {
        $category = JobCategory::findOrFail($id);
        $category->update($request->validated());
        return redirect()->route('job-categories.index')->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = JobCategory::findOrFail($id);
        $category->delete();
        return redirect()->route('job-categories.index')->with('success', 'Category Archived successfully');
    }

    public function restore(string $id)
    {
        $category = JobCategory::withTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('job-categories.index', ['archived' => true])->with('success', 'Category Restored successfully');
    }
}
