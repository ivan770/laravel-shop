@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(($id = auth()->user()->github_id))
                        GitHub account connected: {{ $id }}
                    @else
                        <form action="{{ route("redirect", ["provider" => "github"]) }}" method="GET">
                            <button type="submit" class="btn btn-primary">
                                Connect GitHub account
                            </button>
                        </form>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
