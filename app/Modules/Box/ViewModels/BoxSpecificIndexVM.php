<?php

namespace App\Modules\Box\ViewModels;

use App\Modules\Box\Models\Box;

class BoxSpecificIndexVM
{

    public static function handle($boxes)
    {
        $arr = [];
        if ($boxes) {
            foreach ($boxes as $box) {
                $boxVM = new BoxShowVM();
                array_push($arr, $boxVM->toAttr($box));
            }
        }
        return $arr;
    }

    public static function toAttr($boxes)
    {
        return self::handle($boxes);
    }

    public static function toArray($boxes)
    {
        return ['boxes' => self::handle($boxes)];
    }
}
