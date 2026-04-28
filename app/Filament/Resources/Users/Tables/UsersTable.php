<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Actions\Action as ActionsAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable()->sortable(),
                TextColumn::make('email')->searchable(),
                TextColumn::make('role')
                    ->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'admin' => 'danger',
                        'customer' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('loyalty_points')->sortable()->numeric(),
                IconColumn::make('two_factor_confirmed_at')
                    ->label('2FA Active')
                    ->boolean()
                    ->getStateUsing(fn($record) => $record->two_factor_confirmed_at !== null),
                TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                ActionsAction::make('reset2fa')
                    ->label('Reset 2FA')
                    ->color('danger')
                    ->icon('heroicon-o-shield-exclamation')
                    ->requiresConfirmation()
                    ->action(function (User $record) {
                        $record->forceFill([
                            'two_factor_secret' => null,
                            'two_factor_recovery_codes' => null,
                            'two_factor_confirmed_at' => null,
                        ])->save();

                        Notification::make()
                            ->title('2FA telah dinonaktifkan untuk user ini')
                            ->success()
                            ->send();
                    })
                    ->visible(fn(User $record) => $record->two_factor_confirmed_at !== null),
            ]);
    }
}
