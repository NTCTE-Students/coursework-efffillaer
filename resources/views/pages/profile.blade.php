@include('includes.header')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="user-info p-4 rounded shadow-sm">
                <div class="text-center">
                    <h2 class="mb-3">Профиль пользователя</h2>
                    <img src="storage/default.jpg" class="img-fluid rounded-circle" alt="Аватар" style="width: 200px; height: 200px;">
                    <br><br>
                    <p><strong>Имя:</strong> {{ Auth::user()->name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#editProfileModal">Редактировать профиль</button>
                </div>
            </div>
            <h2 class="my-4">История покупок</h2>
            @foreach($bookings as $booking)
                <section class="booking-review mt-3 p-3 border rounded">
                    <header class="d-flex justify-content-between align-items-center">
                        <h3>Заказ №{{ $booking->id }}</h3>
                        <span class="badge bg-secondary">{{ $booking->tour->date }}</span>
                    </header>
                    <article class="mt-2">
                        <h4>{{ $booking->tour->name }}</h4>
                        <p>Стоимость: <strong>{{ $booking->tour->price }} руб.</strong></p>
                        @if(is_null($booking->rating))
                            <form action="{{ route('booking.review', $booking->id) }}" method="POST">
                                @csrf
                                <fieldset>
                                    <legend>Оставьте ваш отзыв</legend>
                                    <div class="mb-3">
                                        <textarea name="comment" rows="3" class="form-control" placeholder="Ваш отзыв" required></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <span>Ваша оценка:</span>
                                        <div class="rating">
                                            @for($i = 1; $i <= 5; $i++)
                                                <input type="radio" name="rating" id="rating-{{ $i }}" value="{{ $i }}" {{ old('rating') == $i ? 'checked' : '' }}>
                                                <label for="rating-{{ $i }}" class="ms-1">{{ $i }}</label>
                                            @endfor
                                        </div>
                                    </div>
                                    <button class="btn btn-success">Отправить</button>
                                </fieldset>
                            </form>
                        @else
                            <div class="user-review">
                                <p>Ваш отзыв: <em>{{ $booking->comment }}</em></p>
                                <p>Оценка: <strong>{{ $booking->rating }}/5</strong></p>
                            </div>
                        @endif
                    </article>
                </section>
            @endforeach
        </div>
    </div>
</div>

<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editProfileModalLabel">Редактировать профиль</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
          @csrf
          @method('PUT')
          <div class="modal-body">
            <div class="form-group">
              <label for="name">Имя</label>
              <input type="text" class="form-control" id="user[name]" name="user[name]" value="{{ Auth::user()->name }}">
            </div>
            <div class="form-group">
              <label for="email">Email</label>
              <input type="email" class="form-control" id="user[email]" name="user[email]" value="{{ Auth::user()->email }}">
            </div>
            <div class="form-group">
              <label for="password">Пароль</label>
              <input type="password" class="form-control" id="user[password]" name="user[password]">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
          </div>
        </form>
      </div>
    </div>
  </div>

@include('includes.footer')