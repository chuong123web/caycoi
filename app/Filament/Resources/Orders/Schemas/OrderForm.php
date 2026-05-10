<?php

namespace App\Filament\Resources\Orders\Schemas;

use Filament\Schemas\Schema;

class OrderForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Section::make('Thông tin đơn hàng')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('order_number')
                            ->label('Mã đơn hàng')
                            ->required()
                            ->default(fn () => 'ORD-' . strtoupper(uniqid()))
                            ->readOnly(),
                        \Filament\Forms\Components\Select::make('user_id')
                            ->label('Khách hàng (Tài khoản)')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload(),
                        \Filament\Forms\Components\Select::make('status')
                            ->label('Trạng thái')
                            ->options([
                                'pending' => 'Chờ xử lý',
                                'processing' => 'Đang chuẩn bị',
                                'shipped' => 'Đang giao',
                                'delivered' => 'Đã giao',
                                'cancelled' => 'Đã hủy',
                            ])
                            ->required()
                            ->default('pending'),
                        \Filament\Forms\Components\TextInput::make('total_amount')
                            ->label('Tổng tiền (VND)')
                            ->numeric()
                            ->required()
                            ->default(0),
                        \Filament\Forms\Components\Select::make('gift_code_id')
                            ->label('Mã giảm giá')
                            ->relationship('giftCode', 'code')
                            ->searchable()
                            ->preload()
                            ->placeholder('Chọn mã giảm giá (nếu có)'),
                        \Filament\Forms\Components\TextInput::make('discount_amount')
                            ->label('Số tiền giảm (VND)')
                            ->numeric()
                            ->default(0),
                    ])->columns(2),

                \Filament\Schemas\Components\Section::make('Thông tin người nhận')
                    ->schema([
                        \Filament\Forms\Components\TextInput::make('customer_name')
                            ->label('Tên người nhận')
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('customer_email')
                            ->label('Email')
                            ->email()
                            ->required(),
                        \Filament\Forms\Components\TextInput::make('customer_phone')
                            ->label('Số điện thoại')
                            ->tel(),
                        \Filament\Forms\Components\Textarea::make('shipping_address')
                            ->label('Địa chỉ giao hàng')
                            ->required()
                            ->columnSpanFull(),
                        \Filament\Forms\Components\Textarea::make('notes')
                            ->label('Ghi chú')
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
