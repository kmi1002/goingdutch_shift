<?php

namespace App\Models\Imports;

use App\Models\Vendor;
use App\Models\Imports\Vendor\MenuInfoSheet;
use App\Models\Imports\Vendor\MenuOptionSheet;
use App\Models\Imports\Vendor\VendorInfoSheet;
use Maatwebsite\Excel\Concerns\WithConditionalSheets;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class VendorImport implements WithMultipleSheets
{
    use WithConditionalSheets;

    public function conditionalSheets(): array
    {
        // 실패시 디비는 Rollback됨

        return [
            '매장 정보'   => new VendorInfoSheet(),
            '메뉴 옵션'   => new MenuOptionSheet(),
            '메뉴 정보'   => new MenuInfoSheet(),
        ];
    }
}