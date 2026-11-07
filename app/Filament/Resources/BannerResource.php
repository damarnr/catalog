<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('subtitle')
                    ->label('Subjudul')
                    ->maxLength(255),
                Forms\Components\FileUpload::make('image')
                    ->label('Gambar Banner')
                    ->helperText('Disarankan gambar landscape, minimal lebar 1600 px.')
                    ->image()
                    ->disk('public')
                    ->directory('banners')
                    ->visibility('public')
                    ->maxSize(4096)
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('link')
                    ->label('Link tombol (opsional)')
                    ->helperText('Contoh: /produk atau /produk?category=kaos. Kosongkan untuk mengarah ke halaman Koleksi.')
                    ->maxLength(255),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Urutan')
                    ->helperText('Angka kecil tampil lebih dulu (0, 1, 2, ...).')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(9999)
                    ->default(0)
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Tampilkan')
                    ->default(true),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Gambar')
                    ->disk('public'),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),
            ])
            ->defaultSort('sort_order')
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}