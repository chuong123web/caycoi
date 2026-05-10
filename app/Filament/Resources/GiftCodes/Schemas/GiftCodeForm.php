<?php

namespace App\Filament\Resources\GiftCodes\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class GiftCodeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Forms\Components\Section::make('Thông tin mã giảm giá')
                    ->schema([
                        TextInput::make('code')
                            ->label('Mã CODE')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                        TextInput::make('discount_amount')
                            ->label('Số tiền giảm (VNĐ)')
                            ->required()
                            ->numeric()
                            ->minValue(0),
                        TextInput::make('max_uses')
                            ->label('Số lượt sử dụng tối đa')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->minValue(1),
                        TextInput::make('used_count')
                            ->label('Số lượt đã dùng')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->disabled(),
                        DateTimePicker::make('expires_at')
                            ->label('Ngày hết hạn'),
                        Toggle::make('is_active')
                            ->label('Trạng thái kích hoạt')
                            ->default(true)
                            ->required(),
                    ])->columns(2),
            ]);
    }
}
