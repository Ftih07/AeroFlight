<x-filament-panels::page>
    <x-filament::card>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <form wire:submit="submit">
                    {{ $this->form }}
                    <div class="mt-6">
                        <x-filament::button type="submit" size="lg" icon="heroicon-o-magnifying-glass" class="w-full">
                            Cari & Verifikasi Tiket
                        </x-filament::button>
                    </div>
                </form>
            </div>

            <div class="border-2 border-dashed border-gray-300 dark:border-gray-700 rounded-xl p-4 bg-gray-50 dark:bg-gray-900 flex flex-col items-center">

                {{-- Kita kunci lebar maksimal di 280px agar tidak melebar --}}
                <div style="width: 100%; max-width: 400px; margin: 0 auto;" class="overflow-hidden rounded-lg shadow-md border border-gray-200 dark:border-gray-800">
                    <div id="reader" style="width: 100% !important;"></div>
                </div>

                <div class="mt-4 text-center">
                    <div class="flex items-center justify-center gap-2 text-primary-500 font-bold mb-1">
                        <span class="text-xs uppercase tracking-wider">Scanner Active</span>
                    </div>
                    <p class="text-[10px] text-gray-400 italic">Posisikan QR tepat di tengah kotak</p>
                </div>

                {{-- Tambahkan CSS khusus untuk mengecilkan elemen internal library --}}
                <style>
                    #reader video {
                        width: 100% !important;
                        height: auto !important;
                        border-radius: 8px;
                    }

                    /* Mengecilkan tombol-tombol bawaan library kalau muncul */
                    #reader button {
                        padding: 4px 8px !important;
                        font-size: 11px !important;
                        background-color: #3b82f6 !important;
                        color: white !important;
                        border-radius: 4px !important;
                        margin-top: 5px !important;
                    }

                    #reader select {
                        font-size: 11px !important;
                        padding: 2px !important;
                        border-radius: 4px !important;
                    }
                </style>
            </div>
        </div>
    </x-filament::card>

    @if($booking)
    {{-- FORCE LAYOUT MENGGUNAKAN INLINE CSS --}}
    <div style="margin-top: 24px;">
        <x-filament::card style="padding: 0; overflow: hidden; border-top: 4px solid #3b82f6;">

            {{-- HEADER --}}
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 24px; border-bottom: 1px solid #374151; background: rgba(255,255,255,0.02);">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <div style="width: 44px; height: 44px; background: rgba(59, 130, 246, 0.1); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" style="width: 24px; height: 24px; color: #3b82f6;">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 6v.75m0 3v.75m0 3v.75m0 3V18m-9-5.25h5.25M7.5 15h3M3.375 5.25c-.621 0-1.125.504-1.125 1.125v3.026a2.999 2.999 0 0 1 0 5.198v3.026c0 .621.504 1.125 1.125 1.125h17.25c.621 0 1.125-.504 1.125-1.125v-3.026a2.999 2.999 0 0 1 0-5.198V6.375c0-.621-.504-1.125-1.125-1.125H3.375Z" />
                        </svg>
                    </div>
                    <div style="display: flex; flex-direction: column;">
                        <h2 style="font-size: 24px; font-weight: 900; color: white; line-height: 1; margin: 0; text-transform: uppercase;">{{ $booking->pnr_code }}</h2>
                        <p style="font-size: 10px; font-weight: 700; color: #9ca3af; text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">Passenger Name Record</p>
                    </div>
                </div>
                <div style="background: #059669; color: white; font-weight: 800; padding: 4px 12px; border-radius: 9999px; font-size: 12px;">
                    {{ strtoupper($booking->status) }}
                </div>
            </div>

            <div style="padding: 24px;">
                {{-- INI PEMBAGIAN KOLOMNYA - DIPAKSA PAKAI FLEX --}}
                <div style="display: flex; flex-wrap: wrap; gap: 32px; align-items: flex-start;">

                    {{-- KOLOM 1: FLIGHT --}}
                    <div style="flex: 1; min-width: 250px;">
                        <p style="font-size: 11px; font-weight: 800; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #374151; padding-bottom: 8px; margin-bottom: 16px;">Flight Information</p>
                        <div style="position: relative; padding-left: 16px; border-left: 2px solid #3b82f6;">
                            <div style="margin-bottom: 24px;">
                                <p style="font-size: 24px; font-weight: 900; color: white; margin: 0;">{{ $booking->flight->origin_airport }}</p>
                                <p style="font-size: 12px; color: #9ca3af; margin: 0;">{{ $booking->flight->departure_at->format('d M Y, H:i') }}</p>
                            </div>
                            <div style="margin-bottom: 24px;">
                                <p style="font-size: 24px; font-weight: 900; color: white; margin: 0;">{{ $booking->flight->destination_airport }}</p>
                                <p style="font-size: 12px; color: #9ca3af; margin: 0;">{{ $booking->flight->arrival_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    {{-- KOLOM 2: PASSENGERS --}}
                    <div style="flex: 1; min-width: 250px; border-left: 1px solid #374151; border-right: 1px solid #374151; padding: 0 24px;">
                        <p style="font-size: 11px; font-weight: 800; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #374151; padding-bottom: 8px; margin-bottom: 16px;">Passenger Manifest</p>
                        @foreach($booking->passengers as $pax)
                        <div style="background: rgba(255,255,255,0.03); padding: 12px; border-radius: 12px; border: 1px solid #374151; display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                            <div>
                                <p style="font-weight: 700; font-size: 14px; color: white; margin: 0;">{{ $pax->title }}. {{ $pax->first_name }} {{ $pax->last_name }}</p>
                                <p style="font-size: 10px; color: #9ca3af; margin: 4px 0 0 0;">{{ $pax->nationality }} • {{ $pax->passport_number ?? 'ID Card' }}</p>
                            </div>
                            <div style="text-align: right;">
                                <p style="font-size: 8px; font-weight: 900; color: #6b7280; margin: 0;">SEAT</p>
                                <p style="font-size: 18px; font-weight: 900; color: #3b82f6; margin: 0;">{{ $pax->assigned_seats['segment_1'] ?? 'TBA' }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- KOLOM 3: PAYMENT --}}
                    <div style="flex: 1; min-width: 200px;">
                        <p style="font-size: 11px; font-weight: 800; color: #6b7280; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #374151; padding-bottom: 8px; margin-bottom: 16px;">Financial Status</p>
                        <div style="background: rgba(59, 130, 246, 0.05); padding: 16px; border-radius: 16px; border: 1px solid rgba(59, 130, 246, 0.2); text-align: center; margin-bottom: 24px;">
                            <p style="font-size: 10px; font-weight: 800; color: #9ca3af; text-transform: uppercase; margin: 0;">Total Paid</p>
                            <p style="font-size: 32px; font-weight: 900; color: #3b82f6; margin: 8px 0 0 0;">${{ number_format($booking->final_amount_usd, 2) }}</p>
                        </div>

                        @if(in_array($booking->status, ['paid', 'confirmed']))
                        <button wire:click="confirmBoarding" style="width: 100%; background: #059669; color: white; font-weight: 900; padding: 16px; border-radius: 12px; border: none; cursor: pointer; box-shadow: 0 10px 15px -3px rgba(5, 150, 105, 0.3);">
                            CONFIRM BOARDING
                        </button>
                        @endif
                    </div>

                </div>
            </div>
        </x-filament::card>
    </div>
    @endif

    @push('scripts')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            const input = document.querySelector('input[type="text"]');
            if (input) {
                input.value = decodedText;
                input.dispatchEvent(new Event('input'));
                @this.set('data.token', decodedText);
                @this.submit();
            }
        }
        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", {
                fps: 20, // Naikin dikit biar lebih smooth
                qrbox: {
                    width: 200,
                    height: 200
                }, // Sesuaikan dengan container 300px
                aspectRatio: 1.0 // Biar tetap kotak sempurna
            },
            /* verbose= */
            false
        );
        html5QrcodeScanner.render(onScanSuccess);
    </script>
    @endpush
</x-filament-panels::page>