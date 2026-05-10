<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlantResource\Pages;
use App\Models\Plant;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;

class PlantResource extends Resource
{
    protected static ?string $model = Plant::class;

    protected static string | \BackedEnum | null $navigationIcon = 'heroicon-o-sparkles';

    protected static ?string $navigationLabel = 'Cây Cảnh';

    protected static ?string $modelLabel = 'Cây Cảnh';

    protected static ?string $pluralModelLabel = 'Cây Cảnh';

    protected static string | \UnitEnum | null $navigationGroup = 'Sản Phẩm';

    public static function form(Schema $form): Schema
    {
        return $form
            ->schema([
                \Filament\Schemas\Components\Section::make('Thông tin cơ bản')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Tên (English)')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (Forms\Set $set, ?string $state) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('name_vi')
                            ->label('Tên tiếng Việt')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),

                        Forms\Components\TextInput::make('price')
                            ->label('Giá (VND)')
                            ->required()
                            ->numeric()
                            ->prefix('₫')
                            ->default(0),

                        Forms\Components\Select::make('category')
                            ->label('Danh mục')
                            ->options([
                                'desk' => 'Cây để bàn',
                                'large' => 'Cây lớn',
                                'hanging' => 'Cây treo',
                            ]),

                        Forms\Components\Select::make('light')
                            ->label('Nhu cầu ánh sáng')
                            ->options([
                                'low' => 'Thấp',
                                'medium' => 'Trung bình',
                                'high' => 'Cao',
                            ]),

                        Forms\Components\Select::make('tag')
                            ->label('Nhãn')
                            ->options([
                                'Bán chạy' => 'Bán chạy',
                                'Dễ chăm sóc' => 'Dễ chăm sóc',
                                'Lọc khí' => 'Lọc không khí',
                                'Cây lớn' => 'Cây lớn',
                            ]),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Đang bán')
                            ->default(true),
                    ])->columns(2),

                \Filament\Schemas\Components\Section::make('Mô tả & Chăm sóc')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label('Mô tả')
                            ->rows(4)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('care_instructions')
                            ->label('Hướng dẫn chăm sóc')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                \Filament\Schemas\Components\Section::make('Hình ảnh')
                    ->schema([
                        \Filament\Forms\Components\Placeholder::make('current_image')
                            ->label('Ảnh đang hiển thị trên Web')
                            ->content(fn ($record) => $record && $record->image_url ? new \Illuminate\Support\HtmlString('<img src="' . $record->image_url . '" style="max-height: 200px; border-radius: 8px;">') : 'Chưa có ảnh')
                            ->columnSpanFull(),

                        SpatieMediaLibraryFileUpload::make('thumbnail')
                            ->label('Ảnh đại diện')
                            ->collection('thumbnail')
                            ->image()
                            ->imageEditor()
                            ->columnSpanFull(),

                        SpatieMediaLibraryFileUpload::make('images')
                            ->label('Thư viện ảnh')
                            ->collection('images')
                            ->image()
                            ->multiple()
                            ->reorderable()
                            ->imageEditor()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Ảnh')
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Tên')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('name_vi')
                    ->label('Tên tiếng Việt')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('price')
                    ->label('Giá')
                    ->money('VND', locale: 'vi')
                    ->sortable(),

                Tables\Columns\TextColumn::make('category')
                    ->label('Danh mục')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'desk' => 'info',
                        'large' => 'success',
                        'hanging' => 'warning',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'desk' => 'Để bàn',
                        'large' => 'Cây lớn',
                        'hanging' => 'Cây treo',
                        default => $state,
                    }),

                Tables\Columns\TextColumn::make('tag')
                    ->label('Nhãn')
                    ->badge()
                    ->color('success'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Đang bán')
                    ->boolean(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Ngày tạo')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Danh mục')
                    ->options([
                        'desk' => 'Cây để bàn',
                        'large' => 'Cây lớn',
                        'hanging' => 'Cây treo',
                    ]),
                Tables\Filters\SelectFilter::make('tag')
                    ->label('Nhãn')
                    ->options([
                        'Bán chạy' => 'Bán chạy',
                        'Dễ chăm sóc' => 'Dễ chăm sóc',
                        'Lọc khí' => 'Lọc không khí',
                    ]),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Trạng thái'),
            ])
            ->recordActions([
                \Filament\Actions\EditAction::make(),
                \Filament\Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                \Filament\Actions\BulkActionGroup::make([
                    \Filament\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
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
            'index' => Pages\ListPlants::route('/'),
            'create' => Pages\CreatePlant::route('/create'),
            'edit' => Pages\EditPlant::route('/{record}/edit'),
        ];
    }
}
