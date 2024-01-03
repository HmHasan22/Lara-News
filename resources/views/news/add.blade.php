@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">

                <div class="card">
                    <div class="card-header">
                          Add News
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{route('news.store')}}" enctype="multipart/form-data">
                            @csrf
{{--                            load categories--}}
                            <div class="mb-3">
                                <label class="form-label" for="category">
                                    Category
                                </label>
                                <select name="category_id" id="category" class="form-control">
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{old('category_id') == $category->id ? 'selected' : ''}}>{{$category->name}}</option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="title">Title</label>
                                <input type="text" id="title" name="title" class="form-control" value="{{old('title')}}">
                                @error('title')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="content">Content</label>
                                <textarea name="content" id="content" class="form-control" rows="5">{!!old('content')!!}</textarea>
                                @error('content')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <img id="image" class="d-none" src="" width="100px" height="100px" style="object-fit: cover" alt="Image">
                            <div class="mb-3">
                                <label class="form-label" for="Image">Image</label>
                                <input type="file" id="image-input" accept="images/*" name="image" class="form-control">
                                @error('image')
                                <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-success w-100">Add</button>
                            </div>
                        </form>
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
