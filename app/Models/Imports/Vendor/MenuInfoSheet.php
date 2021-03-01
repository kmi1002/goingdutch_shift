<?php
namespace App\Models\Imports\Vendor;

use App\Models\MenuItem;
use App\Models\MenuGroup;
use App\Models\OptionGroup;
use App\Models\Vendor;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MenuInfoSheet implements ToCollection, WithHeadingRow
{
    public function headingRow(): int
    {
        return 2;
    }

    public function collection(Collection $rows)
    {
        $vendor         = Vendor::orderBy('id', 'desc')->first();;
        $vendor_id      = $vendor->id;

        $vendor_code    = 'vendor'.$vendor_id;
        $group_count    = 1;
        $menu_count     = 1;

        $group_priority = 1;
        $priority       = 1;

        $group          = null;

        foreach ($rows as $row) {

            if (!empty($row['group_title'])) {

                // 최상위 메뉴 그룹 설정
                if (empty($row['parent_group_title'])) {
                    $parent_id      = null;
                } else {

                    $group = MenuGroup::where('vendor_id', $vendor_id)
                        ->where('title', $row['parent_group_title'])
                        ->first();

                    $parent_id = $group->id;
                }

                // 메뉴 그룹
                $group = MenuGroup::create([
                    'code'          => $vendor_code.'_group_'.$group_count++,
                    'title'         => $row['group_title'],
                    'description'   => $row['group_description'],
                    'priority'      => $group_priority,
                    'parent_id'     => $parent_id,
                    'vendor_id'     => $vendor_id,
                ]);
            } else {

                // 메뉴 아이템
                $item = MenuItem::create([
                    'code'              => 'menu_' . $vendor_id . date('Ymd'),
                    'title'             => $row['menu_title'],
                    'sub_title'         => $row['menu_sub_title'],
                    'description'       => $row['menu_description'],
                    'caution'           => $row['menu_caution'],
                    'original_price'    => $row['menu_original_price'],
                    'active'            => true,
                    'priority'          => $priority,
                    'group_id'          => $group->id
                ]);


                $option_group = $row['menu_option'];

                $optionGroup = OptionGroup::where('title', $option_group)
                    ->where('vendor_id', $vendor_id)
                    ->whereNull('parent_id')
                    ->first();
                if ($optionGroup) {
                    $item->optionGroups()->save($optionGroup);
                }

            }
        }
    }
}