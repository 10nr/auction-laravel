<?php

namespace App\Http\Controllers;

use App\Actions\PlaceBidAction;
use App\Http\Requests\PlaceBidRequest;
use App\Models\Auction;

class BidController extends Controller
{
    public function store(PlaceBidRequest $request, Auction $auction, PlaceBidAction $placeBidAction)
    {
    $bid = $placeBidAction->execute(
        auction: $auction,
        amount: $request->validated('amount'),
        userId: $request->user()->id
    );

    if ($request->expectsJson()) {
        return response()->json([
            'message' => 'Bid placed successfully!',
            'data' => $bid,
        ], 201);
    }

    return redirect()
        ->route('auctions.show', $auction)
        ->with('success', 'Bid placed successfully!');
}
}
