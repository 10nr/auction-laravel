@extends('layouts.app')

@section('content')

<div style="
    max-width: 800px;
    margin: 0 auto;
">

    <h1 style="
        font-size: 28px;
        font-weight: bold;
        color: #1f2937;
        margin-bottom: 8px;
    ">
        Create Auction
    </h1>

@if ($errors->any())
    <div style="
        background-color: #fee2e2;
        color: #991b1b;
        padding: 15px;
        border-radius: 6px;
        margin-bottom: 20px;
        border: 1px solid #fecaca;
    ">
        <strong>Please fix the following errors:</strong>

        <ul style="margin-top: 10px; padding-left: 20px;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

    <p style="
        color: #6b7280;
        margin-bottom: 25px;
    ">
        Fill in the details below to create a new auction.
    </p>

    <div style="
        background-color: white;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 30px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
    ">

        <form action="{{ route('auctions.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 20px;">
                <label for="title"
                       style="display: block; font-weight: 600; margin-bottom: 8px;">
                    Auction Title
                </label>

                <input type="text"
                       name="title"
                       id="title"
                       value="{{ old('title') }}"
                       required
                       style="
                           width: 100%;
                           padding: 10px;
                           border: 1px solid #d1d5db;
                           border-radius: 6px;
                           box-sizing: border-box;
                       ">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="description"
                       style="display: block; font-weight: 600; margin-bottom: 8px;">
                    Description
                </label>

                <textarea name="description"
                          id="description"
                          rows="5"
                          style="
                              width: 100%;
                              padding: 10px;
                              border: 1px solid #d1d5db;
                              border-radius: 6px;
                              box-sizing: border-box;
                          ">{{ old('description') }}</textarea>
            </div>

            <div style="margin-bottom: 20px;">
                <label for="starting_price"
                       style="display: block; font-weight: 600; margin-bottom: 8px;">
                    Starting Price
                </label>

                <input type="number"
                       name="starting_price"
                       id="starting_price"
                       value="{{ old('starting_price') }}"
                       step="0.01"
                       min="0"
                       required
                       style="
                           width: 100%;
                           padding: 10px;
                           border: 1px solid #d1d5db;
                           border-radius: 6px;
                           box-sizing: border-box;
                       ">
            </div>

            <div style="margin-bottom: 20px;">
                <label for="category_id"
                       style="display: block; font-weight: 600; margin-bottom: 8px;">
                    Category
                </label>

                <select name="category_id"
                        id="category_id"
                        required
                        style="
                            width: 100%;
                            padding: 10px;
                            border: 1px solid #d1d5db;
                            border-radius: 6px;
                            box-sizing: border-box;
                        ">

                    <option value="">-- Select Category --</option>

                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == 
                        $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div style="margin-bottom: 20px;">
                <label for="start_time"
                       style="display: block; font-weight: 600; margin-bottom: 8px;">
                    Start Time
                </label>
<input type="datetime-local"
                       name="start_time"
                       id="start_time"
                       value="{{ old('start_time') }}"
                       required
                       style="
                           width: 100%;
                           padding: 10px;
                           border: 1px solid #d1d5db;
                           border-radius: 6px;
                           box-sizing: border-box;
                       ">
            </div>

            <div style="margin-bottom: 25px;">
                <label for="end_time"
                       style="display: block; font-weight: 600; margin-bottom: 8px;">
                    End Time
                </label>

                <input type="datetime-local"
                       name="end_time"
                       id="end_time"
                       value="{{ old('end_time') }}"
                       required
                       style="
                           width: 100%;
                           padding: 10px;
                           border: 1px solid #d1d5db;
                           border-radius: 6px;
                           box-sizing: border-box;
                       ">
            </div>

            <button type="submit"
                    style="
                        background-color: #2563eb;
                        color: white;
                        padding: 10px 20px;
                        border: none;
                        border-radius: 6px;
                        cursor: pointer;
                        font-weight: 600;
                    ">
                Create Auction
            </button>

            <a href="{{ route('auctions.index') }}"
               style="
                   display: inline-block;
                   margin-left: 10px;
                   padding: 10px 20px;
                   color: #374151;
                   text-decoration: none;
                   border: 1px solid #d1d5db;
                   border-radius: 6px;
               ">
                Cancel
            </a>

        </form>

    </div>

</div>

@endsection
