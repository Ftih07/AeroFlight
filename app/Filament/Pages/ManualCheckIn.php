<?php

namespace App\Filament\Pages;

use App\Models\Booking;
use Filament\Pages\Page;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
// 👇 IMPORT SCHEMA, BUKAN FORM 👇
use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use UnitEnum;
use BackedEnum;

class ManualCheckIn extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-qr-code';
    protected static string|UnitEnum|null $navigationGroup = '2. Flight Operations';
    protected static ?string $title = 'Scan / Manual Check-In';

    protected string $view = 'filament.pages.manual-check-in';

    public ?array $data = [];
    public ?Booking $booking = null;

    public function mount(): void
    {
        $this->form->fill();
    }

    // 👇 UBAH FORM JADI SCHEMA DI SINI 👇
    public function form(Schema $schema): Schema
    {
        return $schema
            // 👇 UBAH ->schema() JADI ->components() 👇
            ->components([
                TextInput::make('token')
                    ->label('QR Token Ticket')
                    ->placeholder('Ketik atau paste token (misal: AERO-XXXXXX-...)')
                    ->required()
                    ->autofocus()
                    ->helperText('Gunakan alat scanner barcode, atau ketik token secara manual.'),
            ])
            ->statePath('data');
    }

    public function submit()
    {
        $token = $this->form->getState()['token'];

        $this->booking = Booking::with(['user', 'flight', 'passengers'])
            ->where('qr_token', $token)
            ->first();

        if (!$this->booking) {
            Notification::make()
                ->title('Tiket Tidak Ditemukan')
                ->body('Token QR tidak valid atau tidak dikenali sistem.')
                ->danger()
                ->send();

            $this->form->fill();
        }
    }

    public function confirmBoarding()
    {
        if (!$this->booking) return;

        if (!in_array($this->booking->status, ['paid', 'confirmed'])) {
            Notification::make()
                ->title('Invalid Ticket!')
                ->body('Status tiket saat ini adalah: ' . strtoupper($this->booking->status))
                ->danger()
                ->send();
            return;
        }

        $this->booking->update(['status' => 'used']);

        Notification::make()
            ->title('Check-in Berhasil!')
            ->body('Penumpang telah dikonfirmasi boarding.')
            ->success()
            ->send();

        $this->booking = null;
        $this->form->fill();
    }
}
