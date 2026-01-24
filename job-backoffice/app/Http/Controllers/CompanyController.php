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
    public $industries = ['Technology', 'Health', 'Finance', 'Education', 'Marketing', 'Retail', 'Manufacturing', 'Transportation', 'Energy', 'Entertainment'];
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

        // Search by name, industry, or address
        $query->when($request->search, function ($q, $search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('industry', 'like', "%{$search}%")
              ->orWhere('address', 'like', "%{$search}%");
        });

        $companies = $query->latest()->paginate(10)->onEachSide(1);
        
        return view('company.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $industries = $this->industries;
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
        $industries = $this->industries;
        return view('company.edit', compact('company', 'industries'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CompanyUpdateRequest $request, string $id)
    {
        $company = Company::findOrFail($id);
        
        // Update company details
        $company->update([
            'name' => $request->name,
            'address' => $request->address,
            'industry' => $request->industry,
            'website' => $request->website,
        ]);

        // Update owner details
        if ($company->owner) {
            $company->owner->name = $request->owner_name;
            
            // Only update password if provided
            if ($request->filled('owner_password')) {
                $company->owner->password = Hash::make($request->owner_password);
            }
            
            $company->owner->save();
        }

        // Determine redirect destination
        $redirectTo = $request->redirect_to === 'show' 
            ? route('companies.show', $company) 
            : route('companies.index');

        return redirect($redirectTo)->with('success', 'Company updated successfully');
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
