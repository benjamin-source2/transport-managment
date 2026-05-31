<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BusController extends Controller
{
    public function index()
    {
        $buses = Bus::latest()->paginate(10);
        return view('admin.buses.index', compact('buses'));
    }

    public function create()
    {
        return view('admin.buses.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|max:255|unique:buses',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('bus-images', 'public');
        }

        Bus::create($validated);
        return redirect()->route('admin.buses.index')->with('success', 'Bus created successfully.');
    }

    public function edit(Bus $bus)
    {
        return view('admin.buses.edit', compact('bus'));
    }

    public function update(Request $request, Bus $bus)
    {
        $validated = $request->validate([
            'plate_number' => 'required|string|max:255|unique:buses,plate_number,' . $bus->id,
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string|max:500',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($bus->image_path) {
                Storage::disk('public')->delete($bus->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('bus-images', 'public');
        }

        $bus->update($validated);
        return redirect()->route('admin.buses.index')->with('success', 'Bus updated successfully.');
    }

    public function destroy(Bus $bus)
    {
        if ($bus->image_path) {
            Storage::disk('public')->delete($bus->image_path);
        }
        $bus->delete();
        return redirect()->route('admin.buses.index')->with('success', 'Bus deleted successfully.');
    }
}
