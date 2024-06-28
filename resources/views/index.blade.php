@include('includes.header')

<div class="row mt-4 ml-4 mr-4">
    @foreach ($tours as $index => $tour)
        <div class="col-md-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h2 class="card-title">{{ $tour->name }}</h2>
                    <p class="card-text">Путь: {{ $tour->from }} - {{ $tour->to }}</p>
                    <p class="card-text">Мест: {{ $tour->max_people }}</p>
                    <p class="card-text">Дата: {{ $tour->date }}</p>
                    <p class="card-text">Цена: {{ $tour->price }} руб.</p>
                    @auth
                        <form action="{{ route('tour.buy', $tour) }}" method="POST" class="d-flex flex-column align-items-start" style="margin-left: 10px;">
                            @csrf
                            <div class="form-check">
                                <input type="radio" name="paymentMethod" id="card" value="card" class="form-check-input" required>
                                <label for="card" class="form-check-label">Оплатить картой</label>
                            </div>
                            <div class="form-check">
                                <input type="radio" name="paymentMethod" id="cash" value="cash" class="form-check-input" required>
                                <label for="cash" class="form-check-label">Оплатить наличными</label>
                            </div>
                            <button type="submit" class="btn btn-success">Купить</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>

        @if (($index + 1) % 3 == 0 && $index != count($tours) - 1)
            </div>
            <div class="row">
        @endif
    @endforeach
</div>

@include('includes.footer')