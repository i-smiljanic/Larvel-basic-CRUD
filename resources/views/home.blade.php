<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
</head>
<body>

    {{-- @auth block: everything inside only shows if the user is logged in --}}
    @auth
        <p>You are logged in!</p>

        {{-- Logout form — uses POST with DELETE spoofing not needed here, just POST is fine --}}
        <form action="/logout" method="POST">
            @csrf
            <button>Log out</button>
        </form>

        {{-- Section for creating a new post --}}
        <div style="border: 3px solid black;">
            <h2>Create a new post</h2>
            <form action="/create-post" method="POST">
                @csrf
                <input type="text" name="title" placeholder="title">
                <textarea name="body" placeholder="body content ..."></textarea>
                <button>Save Post</button>
            </form>
        </div>

        {{-- Section for displaying all posts --}}
        <div style="border: 3px solid black;">
            <h2>All posts</h2>

            {{-- Loop through each post passed from the controller --}}
            @foreach ($posts as $post)
                <div style="background-color: gray; padding:10px; margin:10px">

                    {{-- Display the post title and the name of the user who wrote it --}}
                    {{-- $post->user->name uses the belongsTo relationship defined in the Post model --}}
                    <h3>{{$post['title']}} by {{$post->user->name}}</h3>

                    {{-- Display the post body content --}}
                    {{$post['body']}}

                    {{-- Link to the edit page for this specific post --}}
                    <p><a href="/edit-post/{{$post->id}}">Edit</a></p>

                    {{-- Delete form — uses @method('DELETE') since browsers only support GET/POST --}}
                    <form action="/delete-post/{{$post->id}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button>Delete</button>
                    </form>

                </div>
            @endforeach

        </div>

    {{-- @else block: everything inside only shows if the user is NOT logged in --}}
    @else

        {{-- Registration form --}}
        <div style="border: 3px solid black;">
            <h2>Register</h2>
            <form action="/register" method="POST">
                @csrf
                <input name="name" type="text" placeholder="name">
                <input name="email" type="text" placeholder="email">
                <input name="password" type="password" placeholder="password">
                <button>Register</button>
            </form>
        </div>

        {{-- Login form --}}
        <div style="border: 3px solid black;">
            <h2>Login</h2>
            <form action="/login" method="POST">
                @csrf
                <input name="loginname" type="text" placeholder="name">
                <input name="loginpassword" type="password" placeholder="password">
                <button>Log in</button>
            </form>
        </div>

    {{-- End of the @auth / @else block --}}
    @endauth

</body>
</html>