@extends('layouts.app')
@section('content')
   <div class="container">
       <div class="row justify-content-center">
           <div class="col-lg-8 col-md-8 col-12 mt-4">
               @if(session('success'))
                   <div class="alert alert-success alert-dismissible fade show" role="alert">
                       {{session('success')}}
                       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>
                @endif
               <a href="{{route('news.index')}}" class="btn btn-primary mb-4">Back</a>
                <div class="card">
                    <div class="card-body">
                        <img class="img-fluid" src="{{asset($news->image)}}" alt="image">
                        <h1 class="mt-4 ">{{$news->title}}</h1>
                        <div class="d-flex justify-content-between align-items-center">
                            <p>Posted on :  {{date_format($news->created_at,'m-d-y')}}</p>
                            <p>Author : {{$news->user->name}}</p>
                        </div>
                        <p class="lead">{{$news->content}}</p>
                    </div>
                    <div class="card-footer">
                        @if(auth()->user())
                            <form action="{{route('comment.store')}}" method="post">
                                @csrf
                                <div class="mb-3">
                                    <input type="hidden" name="news_id" value="{{$news->id}}">
                                    <input type="hidden" name="slug" value="{{$news->slug}}">
                                    <label for="comment" class="form-label">Comment</label>
                                    <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                                    <div class="text-danger mt-2">
                                        @error('comment')
                                        {{$message}}
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Comment</button>
                            </form>
                        @else
                           <div>
                                 <a href="{{route('login')}}" class="btn btn-primary">Login to comment</a>
                           </div>
                        @endif
                    </div>
                </div>
{{--               comments--}}

               <div class="">
               <div class="comment-cart mt-4">
                   <h3>Comments</h3>
               @forelse($comments as $comment)
                      <div class="single_comment_item">
                         <div>
                             <h5 class="mb-0">{{$comment->user->name}}</h5>
                            <div>
                                <p>{{$comment->comment}}</p>

                            </div>
                         </div>
                         <div>
                             <p>{{$comment->created_at ? date_format($comment->created_at,'m-d-y') : ''}}</p>
                             @if(auth()->user())
                                 @if(auth()->user()->id == $comment->user_id)
                                     <form action="{{route('comment.delete')}}" method="post">
                                         @csrf
                                         <input type="hidden" name="id" value="{{$comment->id}}">
                                         <input type="hidden" name="slug" value="{{$news->slug}}">
                                         <button type="submit mt-1" class="btn btn-danger btn-sm">Delete</button>
                                     </form>
                                 @endif
                             @endif
                         </div>
                      </div>
               @empty
                   <p>No comments yet</p>
               @endforelse
               </div>
               </div>
           </div>
       </div>
   </div>
@endsection
