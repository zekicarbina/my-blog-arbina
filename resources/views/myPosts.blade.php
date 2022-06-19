@extends('layouts.app')
@section('content')
    <head>
        <script src="{{asset('ckeditor/ckeditor.js')}}"></script>
    </head>
    <div class="container-fluid">
        <h1 class="text-black-50">Your Posts</h1>
    </div>

    <table class="table table-bordered table-hover">
        <thead>
        <tr>
            <th>#</th>
            <th>Title</th>
            @if($admin)
                <th>Author</th>
            @endif
            <th>Publish Date</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($posts as $postData)
            <tr data-widget="expandable-table" aria-expanded="false">
                <td>{{$postData->id}}</td>
                <td>{{$postData->title}}</td>
                @if($admin)
                    <td
                    @if($postData->user_id == $currentUserId)
                        style="color: red"
                        @endif
                    >{{$postData->authorUsername}}</td>
                @endif
                <td>{{$postData->published_at}}</td>
                <td>
                    <form method="POST" action="{{route('deletePost', ['postId' => $postData->id])}}"
                          id="{{$postData->id}}">
                        @csrf
                        @method('put')
                        <input id="deleteButton" type="submit" class="btn btn-danger"
                               value="Delete"/>
                    </form>

                    @if($admin && $postData->user_id != $currentUserId)
                        <form method="POST" action="{{route('deleteUser', ['userId' => $postData->user_id])}}"
                              id="{{$postData->user_id}}">
                            @csrf
                            @method('put')
                            <input id="deleteUserButton" type="submit" class="btn btn-danger"
                                   value="Delete User"/>
                        </form>
                    @endif
                </td>
            </tr>
            <tr class="expandable-body d-none">
                <td colspan="4">
                    <textarea name="post-edit-{{$postData->id}}" id="post-edit-{{$postData->id}}" rows="5" cols="50"
                              hidden>
                        {{$postData->content}}
                    </textarea>
                    <button type="button"
                            class="btn btn-block bg-gradient-primary"
                            onClick="submitChanges({{$postData->id}});">
                        Edit
                    </button>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

@section('third_party_scripts')
    {{-- CK Editor--}}
    @foreach($posts as $postData)
        <script>
            CKEDITOR.replace("post-edit-{{$postData->id}}");
        </script>
    @endforeach

    {{-- Submit Changes--}}
    <script>
        function submitChanges(postId) {
            let content = CKEDITOR.instances["post-edit-" + postId].getData();
            console.log(content);

            $.ajax({
                url: "{{route('editPost')}}",
                type: "PUT",
                data: {
                    '_token': '{{ csrf_token() }}',
                    'postId': postId,
                    'content': content,
                },
                success: function (r) {
                },
                failure: function (r) {
                },
            });
        }
    </script>
@endsection
