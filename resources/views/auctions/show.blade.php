@extends('layouts.app')

@section('content')

<div class="max-w-5xl mx-auto px-4 py-8">{{-- Success Message --}}
@if(session('success'))
    <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-5 py-4 text-green-700">
        {{ session('success') }}
    </div>
@endif

{{-- Auction Header --}}
<div class="bg-white shadow-md rounded-xl p-6 mb-6 border border-gray-200">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

        <div>
            <p class="text-sm text-gray-500 mb-1">
                {{ $auction->category->name }}
            </p>

            <h1 class="text-3xl font-bold text-gray-800">
                {{ $auction->title }}
            </h1>

@if($auction->status === 'active')
    <p class="text-sm text-gray-500 mt-2">
        ⏳ Ends in:
        <span id="countdown"
              class="font-bold text-red-600"
              data-end-time="{{ \Carbon\Carbon::parse($auction->end_time)->timestamp * 1000  }}">
        </span>
    </p>
@endif
        </div>

        <span class="
            inline-block w-fit px-4 py-2 rounded-full text-sm font-semibold
            @if($auction->status === 'active')
                bg-green-100 text-green-700
            @elseif($auction->status === 'pending')
                bg-yellow-100 text-yellow-700
            @else
                bg-red-100 text-red-700
            @endif
        ">
            {{ ucfirst($auction->status) }}
        </span>

    </div>

</div>


{{-- Auction Information --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

    {{-- Description --}}
    <div class="md:col-span-2 bg-white shadow-md rounded-xl p-6 border border-gray-200">

        <h2 class="text-xl font-bold text-gray-800 mb-3">
            Description
        </h2>

        <p class="text-gray-600 leading-relaxed">
            {{ $auction->description }}
        </p>

    </div>


    {{-- Starting Price --}}
    <div class="bg-white shadow-md rounded-xl p-6 border border-gray-200">

        <p class="text-sm text-gray-500">
            Starting Price
        </p>

        <p class="text-2xl font-bold text-blue-600 mt-2">
            {{ number_format($auction->starting_price, 2) }}
        </p>

    </div>


    {{-- Current Price --}}
    <div class="bg-green-50 shadow-md rounded-xl p-6 border border-gray-200">

        <p class="text-sm text-gray-500">
            Current Price
        </p>

        <p class="text-3xl font-bold text-green-700 mt-2">
            {{ number_format($auction->current_price ?? $auction->starting_price, 2) }}
        </p>
        @if($auction->status === 'active')
           <p class="text-xs text-green-600 mt-2"> Live bidding </p>
        @endif
    </div>


    {{-- Start Time --}}
    <div class="bg-white shadow-md rounded-xl p-6 border border-gray-200">

        <p class="text-sm text-gray-500">
            Start Time
        </p>

        <p class="font-semibold text-gray-800 mt-2">
            {{ $auction->start_time }}
        </p>

    </div>


    {{-- End Time --}}
    <div class="bg-white shadow-md rounded-xl p-6 border border-gray-200">

        <p class="text-sm text-gray-500">
            End Time
        </p>

        <p class="font-semibold text-gray-800 mt-2">
            {{ $auction->end_time }}
        </p>

    </div>


    {{-- Created By --}}
    <div class="md:col-span-2 bg-white shadow-md rounded-xl p-6 border border-gray-200">

        <p class="text-sm text-gray-500">
            Created By
        </p>

        <p class="font-semibold text-gray-800 mt-2">
            {{ $auction->user->name }}
        </p>

    </div>

</div>


{{-- Place Bid --}}
@auth
    @if($auction->status === 'active')

        <div class="bg-white shadow-md rounded-xl p-6 mb-6 border border-gray-200">

            <h2 class="text-xl font-bold text-gray-800 mb-5">
                Place a Bid
            </h2>

@if ($errors->any())
    <div class="mb-5 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-red-700">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(session('success'))
    <div class="mb-6 flex items-center gap-3 rounded-lg border border-green-200 bg-green-50 px-5 py-4 text-green-700">
        <span class="text-lg font-bold">✓</span>

        <span class="font-medium">
            {{ session('success') }}
        </span>
    </div>
@endif

            <form action="{{ route('bids.store', $auction) }}" method="POST">

                @csrf

                <div class="mb-5">

                    <label for="amount"
                           class="block text-sm font-semibold text-gray-700 mb-2">

                        Bid Amount

                    </label>
<p class="text-sm text-gray-500 mb-2">
    Minimum bid:
    {{ number_format(($auction->current_price ?? $auction->starting_price) + 0.01, 2) }}
</p>
<input type="number"
                           name="amount"
                           id="amount"
                           step="0.01"
                           min="{{ ($auction->current_price ?? $auction->starting_price) + 0.01 }}"
                           required
                           class="w-full md:w-1/2 border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">

                </div>


                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition">

                    Place Bid

                </button>

            </form>

        </div>

    @endif
@endauth


{{-- Bid History --}}
<div class="bg-white shadow-md rounded-xl p-6 mb-6 border border-gray-200">

    <div class="flex items-center justify-between mb-5">
    <h2 class="text-xl font-bold text-gray-800">
        Bid History
    </h2>

    <span class="px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-700">
        {{ $auction->bids->count() }} {{ Str::plural('Bid', $auction->bids->count()) }}
    </span>
</div>


    @if($auction->bids->count() > 0)

        <div class="space-y-3">

            @foreach($auction->bids->sortByDesc('created_at') as $bid)

                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 p-4 border border-gray-200 rounded-lg bg-gray-50 hover:bg-gray-100 transition">

                    <div>

                        <p class="font-semibold text-gray-800">

                            {{ $bid->user->name }}

                        </p>

                        <p class="text-sm text-gray-500">

                            {{ $bid->created_at->format('d M Y, H:i') }}

                        </p>

                    </div>


                    <p class="text-lg font-bold text-green-600">

                        {{ number_format($bid->bid_amount, 2) }}

                    </p>

                </div>

            @endforeach

        </div>


    @else

        <div class="text-center py-6 text-gray-500">

            No bids have been placed yet.

        </div>

    @endif

</div>


{{-- Action Buttons --}}
<div class="flex flex-wrap gap-3 items-center">

    @auth

        @if($auction->user_id === Auth::id())

            <a href="{{ route('auctions.edit', $auction) }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-5 py-3 rounded-lg transition">

                Edit Auction

            </a>


            <form action="{{ route('auctions.destroy', $auction) }}"
                  method="POST"
                  onsubmit="return confirm('Are you sure you want to delete this auction?');">

                @csrf
                @method('DELETE')

                <button type="submit"
                        class="bg-red-600 hover:bg-red-700 text-white font-semibold px-5 py-3 rounded-lg transition">

                    Delete Auction

                </button>

            </form>

        @endif

    @endauth


    <a href="{{ route('auctions.index') }}"
       class="bg-gray-700 hover:bg-gray-800 text-white font-semibold px-5 py-3 rounded-lg transition">

        ← Back to Auctions

    </a>

</div>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const countdown = document.getElementById('countdown');

        if (!countdown) {
            return;
        }

        const endTime = Number(countdown.dataset.endTime);

        function updateCountdown() {
            const difference = endTime - Date.now();

            if (difference <= 0) {
                countdown.textContent = 'Auction ended';
                return;
            }

            const days = Math.floor(difference / 86400000);
            const hours = Math.floor((difference % 86400000) / 3600000);
            const minutes = Math.floor((difference % 3600000) / 60000);
            const seconds = Math.floor((difference % 60000) / 1000);

             if (days > 0) {
    countdown.textContent =
        `${days}d ${hours}h ${minutes}m ${seconds}s`;
} else {
    countdown.textContent =
        `${hours}h ${minutes}m ${seconds}s`;
}
        }

        updateCountdown();
        setInterval(updateCountdown, 1000);
    });
</script>

@endsection
