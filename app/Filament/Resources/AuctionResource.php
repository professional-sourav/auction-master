<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AuctionResource\Pages;
use Filament\Actions;
use App\Models\Auction;
use BackedEnum;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AuctionResource extends Resource
{
    protected static ?string $model = Auction::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-scale';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('seller_id')
                    ->relationship('seller', 'name', fn ($query) => $query->where('role', 'seller'))
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('type')
                    ->options([
                        'timed' => 'Timed',
                        'live' => 'Live',
                    ])
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'live' => 'Live',
                        'ended' => 'Ended',
                        'suspended' => 'Suspended',
                    ])
                    ->required(),
                Forms\Components\Textarea::make('description')
                    ->columnSpanFull(),
                Forms\Components\DateTimePicker::make('start_time'),
                Forms\Components\DateTimePicker::make('end_time'),
                Forms\Components\TextInput::make('starting_price')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('min_increment')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('reserve_price')
                    ->numeric(),
                Forms\Components\TextInput::make('buy_now_price')
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable(),
                Tables\Columns\TextColumn::make('seller.name')->label('Seller')->searchable(),
                Tables\Columns\TextColumn::make('type')->badge(),
                Tables\Columns\TextColumn::make('status')->badge(),
                Tables\Columns\TextColumn::make('starting_price')->money('USD'),
                Tables\Columns\TextColumn::make('currentBid.amount')->label('Current Bid')->money('USD'),
                Tables\Columns\TextColumn::make('start_time')->dateTime(),
                Tables\Columns\TextColumn::make('end_time')->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'timed' => 'Timed',
                        'live' => 'Live',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'live' => 'Live',
                        'ended' => 'Ended',
                        'suspended' => 'Suspended',
                    ]),
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
            'index' => Pages\ListAuctions::route('/'),
            'create' => Pages\CreateAuction::route('/create'),
            'edit' => Pages\EditAuction::route('/{record}/edit'),
        ];
    }
}

