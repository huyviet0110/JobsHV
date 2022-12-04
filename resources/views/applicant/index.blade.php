@extends('layout_frontpage.master');
@section('content')
    <div class="col-md-9">
        <div class="row">
            @foreach ($posts as $post)
                <x-post :post="$post"></x-post>
            @endforeach
        </div>

        <ul class="pagination pagination-info" style="float: right">
            {{ $posts->links() }}
        </ul>
    </div>
@endsection
