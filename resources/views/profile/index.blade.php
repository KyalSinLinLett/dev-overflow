    @extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-baseline mx-3 row border-bottom">
        <h2>Profile of {{ $user->name }}</h2>

        @can('update', $user->profile)
            <strong><a href="/profile/{{$user->id}}/edit">Edit profile</a></strong>
        @endcan
    </div>

   
    
    <div class="row mt-4">
        <div class="col">
            <div class="card p-2" style="border-radius: 1.5rem; box-shadow: 7px 7px 15px -10px rgba(0,0,0,0.48);">
                <div class="row p-2 align-items-center">
                    <div class="col">
                        <div style="text-align: center;">
                            <img src="https://www.pngitem.com/pimgs/m/146-1468479_my-profile-icon-blank-profile-picture-circle-hd.png" class="rounded-circle" width="200">
                        </div>
                        
                        <div class="mt-3 px-2">
                            <h3 class="ml-4"><b>{{ $user->name }}</b></h3>
                            <ul>
                                <li><strong>{{ $user->profile->profession }}</strong></li>
                                <li><strong>{{ $user->profile->biography }}</strong></li>
                            </ul>
                        </div>

                        <!-- follow related table -->
                        <div class="mx-4">
                            <table class="table">
                                <thead>
                                    <tr style="text-align: center;">
                                        <td>Followers</td>
                                        <td>Following</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="text-align: center;">
                                        <td>{{ $user->profile->followers->count() }}</td>
                                        <td>{{ $user->following->count() }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- /follow related table -->
                        <!-- buttons -->
                        <div class="row mb-3">
                            <div class="col-10 offset-1">
                                @if(Auth::id() != $user->id)
                                <div class="d-flex"> 
                                     <follow-component id="{{ $user->id }}" follows="{{ $follows }}"></follow-component>
                                </div>
                                @endif
                            </div>
                        </div>
                        <!-- /buttons -->
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
@endsection
