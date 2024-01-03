@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            @if(session()->has('success'))
                <div class="alert alert-success">
                    <strong>Success!</strong> {{session()->get('success')}}
                </div>
            @endif
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="">All News</h1>
                </div>
                <div>
                   @if(auth()->check())
                        <a href="{{route('news.add')}}" class="btn btn-primary">Create News</a>
                     @else
                        <a href="{{route('login')}}" class="btn btn-primary">Login to create news</a>
                   @endif
                </div>
            </div>
            <div class="row align-items-stretch">
                @forelse($news as $item)
                    <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                        <a class="h-100" href="{{route('news.show',['slug'=>$item->slug])}}">
                            <div class="card h-100">
                                <img src="{{asset($item->image)}}" class="news-image" alt="">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">{{$item->title}}</h5>
                                    <p class="card-text">
                                        {!!Str::limit($item->content,100) !!}
                                    </p>
                                </div>
                                @if($item->user_id == auth()->id())
                                    <div class="card-footer">
                                        <div class="d-flex justify-content-end gap-2 align-items-center">
                                            <div>
                                                <a href="{{route('news.edit',['id'=>$item->id])}}"
                                                   class="btn btn-primary btn-sm">Edit</a>
                                            </div>
                                            <div>
                                                <form action="{{route('news.destroy',['id'=>$item->id])}}"
                                                      method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </a>
                    </div>
                @empty
                    <div class="col-12">
                        <h1 class="text-center mt-5">
                            No news found
                        </h1>
                    </div>
                @endforelse
            </div>
        </div>
        <div class="d-flex justify-content-end mt-4">
            {{$news->links('pagination::bootstrap-4')}}
        </div>
    </div>
@endsection
