<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit post</title>
</head>
<body>
    <h1>Edit Post</h1>

    {{-- Form submits to /edit-post/{id} using the post's ID in the URL --}}
    {{-- HTML forms only support GET and POST, so we use POST here --}}
    <form action="/edit-post/{{$post->id}}" method="POST">

        {{-- @csrf adds a hidden security token to prevent cross-site request forgery attacks --}}
        @csrf

        {{-- @method('PUT') tells Laravel to treat this request as a PUT request (for updating) --}}
        @method('PUT')

        {{-- Pre-fill the title input with the current post title so the user can edit it --}}
        <input type="text" name="title" value="{{$post->title}}">

        {{-- Pre-fill the textarea with the current post body so the user can edit it --}}
        <textarea name="body">{{$post->body}}</textarea>

        {{-- Submit button — sends the form data to the server --}}
        <button>Save Changes</button>

    </form>
</body>
</html>