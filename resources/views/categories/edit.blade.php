<!DOCTYPE html>
<html>
<head>
    <title>Edit Category</title>
</head>
<body>

    <h1>Edit Category</h1>

    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Category Name</label>
            <input
                type="text"
                name="name"
                id="name"
                value="{{ old('name', $category->name) }}"
                required
            >
        </div>

        <br>

        <div>
            <label for="description">Description</label>
            <textarea
                name="description"
                id="description"
            >{{ old('description', $category->description) }}</textarea>
        </div>

        <br>

        <button type="submit">Update Category</button>
    </form>

    <br>

    <a href="{{ route('categories.index') }}">Back to Categories</a>

</body>
</html>
