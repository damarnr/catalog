<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class ManageSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Pengaturan Situs';

    protected static ?string $title = 'Pengaturan Situs';

    protected static string $view = 'filament.pages.manage-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill(Setting::current()->toArray());
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Identitas Brand')
                    ->schema([
                        Forms\Components\TextInput::make('brand_name')
                            ->label('Nama Brand')
                            ->required(),
                        Forms\Components\TextInput::make('tagline')
                            ->label('Tagline'),
                        Forms\Components\FileUpload::make('logo')
                            ->image()
                            ->disk('public')
                            ->directory('logo')
                            ->visibility('public'),
                    ])->columns(2),

                Forms\Components\Section::make('Kontak & Sosial Media')
                    ->schema([
                        Forms\Components\TextInput::make('whatsapp')
                            ->label('Nomor WhatsApp')
                            ->helperText('Format 628xxxxxxxxxx, tanpa tanda + atau spasi'),
                        Forms\Components\TextInput::make('instagram')
                            ->label('Instagram')
                            ->helperText('Username saja, tanpa @'),
                        Forms\Components\TextInput::make('email')
                            ->label('Email')
                            ->email(),
                        Forms\Components\Textarea::make('address')
                            ->label('Alamat')
                            ->rows(2),
                    ])->columns(2),

                Forms\Components\Section::make('Tentang Kami')
                    ->schema([
                        Forms\Components\Textarea::make('about')
                            ->label('Cerita brand')
                            ->rows(8)
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        Setting::current()->update($this->form->getState());

        Notification::make()
            ->title('Pengaturan disimpan')
            ->success()
            ->send();
    }
}