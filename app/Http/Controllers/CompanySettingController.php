<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CompanySettingController extends Controller
{
    public function edit(): Response
    {
        $settings = CompanySetting::firstOrCreate([
            'id' => 1,
        ], [
            'company_name' => 'My ERP Company',
            'country' => 'USA',
            'currency' => 'USD',
            'tax_rate' => 0,
        ]);

        return Inertia::render('CompanySettings/Edit', [
            'settings' => $settings,
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $settings = CompanySetting::firstOrCreate([
            'id' => 1,
        ]);

        $validated = $request->validate([
            'company_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'website' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:30'],
            'country' => ['nullable', 'string', 'max:100'],
            'currency' => ['required', 'string', 'max:10'],
            'tax_rate' => ['required', 'numeric', 'min:0'],
        ]);

        $settings->update($validated);

        return redirect()
            ->route('company-settings.edit')
            ->with('success', 'Company settings updated successfully.');
    }
}
