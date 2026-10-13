@extends('layouts.app')

@section('content')
<style>
    .auction-row:hover {
         background-color: #f9fafb;
    }
</style>
<div class="container">

    <h1 style="
    font-size: 28px;
    font-weight: bold;
    margin-bottom: 10px;
    color: #1f2937;
">
    Auctions
</h1>

<p style="
    color: #6b7280;
    margin-top: 0;
    margin-bottom: 20px;
">
    Browse and manage available auctions.
</p>

    @if (session('success'))
        <div style="background-color: #dcfce7;
                    color: #166534;
                    padding: 14px 18px;
                    border-radius: 8px;
                    margin-bottom: 20px;
                    font-weight: 500 ">
            ✓ {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('auctions.create') }}"
       style="display: inline-block;
              background-color: #2563eb;
              color: white;
              padding: 10px 20px;
              border-radius: 6px;
              text-decoration: none;
              margin-bottom: 20px;">
        + Create Auction
    </a>

    <div style="
    background: white;
    border: 1px solid #d1d5db;
    border-radius: 10px;
    overflow: hidden;
    overflow-x: auto;
    margin-top: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
">

<table style="
    width: 100%;
    border-collapse: collapse;
    min-width: 1050px;
">
        <thead style="background-color: #f3f4f6;">
    <tr class="auction-row" style="border-bottom: 1px solid #e5e7eb;">
        <th style="padding: 14px; border-bottom: 1px solid #d1d5db;">Title</th>
        <th style="padding: 14px; border-bottom: 1px solid #d1d5db;">Category</th>
        <th style="padding: 14px; border-bottom: 1px solid #d1d5db;">Starting Price</th>
        <th style="padding: 14px; border-bottom: 1px solid #d1d5db;">Current Price</th>
        <th style="padding: 14px; border-bottom: 1px solid #d1d5db;">Start Time</th>
        <th style="padding: 14px; border-bottom: 1px solid #d1d5db;">End Time</th>
        <th style="padding: 14px; border-bottom: 1px solid #d1d5db; min-width:140px;">Status</th>
        <th style="padding: 14px; border-bottom: 1px solid #d1d5db; min-width: 220px;">Actions</th>
    </tr>
</thead>

        <tbody>
            @forelse ($auctions as $auction)
                <tr>
                    <td style="padding: 14px; border-bottom: 1px solid #e5e7eb; text-align: center;">{{ $auction->title }}</td>
                    <td style="padding: 14px; border-bottom: 1px solid #e5e7eb; text-align: center;">{{ $auction->category->name }}</td>
                    <td style="border-bottom: 1px solid #e5e7eb; text-align: center;">{{ number_format($auction->starting_price, 2) }}</td>
                    <td style="padding: 14px; border-bottom: 1px solid #e5e7eb; text-align: center;">Ksh {{ number_format($auction->current_price ?? $auction->starting_price, 2) }}</td>
                    <td style="padding: 14px; border-bottom: 1px solid #e5e7eb; text-align: center;">{{ $auction->start_time }}</td>
                    <td style="padding: 14px; border-bottom: 1px solid #e5e7eb; text-align: center;">{{ $auction->end_time }}</td>
                    <td style="padding: 14px; border-bottom: 1px solid #e5e7eb;">

    @if($auction->status === 'active')
        <span style="
            display: inline-block;
            background-color: #dcfce7;
            color: #166534;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
        ">
            ● Active
        </span>

    @elseif($auction->status === 'pending')
        <span style="
            display: inline-block;
            background-color: #fef3c7;
            color: #92400e;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
        ">
            ● Pending
        </span>

    @elseif($auction->status === 'closed')
        <span style="
            display: inline-block;
            background-color: #fee2e2;
            color: #991b1b;
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: bold;
        ">
            ● Closed
        </span>
    @endif

</td>

                    <td style="
                        padding: 14px;
                         border-bottom: 1px solid #e5e7eb;
    white-space: nowrap;
    min-width: 220px;
    vertical-align: middle;
">
                        <a href="{{ route('auctions.show', $auction) }}"
   style="
       display: inline-block;
       background-color: #2563eb;
       color: white;
       padding: 6px 10px;
       border-radius: 6px;
       text-decoration: none;
       margin-right: 4px;
   ">
    View
</a>

                        @auth
                            @if($auction->user_id === Auth::id())
                                |
                                <a href="{{ route('auctions.edit', $auction) }}"
   style="
       display: inline-block;
       background-color: #f59e0b;
       color: white;
       padding: 6px 10px;
       border-radius: 6px;
       text-decoration: none;
       margin-right: 4px;
   ">
    Edit
</a>

                                |

                                <form action="{{ route('auctions.destroy', $auction) }}"
                                      method="POST"
                                      style="display: inline;"
                                      onsubmit="return confirm('Are you sure you want to delete this auction?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
        style="
            background-color: #dc2626;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        ">
    Delete
</button>
                                </form>
                            @endif
                        @endauth
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">
                        No auctions found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
@endsection
