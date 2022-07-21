<div class="container-fluid pt-4 px-4">
    <div class="row">
        @if (session()->has('message'))
            <div wire:poll.4s class="alert alert-success mb-5 mt-5" role="alert">
                {{ session('message') }}
            </div>
        @endif
        <div class="col-xl-4">
            <div class="bg-secondary text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Foto User</h6>
                    {{-- <a href="">Show All</a> --}}
                </div>
                <div>
                    <!-- picture-->
                    <div class="text-center">
                        <img class="img-fluid img-account-profile rounded-circle mb-2" style="max-width: 20em; max-height: 15em" src="{{Storage::url("{$profile_pic}")}}?{{ rand() }}" alt="profile_pic">
                        <div class="small font-italic text-muted mb-4">{{$name}}</div>
                    </div>
                    @if ($is_disabled == "")
                        <label class="text-start" for="">Pilih foto</label>
                        <input type="file" class="form-control bg-dark" wire:model="file"  name="file" id="file">
                        <button wire:loading wire:target="file" class="btn btn-primary btn-sm mt-3" type="button" disabled>
                            <span class="spinner-grow spinner-grow-sm" role="status" aria-hidden="true"></span>
                            Uploading...
                        </button>

                        <div class="form-floating mt-3">
                            <textarea wire:model="bio" maxlength="250" class="form-control" placeholder="Leave a comment here" id="floatingTextarea" style="height: 150px;">{{$bio}}</textarea>
                            <label for="floatingTextarea">Biografi</label>
                        </div>

                    @endif
                    @if ($is_disabled != "")
                        <div class="text-start">
                            <h6>Biografi</h6>
                            <p>
                                {{$bio}}
                            </p>
                        </div>
                        
                    @endif
                </div>
                {{-- <canvas id="worldwide-sales" width="856" height="427" style="display: block; box-sizing: border-box; height: 341.6px; width: 684.8px;"></canvas> --}}
            </div>
        </div>
        <div class="col-xl-8">
            <div class="bg-secondary text-start rounded p-4">
                <div class="d-flex align-items-start justify-content-between mb-4">
                    <h6 class="mb-0">Informasi User</h6>
                </div>
                <div>
                    <form>
                        <!-- Form Group (name))-->
                        <div class="mb-3">
                            <label class="small mb-1" for="name">Nama Lengkap</label>
                            <input class="form-control" wire:model="name" id="name" type="text" {{$is_disabled}}>@error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        <!-- Form Row-->
                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label class="small mb-1" for="username">Nama Pengguna</label>
                                <input class="form-control" wire:model="username" id="username" type="text" {{$is_disabled}} >@error('username') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="small mb-1" for="email">Email Pengguna</label>
                                <input class="form-control" wire:model="email" id="email" type="text" {{$is_disabled}} >@error('email') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>
                        
                        <!-- Form Group (password)-->
                        <div class="mb-3">
                            <label class="small mb-1" for="password">Password</label>
                            <input class="form-control" wire:model="password" id="password" {{$is_disabled}} type="password" name="password" >@error('password') <span class="error text-danger">{{ $message }}</span> @enderror
                        </div>
                        @if ($is_disabled == "")
                            <div class="mb-3">
                                <label class="small mb-1" for="second_password">Ketik Ulang Password</label>
                                <input class="form-control" wire:model="second_password" id="second_password" type="password" name="second_password" >@error('second_password') <span class="error text-danger">{{ $message }}</span> @enderror
                            </div>
                        @endif
                        <!-- Save changes button-->
                        <button class="btn btn-primary" wire:click.prevent="update()" type="button">{{$edit_button}}</button>
                        @if ($is_disabled == "")
                            <button class="btn btn-light" wire:click.prevent="clear()" type="button">Batalkan</button>
                        @endif
                    </form>
                </div>
                {{-- <canvas id="salse-revenue" width="856" height="427" style="display: block; box-sizing: border-box; height: 341.6px; width: 684.8px;"></canvas> --}}
            </div>
        </div>
    </div>
</div>
