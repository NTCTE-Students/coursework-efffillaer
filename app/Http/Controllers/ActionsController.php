<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActionsController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'user.name' => 'required',
            'user.email' => 'required|email|unique:users,email',
            'user.password' => 'required|min:8|alpha_dash|confirmed',
        ], [
            'user.name.required' => 'Поле "Имя" обязательно для заполнения',
            'user.email.reqired' => 'Поле "Электронная почта" обязательно для заполнения',
            'user.email.email'=> 'Поле "Электронная почта" должно быть предоставлено в виде валидного адреса электронной почты',
            'user.password.required'=> 'Поле "Пароль" обязательно для заполнения',
            'user.password.min'=> 'Поле "Пароль" должно быть не менее, чем 8 символов',
            'user.password.alpha_dash'=> 'Поле "Пароль" должно содержать только строчные и прописные символы латиницы, цифры, а также символы "-" и "_"',
            'user.password.confirmed'=> 'Поле "Пароль" и "Повторите пароль" не совпадает',
        ]);

        $user = User::create($request -> input('user'));
        Auth::login($user);
        return redirect('/');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function login(Request $request)
    {
        $request->validate([
            'user.email'=> 'required|email',
            'user.password'=> 'required|min:8|alpha_dash',
        ], [
            'user.email.reqired' => 'Поле "Электронная почта" обязательно для заполнения',
            'user.email.email'=> 'Поле "Электронная почта" должно быть предоставлено в виде валидного адреса электронной почты',
            'user.password.required'=> 'Поле "Пароль" обязательно для заполнения',
            'user.password.min'=> 'Поле "Пароль" должно быть не менее, чем 8 символов',
            'user.password.alpha_dash'=> 'Поле "Пароль" должно содержать только строчные и прописные символы латиницы, цифры, а также символы "-" и "_"',
        ]);
        if(Auth::attempt($request -> input('user'))) {
            return redirect('/');
        } else {
            return back() -> withErrors([
                'user.email' => 'Предоставленная почта или пароль не подходят'
            ]);
        }
    }

    public function tour_buy(Request $request, Tour $tour)
    {
        $request->validate([
            'paymentMethod' => 'required|in:card,cash',
        ], [
            'paymentMethod.required' => 'Необходимо выбрать способ оплаты',
            'paymentMethod.in' => 'Выбран недопустимый способ оплаты',
        ]);
    
        if($tour->max_people < 1) {
            return back()->with('error', 'Количество мест не может быть меньше 1');
        }
    
        $tour->max_people -= 1; // Предполагаем бронирование на одного человека
        $tour->save();
    
        $booking = new Booking();
        $booking->card = $request->input('paymentMethod') == 'card';
        $booking->tour_id = $tour->id;
        $booking->user_id = Auth::id();
        $booking->save();
    
        return redirect()->route('profile');
    }

    public function booking_review(Request $request, Booking $booking)
    {
        $request->validate([
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ], [
            'comment.required' => 'Поле "Отзыв" обязательно для заполнения',
            'comment.string' => 'Поле "Отзыв" должно быть предоставлено в виде строки',
            'rating.required' => 'Поле "Рейтинг" обязательно для заполнения',
            'rating.integer' => 'Поле "Рейтинг" должно быть предоставлено в виде числа',
            'rating.min' => 'Поле "Рейтинг" должно быть не менее 1',
            'rating.max' => 'Поле "Рейтинг" должно быть не более 5',
        ]);
        
        if($booking->user_id != Auth::id()) {
            return back()->with('error', 'Вы не можете оставить отзыв на этот тур');
        }

        $booking->comment = $request->input('comment');
        $booking->rating = $request->input('rating');
        $booking->save();

        return back();
    }

    public function profile_update(Request $request)
    {
        $request->validate([
            'user.name' => 'required',
            'user.email' => 'required|email|unique:users,email,' . Auth::id(),
            'user.password' => 'nullable|min:8|alpha_dash|confirmed',
        ], [
            'user.name.required' => 'Поле "Имя" обязательно для заполнения',
            'user.email.reqired' => 'Поле "Электронная почта" обязательно для заполнения',
            'user.email.email'=> 'Поле "Электронная почта" должно быть предоставлено в виде валидного адреса электронной почты',
            'user.password.min'=> 'Поле "Пароль" должно быть не менее, чем 8 символов',
            'user.password.alpha_dash'=> 'Поле "Пароль" должно содержать только строчные и прописные символы латиницы, цифры, а также символы "-" и "_"',
            'user.password.confirmed'=> 'Поле "Пароль" и "Повторите пароль" не совпадает',
        ]);

        $user = Auth::user();
        $user->name = $request->input('user.name');
        $user->email = $request->input('user.email');
        if($request->input('user.password')) {
            $user->password = bcrypt($request->input('user.password'));
        }
        $user->save();

        return back();
    }
}
