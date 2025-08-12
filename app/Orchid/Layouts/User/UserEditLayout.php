<?php

declare(strict_types=1);

namespace App\Orchid\Layouts\User;

use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Rows;
use Orchid\Screen\Fields\Select;

class UserEditLayout extends Rows
{
    /**
     * The screen's layout elements.
     *
     * @return Field[]
     */
    public function fields(): array
    {
        return [
            Input::make('user.name')
                ->type('text')
                ->max(255)
                ->required()
                ->title(__('Name'))
                ->placeholder(__('Name')),

            Input::make('user.email')
                ->type('email')
                ->required()
                ->title(__('Email'))
                ->placeholder(__('Email')),


            Select::make('user.gender') // Using Select::make for user type
                ->options([
                    'male' => __('Male'),
                    'female' => __('Female'),
                ])
                ->required()
                ->title(__('Gender')),

            // Input::make('user.gender')
            //     ->type('select')
            //     ->options([
            //         'male' => __('Male'),
            //         'female' => __('Female'),
            //         'other' => __('Other'),
            //     ])
            //     ->required()
            //     ->title(__('Gender')),

            Input::make('user.contact_no')
                ->type('text')
                ->max(15) // Adjust max length as needed
                ->required()
                ->title(__('Contact Number'))
                ->placeholder(__('Contact Number')),

            Input::make('user.address')
                ->type('text')
                ->max(255)
                ->title(__('Address'))
                ->placeholder(__('Address')),

            Input::make('user.total_referred_users')
                ->type('number')
                ->title(__('Total Referred Users'))
                ->placeholder(__('Total Referred Users')),

            Input::make('user.dob')
                ->type('date')
                ->title(__('Date of Birth')),

            Select::make('user.usertype') // Using Select::make for user type
                ->options([
                    'user' => __('User'),
                    'admin' => __('Admin'),
                ])
                ->required()
                ->title(__('User Type')),

            // Input::make('user.referral_id')
            //     ->type('text')
            //     ->title(__('Referral ID'))
            //     ->placeholder(__('Referral ID')),
        ];
    }
}
