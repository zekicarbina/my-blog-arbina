@extends('layouts.app')
@section('content')
    <head>
        <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
    </head>
    <div class="container-fluid">
        <h1 class="text-black-50">Create Post</h1>
    </div><br>

    <div class="form-group">
        <label for="post-create-title">Title</label>
        <input type="text" class="form-control" id="post-create-title" placeholder="Enter Title" required>
        <br>

        <label for="post-create-short">Short</label>
        <input type="text" class="form-control" id="post-create-short" placeholder="Enter Short Description" required>
        <br>

        <label for="post-create-slug">Slug</label>
        <input type="text" class="form-control" id="post-create-slug" placeholder="Enter Slug" required>
        <br>

        <label for="post-create-picture">Picture</label>
        <input type="text" class="form-control" id="post-create-picture" placeholder="Enter Link for Image" required>
        <br>
    </div>

    <label for="post-create">Content</label>
    <textarea name="post-create" id="post-create" rows="5" cols="50"
              hidden>
                    </textarea>
    <br>
    <button type="button"
            class="btn bg-gradient-primary"
            onClick="submitNewPost();">
        Submit
    </button>
    <br>

@endsection

@section('third_party_scripts')
    {{-- Submit new Post --}}
    <script>
        CKEDITOR.replace("post-create");
        {{-- Submit Changes--}}
        function submitNewPost() {
            let content = CKEDITOR.instances["post-create"].getData();

            console.log($('#post-create-title').val());

            $.ajax({
                url: "{{route('createPost.submit')}}",
                type: "PUT",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'content': content,
                    'title': $('#post-create-title').val(),
                    'short': $('#post-create-short').val(),
                    'slug': $('#post-create-slug').val(),
                    'picture': $('#post-create-picture').val(),
                },
                success: function (r) {
                    document.location.href="{{route('myPosts')}}";
                },
                failure: function (r) {
                },
            });
        }
    </script>
@endsection
