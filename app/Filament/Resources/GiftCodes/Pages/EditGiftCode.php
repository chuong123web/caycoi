<?php

namespace App\Filament\Resources\GiftCodes\Pages;

use App\Filament\Resources\GiftCodes\GiftCodeResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditGiftCode extends EditRecord
{
    protected static string $resource = GiftCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
