@extends('layouts.app')

@section('content')
<div class="container">
    <form action="{{ route('profile.update', $user->profile->id) }}" enctype="multipart/form-data" method="post">
        @csrf
        @method('patch')
        <div class="row">
            <div class="col-8 offset-2">

                <div class="row">
                    <h1>Edit Profile</h1>
                </div>

                <div class="form-group row">
                    <label for="biography" class="col-md-4 col-form-label">Biography</label>

                    <input id="biography" 
                           type="text" 
                           name="biography"
                           class="form-control @error('biography') is-invalid @enderror" 
                           value="{{ old('biography') ?? $user->profile->biography}}" 
                           autocomplete="biography" autofocus>

                    @error('biography')
                         <strong>{{ $message }}</strong>
                    @enderror
                </div>

                <div class="form-group row">
                    <label for="profession" class="col-md-4 col-form-label">Profession</label>

                    <input id="profession" 
                           type="text" 
                           name="profession"
                           class="form-control @error('profession') is-invalid @enderror" 
                           value="{{ old('profession') ?? $user->profile->profession }}" 
                           autocomplete="profession" autofocus>

                    @error('profession')
                         <strong>{{ $message }}</strong>
                    @enderror
                </div> 

<!--                 <div class="row">
                <label for="image" class="col-md-4 col-form-label">Profile Image</label>
                    <input type="file" name="image" class="form-control-file" id="image">

                    @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div> -->

                <div class="row pt-2">
                    <button class="btn btn-info">Save</button>
                </div>

            </div>
        </div>
    </form>
</div>
@endsection
