<?php
namespace App\Models\Imports\Vendor;

use App\Helpers\DebugHelpers;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\User;


class VendorInfoSheet implements ToCollection, WithHeadingRow
{
    public function headingRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            // code를 검사하는 이유는 엑셀 파일에서 '매장 정보' 시트에 빈 행들이 있는 경우 무시하기 위함.
            // 빈값들은 mac os x에서 확인 (내가 mac을 사용하기 때문임)
            if (empty($row['code'])) {
                continue;
            }

            User::createVendor($row);
        }
    }
}