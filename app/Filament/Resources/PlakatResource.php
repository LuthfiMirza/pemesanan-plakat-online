<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlakatResource\Pages;
use App\Models\Plakat;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;


class PlakatResource extends Resource
{
    protected static ?string $model = Plakat::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('nama')
                ->required()
                ->label('Nama Plakat')
                ->placeholder('Masukkan nama plakat'),

            Textarea::make('deskripsi')
                ->required()
                ->label('Deskripsi')
                ->placeholder('Masukkan deskripsi plakat'),

            TextInput::make('harga')
                ->required()
                ->numeric()
                ->prefix('Rp')
                ->label('Harga')
                ->placeholder('Masukkan harga'),

            FileUpload::make('gambar')
                ->required()
                ->image()
                ->directory('plakat-images')
                ->label('Gambar Plakat'),

            TextInput::make('kategori')
                ->required()
                ->label('Kategori')
                ->placeholder('Masukkan kategori plakat'),

            Toggle::make('status')
                ->label('Status')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama')
                    ->searchable(),
                Tables\Columns\TextColumn::make('harga')
                    ->money('idr')
                    ->sortable(),
                Tables\Columns\ImageColumn::make('gambar'),
                Tables\Columns\TextColumn::make('kategori')
                    ->searchable(),
                Tables\Columns\IconColumn::make('status')
                    ->boolean(),
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
            'index' => Pages\ListPlakats::route('/'),
            'create' => Pages\CreatePlakat::route('/create'),
            'edit' => Pages\EditPlakat::route('/{record}/edit'),
        ];
    }
}
