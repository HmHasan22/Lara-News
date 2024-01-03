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
                    <h1 class="">Edit News</h1>
                </div>
                <div>
                    @if(auth()->check())
                        <a href="{{route('news.add')}}" class="btn btn-primary">Create News</a>
                    @else
                        <a href="{{route('login')}}" class="btn btn-primary">Login to create news</a>
                    @endif
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{route('news.update',['id'=>$news->id])}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select name="category_id" id="category" class="form-control">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{$category->id}}" {{$news->category_id == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                <div class="mb-3">
                                    <label for="title" class="form-label">News Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="{{$news->title}}">
                                    @error('title')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="content" class="form-label">News Content</label>
                                    <textarea class="form-control" id="editor" name="content" rows="5">{{$news->content}}</textarea>
                                    @error('content')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <img id="image" src="{{asset($news->image)}}" width="100px" height="100px" style="object-fit: cover" alt="Image">
                                <div class="mb-3">
                                    <label for="image" class="form-label">News Image</label>
                                    <input type="file" class="form-control" id="image-input" name="image">
                                    @error('image')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary w-100">Update News</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.getElementById('image-input').addEventListener('change',function (e){
            let image = document.getElementById('image');
            image.classList.remove('d-none');
            image.src = URL.createObjectURL(e.target.files[0]);
        })
    </script>
@endsection

