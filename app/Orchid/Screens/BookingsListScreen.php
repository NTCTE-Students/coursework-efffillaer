<?php

namespace App\Orchid\Screens;

use App\Models\Booking;

use Orchid\Screen\TD;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class BookingsListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'bookings' => Booking::filters()->defaultSort('id')->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Bookings';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::table('bookings', [
                TD::make('user_id', __('User ID'))
                    ->render(function (Booking $booking) {
                        return $booking->user()->first()->name;
                    }),
                TD::make('tour_id', __('Tour'))
                    ->render(function (Booking $booking) {
                        return $booking->tour->name;
                    }),
                TD::make('card', __('Типо оплаты'))
                    ->render(function (Booking $booking) {
                        return $booking->card?'Карта':'Наличные';
                    }),
            ])
        ];
    }
}
