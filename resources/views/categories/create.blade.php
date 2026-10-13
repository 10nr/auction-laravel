<!DOCTYPE html>
<html>
<head>
    <title>Create Category</title>
</head>
<body>

    <h1>Create Category</h1>

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf

        <div>
            <label for="name">Category Name</label>
            <input type="text" name="name" id="name" required>
        </div>

        <br>

        <div>
            <label for="description">Description</label>
            <textarea name="description" id="description"></textarea>
        </div>

        <br>

        <button type="submit">Create Category</button>
    </form>

    <br>

    <a href="{{ route('categories.index') }}">Back to Categories</a>

</body>
</html>
