<?php

namespace App\Actions;

use App\Models\Auction;
use App\Models\Bid;
use Exception;

class PlaceBidAction
{
    public function execute(Auction $auction, float $amount, int $userId): Bid
    {
     $auction->update();

     if ($auction->status !== 'active') {
    throw new Exception(
        "Bidding is only allowed while the auction is active."
    );
}
        // Get the current price, or use the starting price
        // if no bid has been placed yet.
        $currentPrice = max(
    (float) $auction->starting_price,
    (float) ($auction->current_price ?? 0)
);

        // The new bid must be higher than the current price.
        if ($amount <= $currentPrice) {
            throw new Exception(
                "Bid must be higher than the current price."
            );
        }

        // Create the bid using the actual database column.
        $bid = $auction->bids()->create([
            'user_id' => $userId,
            'bid_amount' => $amount,
        ]);

        // Update the auction's current price.
        $auction->update([
            'current_price' => $amount,
        ]);

        return $bid;
    }
}
