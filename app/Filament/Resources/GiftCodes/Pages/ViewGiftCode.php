<?php

namespace App\Filament\Resources\GiftCodes\Pages;

use App\Filament\Resources\GiftCodes\GiftCodeResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGiftCode extends ViewRecord
{
    protected static string $resource = GiftCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
