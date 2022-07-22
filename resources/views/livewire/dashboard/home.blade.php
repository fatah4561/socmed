<div class="" style="margin-right: 40%;">
    <div class="">

    </div>
    {{-- search --}}
    <nav class="navbar navbar-expand bg-secondary navbar-dark sticky-top px-4 py-0 ms-2 me-2" >
        <input wire:model='search' wire:keydown.enter="searchHash" class="form-control bg-dark border-0" type="search" placeholder="Search">
        <br>
        <br>
        <br>
        {{-- <div class="navbar-nav align-items-center ms-auto">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-envelope me-lg-2"></i>
                    <span class="d-none d-lg-inline-flex">Message</span>
                </a>
                <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                    <a href="#" class="dropdown-item">
                        <div class="d-flex align-items-center">
                            <img class="rounded-circle" src="{{asset("assets/img/user.jpg")}}" alt="" style="width: 40px; height: 40px;">
                            <div class="ms-2">
                                <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                <small>15 minutes ago</small>
                            </div>
                        </div>
                    </a>
                    <hr class="dropdown-divider">
                    <a href="#" class="dropdown-item">
                        <div class="d-flex align-items-center">
                            <img class="rounded-circle" src="{{asset("assets/img/user.jpg")}}" alt="" style="width: 40px; height: 40px;">
                            <div class="ms-2">
                                <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                <small>15 minutes ago</small>
                            </div>
                        </div>
                    </a>
                    <hr class="dropdown-divider">
                    <a href="#" class="dropdown-item">
                        <div class="d-flex align-items-center">
                            <img class="rounded-circle" src="{{asset("assets/img/user.jpg")}}" alt="" style="width: 40px; height: 40px;">
                            <div class="ms-2">
                                <h6 class="fw-normal mb-0">Jhon send you a message</h6>
                                <small>15 minutes ago</small>
                            </div>
                        </div>
                    </a>
                    <hr class="dropdown-divider">
                    <a href="#" class="dropdown-item text-center">See all message</a>
                </div>
            </div>
        </div> --}}
    </nav>
    {{-- <div class="row justify-content-center me-100 sticky-top">
        <div class="container-fluid pt-4 px-4">
            <div class="bg-secondary text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Cari</h6>
                    <a href="">Show All</a>
                </div>
                <div>
                    <div class="form-floating mt-3">
                        <input wire:model='search' wire:keydown.enter="searchHash"  maxlength="50" type="text" class="form-control" placeholder="Find Hashtags" id="floatingTextarea">
                        <label for="floatingTextarea">Cari</label>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    {{-- add --}}
    <div class="row justify-content-center me-100">
        <div class="container-fluid pt-4 px-4">
            <div class="bg-secondary text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">New POST</h6>
                    {{-- <a href="">Show All</a> --}}
                </div>
                <div>
                    @if (session()->has('message'))
                        <div wire:poll.4s class="alert alert-success mb-5 mt-5" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif
                    <form action="" >
                        <div class="form-floating mt-3">
                            <textarea wire:model='new_text'  maxlength="250" class="form-control" placeholder="Leave a comment here" id="floatingTextarea" style="height: 150px;"></textarea>
                            <label for="floatingTextarea">What's Happening?</label>
                        </div>
                        <div class="mb-3 mt-3">
                            <div class="row">
                                <div class="col-lg-auto">
                                    <input wire:model='new_pic' class="form-control  bg-dark" accept="image/*"  type="file">
                                </div>
                                <div class="col-sm-auto" wire:loading wire:target="new_pic">
                                    <button class="btn btn-primary btn-md" type="button" disabled>
                                        <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                        Uploading...
                                    </button>
                                </div>
                                <div wire:loading.remove class="col-md-auto">
                                    <button  wire:click.prevent="post()" type="button" class="btn btn-md btn-outline-primary">Post</button>
                                </div>
                            </div>

                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
    {{-- all post --}}
    @foreach ($posts as $post)
        <div class="row justify-content-center mb-3">
            <div class="container-fluid pt-4 px-4">
                <div class="bg-secondary text-center rounded p-4">
                    <div class="d-flex w-100 position-relative">
                        <img class="rounded-circle flex-shrink-0" src="{{Storage::url($post->user->profile_pic)}}?{{ rand() }}" alt="" style="width: 40px; height: 40px;">
                        <h6 class="ms-2">{{$post->User->name}}</h6>
                        @if (Auth::user()->id == $post->user_id)
                            <div class="btn-group dropend  position-absolute top-0 end-0">
                                <button type="button" class="btn btn-sm btn-outline-primary position-absolute top-0 end-0" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
                                </button>
                                <style>
                                    .dropdown-item:hover {
                                        background: #000000;
                                    }
                                </style>
                                    <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0 navbar-dark bg-primary" data-bs-popper="none">
                                        <a href="#" wire:click.prevent="editPost({{$post->id}})" class="dropdown-item" style="">
                                            <i class="fas fa-edit text-right" style="color: white"></i>
                                            <h6 class="fw-normal mb-0 me-5 text-left" style="display: inline;"> Edit</h6>
                                        </a>
                                        <hr class="dropdown-divider">
                                        <a href="#" wire:click.prevent="destroyPost({{$post->id}})" class="dropdown-item">
                                            <i class="fas fa-trash text-right" style="color: white"></i>
                                            <h6 class="fw-normal mb-0 me-4 text-left" style="display: inline;"> Delete</h6>
                                        </a>
                                        <hr class="dropdown-divider">
                                    </div>
                            </div>
                        @endif
                    </div>
                    {{-- post --}}
                    @if ($edit_post == false || $post->id != $edit_post_id)
                        <p class="mb-0 mt-3 text-start">{{$post->text}}</p>
                        <hr>
                        <div class="d-flex align-items-center justify-content-between mb-4">
                        </div>
                        <div class="form-floating mt-3">
                            <img class="" style="width: 50%; height: auto;" src="{{Storage::url("{$post->picture}")}}?{{ rand() }}" alt="">
                            {{-- <label for="floatingTextarea">What's Happening?</label> --}}
                        </div>
                    @elseif ($edit_post == true && $post->id == $edit_post_id)
                        <form action="" >
                            <div class="form-floating mt-3">
                                <textarea wire:model='update_post_text.{{$post->id}}'  maxlength="250" class="form-control" placeholder="Leave a comment here" id="floatingTextarea" style="height: 150px;"></textarea>
                                <label for="floatingTextarea">New Description</label>
                            </div>
                            <div class="mb-3 mt-3">
                                <div class="row">
                                    <div class="col-lg-auto">
                                        <input wire:model='update_post_pic.{{$post->id}}' class="form-control  bg-dark" accept="image/*"   type="file">
                                    </div>
                                    <div class="col-sm-auto" wire:loading wire:target="update_post_pic.{{$post->id}}">
                                        <button class="btn btn-primary btn-md" type="button" disabled>
                                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                                            Uploading...
                                        </button>
                                    </div>
                                    <div wire:loading.remove class="col-md-auto">
                                        <button  wire:click.prevent="updatePost({{$post->id}})" type="button" class="btn btn-md btn-outline-primary">Update</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    @endif
                    {{-- comment --}}
                    <div>
                        <form action="">
                            {{-- <div class="form-floating mb-3">
                                <input class="form-control form-control-sm" id="floatingTitle" type="text" placeholder="title" aria-label=".form-control-sm example">
                                <label for="floatingTitle">Title</label>
                            </div> --}}

                            <div class="">
                                <div class="h-100 bg-secondary rounded">
                                    <div class="d-flex align-items-center justify-content-between mb-2">
                                        <h6 class="mb-0">Comments</h6>
                                    </div>

                                    @if ($comments->where('post_id', $post->id)->first() == null)
                                        <p class="text-start ms-2"> 
                                            Be the first to comment!
                                        </p>
                                        
                                    @endif

                                    @foreach ($comments->where('post_id', $post->id) as $comment)

                                        <div class="d-flex border-bottom mt-2 mb-2">
                                            <img class="rounded-circle flex-shrink-0" src="{{Storage::url($comment->user->profile_pic)}}?{{ rand() }}" alt="" style="width: 40px; height: 40px;">
                                            <div class="w-100 ms-3 position-relative">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h6 class="mb-0">{{$comment->User->name}}</h6>
                                                    <small class="me-5">{{$comment->created_at}}</small>
                                                </div>
                                                @if ($edit_comment == false || $comment->id != $edit_comment_id)
                                                    <p class="text-start">{{$comment->text}}</p>
                                                    @if (Auth::user()->id == $comment->user_id)
                                                        <div class="btn-group dropend  position-absolute top-0 end-0">
                                                            <button type="button" class="btn btn-sm btn-outline-primary position-absolute top-0 end-0" data-bs-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></button>
                                                            </button>
                                                            <style>
                                                                .dropdown-item:hover {
                                                                    background: #000000;
                                                                }
                                                            </style>
                                                                <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0 navbar-dark bg-primary" data-bs-popper="none">
                                                                    <a href="#" wire:click.prevent="editComment({{$comment->id}})" class="dropdown-item" style="">
                                                                        <i class="fas fa-edit text-right" style="color: white"></i>
                                                                        <h6 class="fw-normal mb-0 me-5 text-left" style="display: inline;"> Edit</h6>
                                                                    </a>
                                                                    <hr class="dropdown-divider">
                                                                    <a href="#" wire:click.prevent="destroyComment({{$comment->id}})" class="dropdown-item">
                                                                        <i class="fas fa-trash text-right" style="color: white"></i>
                                                                        <h6 class="fw-normal mb-0 me-4 text-left" style="display: inline;"> Delete</h6>
                                                                    </a>
                                                                    <hr class="dropdown-divider">
                                                                </div>
                                                        </div>
                                                    @endif
                                                    @if ($comment->picture != null || $comment->picture != "")
                                                        <div class="text-start">
                                                            <img class=" flex-shrink-0 mb-3" src="{{Storage::url($comment->picture)}}?{{ rand() }}" alt="" style="width: 40px; height: 40px;">
                                                        </div>
                                                    @endif
                                                @elseif ($edit_comment == true && $comment->id == $edit_comment_id)
                                                    <div class="">
                                                        <div class="row">
                                                            <div class="col-lg">
                                                                <input maxlength="250" wire:model="update_comment_text.{{$comment->id}}" class="form-control  bg-dark" type="text">
                                                                <input wire:model="update_comment_pic.{{$comment->id}}" class="form-control form-control-sm bg-dark mt-2" accept="image/*"  type="file">
                                                            </div>
                                                            <div class="col-sm-auto mt-3">
                                                                <button wire:click="updateComment({{$comment->id}})" type="button" class="btn btn-outline-primary">Update</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="">
                                <div class="row">
                                    <div class="col-lg">
                                        <input wire:model="posts_detail.{{$post->id}}" class="form-control  bg-dark" maxlength="250" type="text">
                                        <input wire:model="file_comments.{{$post->id}}" class="form-control form-control-sm bg-dark mt-2" accept="image/*"  type="file">
                                    </div>
                                    <div class="col-sm-auto mt-3">
                                        <button wire:click="comment({{$post->id}})" type="button" class="btn btn-outline-primary">Comment</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>