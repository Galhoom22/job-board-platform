<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Company::query();

        // Filter by archived status
        if ($request->boolean('archived')) {
            $query->onlyTrashed();
        }

        // Search by name or description
        $query->when($request->search, function ($q, $search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });

        $companies = $query->latest()->paginate(10)->onEachSide(1);
        
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = ['Technology', 'Health', 'Finance', 'Education', 'Marketing', 'Retail', 'Manufacturing', 'Transportation', 'Energy', 'Entertainment'];
        return view('company.create', compact('industries'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CompanyCreateRequest $request)
    {
        // 1. Create the Owner (User)
        $owner = User::create([
            'name' => $request->owner_name,
            'email' => $request->owner_email,
            'password' => Hash::make($request->owner_password),
        ]);

        // Return Error if owner is not created
        if (!$owner) {
            return redirect()->back()->with('error', 'Failed to create owner');
        }

        // 2. Create the Company with owner_id
        Company::create([
            'name' => $request->name,
            'address' => $request->address,
            'industry' => $request->industry,
            'website' => $request->website,
            'owner_id' => $owner->id,
        ]);

        return redirect()->route('companies.index')->with('success', 'Company created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $company = Company::findOrFail($id);
        return view('company.show', compact('company'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $company = Company::findOrFail($id);
        return view('company.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, string $id)
    {
        $company = Company::findOrFail($id);
        $company->update($request->validated());
        return redirect()->route('companies.index')->with('success', 'Company updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $company = Company::findOrFail($id);
        $company->delete();
        return redirect()->route('companies.index')->with('success', 'Company Archived successfully');
    }

    public function restore(string $id)
    {
        $company = Company::withTrashed()->findOrFail($id);
        $company->restore();
        return redirect()->route('companies.index', ['archived' => true])->with('success', 'Company Restored successfully');
    }
}
