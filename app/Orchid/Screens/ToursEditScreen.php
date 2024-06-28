<?php

namespace App\Orchid\Screens;

use App\Models\Tour;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Support\Facades\Layout;
use Orchid\Support\Facades\Alert;

class ToursEditScreen extends Screen
{
    public $tour;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Tour $tour): iterable
    {
        return [
            'tour' => $tour
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->tour->exists
            ? 'Edit Tour'
            : 'Create Tour';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Create tour')
                ->icon('pencil')
                ->method('createOrUpdate')
                ->canSee(!$this->tour->exists),

            Button::make('Update')
                ->icon('note')
                ->method('createOrUpdate')
                ->canSee($this->tour->exists),

            Button::make('Remove')
                ->icon('trash')
                ->method('remove')
                ->canSee($this->tour->exists),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('tour.name')
                    ->title('Name')
                    ->placeholder('Attractive name')
                    ->help('Specify the name of the tour'),

                Input::make('tour.from')
                    ->title('From')
                    ->placeholder('From')
                    ->help('Specify the starting point of the tour'),

                Input::make('tour.to')
                    ->title('To')
                    ->placeholder('To')
                    ->help('Specify the ending point of the tour'),

                Input::make('tour.max_people')
                    ->title('Max people')
                    ->type('number')
                    ->placeholder('Max people')
                    ->help('Specify the maximum number of people allowed on the tour'),

                Input::make('tour.date')
                    ->title('Date')
                    ->type('date')
                    ->placeholder('Date')
                    ->help('Specify the ending date of the tour'),

                Input::make('tour.price')
                    ->title('Price')
                    ->type('number')
                    ->placeholder('Price')
                    ->help('Specify the price of the tour'),
            ])
        ];
    }

    public function createOrUpdate(Request $request)
    {
        $this->tour->fill($request->get('tour'))->save();

        Alert::info('You have successfully created a tour.');

        return redirect()->route('platform.tour.list');
    }

    public function remove()
    {
        $this->tour->delete();

        Alert::info('You have successfully deleted the tour.');

        return redirect()->route('platform.tour.list');
    }
}
