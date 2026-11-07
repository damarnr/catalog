<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    protected static ?string $navigationLabel = 'Produk';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Informasi Produk')
                ->schema([
                    Forms\Components\Select::make('category_id')
                        ->label('Kategori')
                        ->relationship('category', 'name')
                        ->searchable()
                        ->preload()
                        ->required(),
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Produk')
                        ->required()
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, Forms\Set $set) => $set('slug', Str::slug($state))),
                    Forms\Components\TextInput::make('slug')
                        ->label('Slug')
                        ->helperText('Alamat produk di website, terisi otomatis dari nama.')
                        ->required()
                        ->unique(ignoreRecord: true),
                    Forms\Components\TextInput::make('price')
                        ->label('Harga')
                        ->numeric()
                        ->prefix('Rp')
                        ->required(),
                    Forms\Components\Textarea::make('description')
                        ->label('Deskripsi')
                        ->rows(4)
                        ->columnSpanFull(),
                ])->columns(2),

            Forms\Components\Section::make('Varian')
                ->schema([
                    Forms\Components\TagsInput::make('sizes')
                        ->label('Ukuran')
                        ->placeholder('Ketik lalu Enter (S, M, L, XL)'),
                    Forms\Components\TagsInput::make('colors')
                        ->label('Warna')
                        ->placeholder('Ketik lalu Enter (Hitam, Putih)'),
                ])->columns(2),

            Forms\Components\Section::make('Foto & Status')
                ->schema([
                    Forms\Components\FileUpload::make('images')
                        ->label('Foto Produk')
                        ->image()
                        ->multiple()
                        ->reorderable()
                        ->maxFiles(6)
                        ->disk('public')
                        ->directory('products')
                        ->visibility('public')
                        ->columnSpanFull(),
                    Forms\Components\Toggle::make('is_featured')
                        ->label('Produk unggulan'),
                    Forms\Components\Toggle::make('is_active')
                        ->label('Tampilkan di katalog')
                        ->default(true),
                ])->columns(2),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                    ->label('Foto')
                    ->disk('public')
                    ->stacked()
                    ->limit(3),
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Harga')
                    ->money('IDR')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean(),
                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->relationship('category', 'name'),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}