@extends("layouts.main")

@section('container')

    <main class="form-signin">
    <h1>Form Registration</h1>
        <form action="/register" method='post'>
            @csrf
            <div class="form-floating mt-4">
                <input type="text" name="name" class="form-control @error('name') salah @enderror" id="name" placeholder="Name" required value = "{{old('name')}}">
                <label for="name">Name</label>
                @error('name')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @enderror
            </div>
            <div class="form-floating">
                <input type="text" name="username" class="form-control @error('username') salah @enderror" id="username" placeholder="Username" required value = "{{old('username')}}">
                <label for="username">Username</label>
                @error('username')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @enderror
            </div>
            <div class="form-floating">
                <input type="email" name="email" class="form-control @error('email') salah @enderror" id="email" placeholder="name@example.com" required value = "{{old('email')}}">
                <label for="email">Email address</label>
                @error('email')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @enderror
            </div>
            <div class="form-floating">
                <input type="password" name="password" class="form-control @error('password') salah @enderror" id="password" placeholder="Password" required>
                <label for="password">Password</label>
                @error('password')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @enderror
            </div>
            <button class="w-100 btn btn-lg btn-primary my-3" type="submit">Register</button>
        </form>
        <p>Already registered? <a href="/login">Login</a></p>
    </main>
@endsection