<?php

namespace App\Http\Controllers;

use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::where('restaurant_id', Auth::user()->restaurant_id)->get();
        return view('admin.tables.index', compact('tables'));
    }

    public function create()
    {
        return view('admin.tables.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'table_number' => 'required|string|max:50',
        ]);

        Table::create([
            'restaurant_id' => Auth::user()->restaurant_id,
            'table_number' => $request->table_number,
            'qr_token' => Str::random(32),
        ]);

        return redirect()->route('tables.index')->with('success', 'Table created successfully.');
    }

    public function edit(Table $table)
    {
        $this->authorizeOwner($table);
        return view('admin.tables.edit', compact('table'));
    }

    public function update(Request $request, Table $table)
    {
        $this->authorizeOwner($table);

        $request->validate([
            'table_number' => 'required|string|max:50',
        ]);

        $table->update($request->only('table_number'));

        return redirect()->route('tables.index')->with('success', 'Table updated successfully.');
    }

    public function destroy(Table $table)
    {
        $this->authorizeOwner($table);
        $table->delete();

        return redirect()->route('tables.index')->with('success', 'Table deleted successfully.');
    }

    public function generateNewToken(Table $table)
    {
        $this->authorizeOwner($table);
        $table->update(['qr_token' => Str::random(32)]);

        return redirect()->route('tables.index')->with('success', 'New QR token generated.');
    }

    public function downloadQR(Table $table)
    {
        $this->authorizeOwner($table);
        
        $url = route('order.show', ['token' => $table->qr_token]);
        $qrUrl = "https://quickchart.io/qr?text=" . urlencode($url) . "&size=1000&format=jpg";
        
        $filename = "Table_" . $table->table_number . "_QR.jpg";
        
        return response()->streamDownload(function () use ($qrUrl) {
            echo file_get_contents($qrUrl);
        }, $filename);
    }

    private function authorizeOwner(Table $table)
    {
        if ($table->restaurant_id !== Auth::user()->restaurant_id) {
            abort(403);
        }
    }
}
