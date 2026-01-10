<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MenuItemController extends Controller
{
    public function index()
    {
        $menuItems = MenuItem::whereHas('category', function ($query) {
                $query->where('restaurant_id', Auth::user()->restaurant_id);
            })
            ->with('category')
            ->get();
        return view('admin.menu_items.index', compact('menuItems'));
    }

    public function create()
    {
        $categories = Category::where('restaurant_id', Auth::user()->restaurant_id)->get();
        return view('admin.menu_items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'boolean',
            'image_url' => 'nullable|url',
        ]);

        $category = Category::findOrFail($request->category_id);
        if ($category->restaurant_id !== Auth::user()->restaurant_id) {
            abort(403);
        }

        MenuItem::create($request->all());

        return redirect()->route('menu_items.index')->with('success', 'Menu Item created successfully.');
    }

    public function edit(MenuItem $menuItem)
    {
        $this->authorizeOwner($menuItem);
        $categories = Category::where('restaurant_id', Auth::user()->restaurant_id)->get();
        return view('admin.menu_items.edit', compact('menuItem', 'categories'));
    }

    public function update(Request $request, MenuItem $menuItem)
    {
        $this->authorizeOwner($menuItem);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'is_available' => 'boolean',
            'image_url' => 'nullable|url',
        ]);

        $category = Category::findOrFail($request->category_id);
        if ($category->restaurant_id !== Auth::user()->restaurant_id) {
            abort(403);
        }

        $menuItem->update($request->all());

        return redirect()->route('menu_items.index')->with('success', 'Menu Item updated successfully.');
    }

    public function destroy(MenuItem $menuItem)
    {
        $this->authorizeOwner($menuItem);
        $menuItem->delete();

        return redirect()->route('menu_items.index')->with('success', 'Menu Item deleted successfully.');
    }

    public function toggleAvailability(MenuItem $menuItem)
    {
        $this->authorizeOwner($menuItem);
        $menuItem->update(['is_available' => !$menuItem->is_available]);

        return response()->json(['success' => true, 'is_available' => $menuItem->is_available]);
    }

    private function authorizeOwner(MenuItem $menuItem)
    {
        if ($menuItem->category->restaurant_id !== Auth::user()->restaurant_id) {
            abort(403);
        }
    }
}
