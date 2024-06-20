@include('includes.header')

<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Регистрация</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                            <label for="name">Имя</label>
                            <input type="text" class="form-control" id="name" placeholder="Введите имя" required name="user[name]">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="Введите почту" required name="user[email]">
                        </div>

                        <div class="form-group">
                            <label for="password">Пароль</label>
                            <input type="password" class="form-control" id="password" placeholder="Введите пароль" required name="user[password]">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Подтверждение пароля</label>
                            <input type="password" class="form-control" id="password_confirmation" placeholder="Повторите пароль" required name="user[password_confirmation]">
                        </div>

                        <button type="submit" class="btn btn-primary">Зарегистироваться</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if($errors -> any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors -> all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@include('includes.footer')