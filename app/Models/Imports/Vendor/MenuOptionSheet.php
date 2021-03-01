<?php
namespace App\Models\Imports\Vendor;

use App\Models\OptionGroup;
use App\Models\OptionItem;
use App\Models\Vendor;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MenuOptionSheet implements ToCollection, WithHeadingRow
{
    public function headingRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows)
    {
        $vendor         = Vendor::orderBy('id', 'desc')->first();;
        $vendor_id      = $vendor->id;

        $group_priority = 1;
        $priority       = 1;

        $parent         = null;
        $group          = null;

        foreach ($rows as $row) {

            if ($row['option_group']) {

                // 옵션 그룹
                $parent = OptionGroup::create([
                    'title'     => $row['option_group'],
                    'priority'  => $group_priority,
                    'parent_id' => null,
                    'vendor_id' => $vendor_id,
                ]);

            } else if ($row['option_item']) {

                // 옵션 그룹
                $group = OptionGroup::create([
                    'title'     => $row['option_item'],
                    'priority'  => $group_priority,
                    'parent_id' => $parent->id,
                    'vendor_id' => $vendor_id,
                ]);

            } else {

                // 옵션 아이템
                OptionItem::create([
                    'value'             => $row['option_value'],
                    'priority'          => $priority,
                    'group_id'          => $group->id
                ]);
            }
        }
    }
}