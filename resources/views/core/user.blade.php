@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">

            <div class="col-md-12">

                <div class="card">
                    <div class="card-header">{{ __('User List') }}</div>
                    <div class="card-body">
                        <div id="user"></div>





                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="{{ asset('js/user.js') }}"></script>
@endsection
