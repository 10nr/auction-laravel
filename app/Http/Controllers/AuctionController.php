<?php

namespace App\Http\Controllers;

use App\Models\Auction;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuctionController extends Controller
{
    /**
     * Display a listing of auctions.
     */
    public function index()
{
    $auctions = Auction::with('category', 'user')
        ->latest()
        ->get();

    foreach ($auctions as $auction) {
        $auction->updateStatus();
    }

    return view('auctions.index', compact('auctions'));
}

    /**
     * Show the form for creating a new auction.
     */
    public function create()
    {
        $categories = Category::all();

        return view('auctions.create', compact('categories'));
    }

    /**
     * Store a newly created auction.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'starting_price' => 'required|numeric|min:0',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'image' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['current_price'] = $validated['starting_price'];
        $validated['status'] = 'pending';

        Auction::create($validated);

        return redirect()
            ->route('auctions.index')
            ->with('success', 'Auction created successfully.');
    }

    /**
     * Display the specified auction.
     */
    public function show(Auction $auction)
    {  
        $auction->updateStatus();

        $auction->load('category', 'user', 'bids');

        return view('auctions.show', compact('auction'));
    }

    /**
     * Show the form for editing the specified auction.
     */
    public function edit(Auction $auction)
{
    if ($auction->user_id !== Auth::id()) {
        abort(403, 'You are not authorized to edit this auction.');
    }

    $categories = Category::orderBy('name')->get();

    return view('auctions.edit', compact('auction', 'categories'));
}

    /**
     * Update the specified auction.
     */
    public function update(Request $request, Auction $auction)
    {
if ($auction->user_id !== Auth::id()) {
    abort(403, 'You are not authorized to update this auction.');
}

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'starting_price' => 'required|numeric|min:0',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'image' => 'nullable|string|max:255',
            'status' => 'required|in:pending,active,closed',
        ]);

        $auction->update($validated);

        return redirect()
            ->route('auctions.index')
            ->with('success', 'Auction updated successfully.');
    }

    /**
     * Remove the specified auction.
     */
    public function destroy(Auction $auction)
    {
if ($auction->user_id !== Auth::id()) {
    abort(403, 'You are not authorized to update this auction.');
}

        $auction->delete();

        return redirect()
            ->route('auctions.index')
            ->with('success', 'Auction deleted successfully.');
    }
}
