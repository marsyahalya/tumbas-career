<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AreaController extends Controller
{


    public function index(): View
    {
        $areas = Area::latest()->get();
        return view('admin.areas.index', compact('areas'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string', 'max:500'],
        ]);

        Area::create($request->only([
            'name', 'description'
        ]) + ['is_active' => true]);

        return redirect()->route('admin.areas.index')
            ->with('success', 'Area berhasil ditambahkan.');
    }

    public function update(Request $request, Area $area): RedirectResponse
    {
        $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'description'  => ['nullable', 'string', 'max:500'],
            'is_active'    => ['boolean'],
        ]);

        $area->update($request->only([
            'name', 'description', 'is_active'
        ]));

        return redirect()->route('admin.areas.index')
            ->with('success', 'Area berhasil diperbarui.');
    }

    public function destroy(Area $area): RedirectResponse
    {
        $area->delete();
        return redirect()->route('admin.areas.index')
            ->with('success', 'Area berhasil dihapus.');
    }

    public function toggle(Area $area): RedirectResponse
    {
        $area->update(['is_active' => !$area->is_active]);
        $status = $area->is_active ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->route('admin.areas.index')
            ->with('success', "Area berhasil {$status}.");
    }
}
