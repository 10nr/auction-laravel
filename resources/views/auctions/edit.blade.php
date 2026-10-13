@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px; margin: 40px auto; padding: 0 20px;">

    <h1 style="font-size: 30px; font-weight: bold; margin-bottom: 25px;">
        Edit Auction
    </h1>
@if ($errors->any())
    <div style="
        background-color: #fee2e2;
        color: #991b1b;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    ">
        <strong>Please fix the following errors:</strong>

        <ul style="margin-top: 10px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <form action="{{ route('auctions.update', $auction) }}" method="POST"
          style="background: white; padding: 30px; border-radius: 10px;
                 box-shadow: 0 4px 12px rgba(0,0,0,0.1);">

        @csrf
        @method('PUT')

        <input type="hidden" name="status" value="{{ $auction->status }}">

        <div style="margin-bottom: 20px;">
            <label for="title" style="display: block; font-weight: bold; margin-bottom: 8px;">
                Auction Title
            </label>

            <input type="text"
                   name="title"
                   id="title"
                   value="{{ old('title', $auction->title) }}"
                   required
                   style="width: 100%; padding: 10px; border: 1px solid #ccc;
                          border-radius: 6px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="description" style="display: block; font-weight: bold; margin-bottom: 8px;">
                Description
            </label>

            <textarea name="description"
                      id="description"
                      rows="5"
                      style="width: 100%; padding: 10px; border: 1px solid #ccc;
                             border-radius: 6px; box-sizing: border-box;">{{ old('description', $auction->description) }}</textarea>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="starting_price" style="display: block; font-weight: bold; margin-bottom: 8px;">
                Starting Price
            </label>

            <input type="number"
                   name="starting_price"
                   id="starting_price"
                   value="{{ old('starting_price', $auction->starting_price) }}"
                   step="0.01"
                   min="0"
                   required
                   style="width: 100%; padding: 10px; border: 1px solid #ccc;
                          border-radius: 6px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 20px;">
            <label for="category_id" style="display: block; font-weight: bold; margin-bottom: 8px;">
                Category
            </label>

            <select name="category_id"
                    id="category_id"
                    required
                    style="width: 100%; padding: 10px; border: 1px solid #ccc;
                           border-radius: 6px; box-sizing: border-box;">

                <option value="">-- Select Category --</option>

                @foreach($categories as $category)
                    <option value="{{ $category->id }}"
                        {{ old('category_id', $auction->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div style="margin-bottom: 20px;">
            <label for="start_time" style="display: block; font-weight: bold; margin-bottom: 8px;">
                Start Time
            </label>

            <input type="datetime-local"
                   name="start_time"
                   id="start_time"
                   value="{{ old('start_time', \Carbon\Carbon::parse($auction->start_time)->format('Y-m-d\TH:i')) }}"
                   required
                   style="width: 100%; padding: 10px; border: 1px solid #ccc;
                          border-radius: 6px; box-sizing: border-box;">
        </div>

        <div style="margin-bottom: 25px;">
            <label for="end_time" style="display: block; font-weight: bold; margin-bottom: 8px;">
                End Time
            </label>
<input type="datetime-local"
                   name="end_time"
                   id="end_time"
                   value="{{ old('end_time', \Carbon\Carbon::parse($auction->end_time)->format('Y-m-d\TH:i')) }}"
                   required
                   style="width: 100%; padding: 10px; border: 1px solid #ccc;
                          border-radius: 6px; box-sizing: border-box;">
        </div>

        <div>
            <button type="submit"
                    style="background-color: #2563eb;
                           color: white;
                           padding: 11px 22px;
                           border: none;
                           border-radius: 6px;
                           cursor: pointer;
                           font-size: 15px;">
                Update Auction
            </button>

            <a href="{{ route('auctions.show', $auction) }}"
               style="display: inline-block;
                      margin-left: 10px;
                      padding: 11px 22px;
                      background-color: #6b7280;
                      color: white;
                      text-decoration: none;
                      border-radius: 6px;">
                Cancel
            </a>
        </div>

    </form>
</div>
@endsection
