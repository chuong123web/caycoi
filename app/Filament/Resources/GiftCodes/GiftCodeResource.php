<?php

namespace App\Filament\Resources\GiftCodes;

use App\Filament\Resources\GiftCodes\Pages\CreateGiftCode;
use App\Filament\Resources\GiftCodes\Pages\EditGiftCode;
use App\Filament\Resources\GiftCodes\Pages\ListGiftCodes;
use App\Filament\Resources\GiftCodes\Pages\ViewGiftCode;
use App\Filament\Resources\GiftCodes\Schemas\GiftCodeForm;
use App\Filament\Resources\GiftCodes\Schemas\GiftCodeInfolist;
use App\Filament\Resources\GiftCodes\Tables\GiftCodesTable;
use App\Models\GiftCode;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GiftCodeResource extends Resource
{
    protected static ?string $model = GiftCode::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTicket;

    protected static string | \UnitEnum | null $navigationGroup = 'Bán hàng';
    protected static ?string $navigationLabel = 'Mã giảm giá';
    protected static ?string $modelLabel = 'Mã giảm giá';
    protected static ?string $pluralModelLabel = 'Mã giảm giá';
    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'code';

    public static function form(Schema $schema): Schema
    {
        return GiftCodeForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return GiftCodeInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GiftCodesTable::configure($table);
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
            'index' => ListGiftCodes::route('/'),
            'create' => CreateGiftCode::route('/create'),
            'view' => ViewGiftCode::route('/{record}'),
            'edit' => EditGiftCode::route('/{record}/edit'),
        ];
    }
}
