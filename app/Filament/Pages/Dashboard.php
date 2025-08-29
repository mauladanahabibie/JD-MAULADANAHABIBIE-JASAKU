<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Filament\Actions\Action;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notification;

class Dashboard extends \Filament\Pages\Dashboard

{
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament.pages.dashboard';

      protected function getHeaderActions(): array
    {
        return [
            Action::make('refresh')
                ->label('Refresh Data')
                ->action(fn() => $this->redirect($this->getUrl())),

            Action::make('Website')
                ->label('Go to Website')
                ->icon('heroicon-o-globe-alt')
                ->url('/')
                ->color('primary'),
        ];
    }
    protected function getWelcomeNotification(): array
    {
        return [
            Notification::make()
                ->title('Selamat Datang!')
                ->body('Hai, ' . Auth::user()->name . '! Anda telah berhasil masuk.')
                ->success(),
        ];
    }
}
