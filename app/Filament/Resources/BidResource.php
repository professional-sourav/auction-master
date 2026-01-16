<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BidResource\Pages;
use Filament\Actions;
use App\Models\Bid;
use BackedEnum;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BidResource extends Resource
{
    protected static ?string $model = Bid::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Select::make('auction_id')
                    ->relationship('auction', 'title')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\TextInput::make('amount')
                    ->numeric()
                    ->required(),
                Forms\Components\Toggle::make('is_auto'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('auction.title')->label('Auction')->searchable(),
                Tables\Columns\TextColumn::make('user.name')->label('Bidder')->searchable(),
                Tables\Columns\TextColumn::make('amount')->money('USD'),
                Tables\Columns\IconColumn::make('is_auto')->boolean(),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->actions([
                Actions\EditAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBids::route('/'),
            'create' => Pages\CreateBid::route('/create'),
            'edit' => Pages\EditBid::route('/{record}/edit'),
        ];
    }
}

