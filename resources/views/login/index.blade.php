@extends('layouts.main')

@section('container')
    <div class="row justify-content-center my-5">
        <div class='col-md-4'>

            <!-- register sukses -->
            @if(session()->has('success'))
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                {{ session ('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <!-- email/pass tidak terdaftar -->
            @if(session()->has('loginError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session ('loginError') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endif

            <main class="form-signin">
            <h1 class="font-mono">Please Login</h1>
                <form action="/login" method="post">
                    @csrf
                    <div class="form-floating mt-4">
                        <input type="email" name="email" class="form-control @error('email') salah @enderror" id="email" placeholder="name@example.com" autofocus required value="{{ old('email') }}">
                        <label for="email">Email address</label>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message}}
                        </div>
                        @enderror
                    </div>
                    <div class="form-floating">
                        <input type="password" name="password" class="form-control @error('password') salah @enderror" id="floatingPassword" placeholder="Password" required>
                        <label for="floatingPassword">Password</label>
                    </div>
                    <button class="w-100 btn btn-lg btn-primary my-3" type="submit">Login</button>
                </form>
                <p>Not registered? <a href="/register">Register Now!</a></p>
            </main>
        </div>
    </div>
@endsection