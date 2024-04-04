<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Arr;
use App\Enums\BlockItemType;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidBlocksRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($value as $ii => $block) {
            $i = $ii+1;
            if (!Arr::get($block, 'ident')) {
                $fail("Identidier for block #$i is required");
            }
            if (!Arr::get($block, 'name')) {
                $fail("Name for block #$i is required");
            }
            if (!Arr::get($block, 'items')) {
                $fail("At least one item is required in block #$i is required");
            }

            // foreach ($block['items']??[] as $item) {
            //     $t = $item['type'];
            //     if ($t == BlockItemType::IMAGE_TITLE->value && $item['']) {

            //     }
            // }
        }
    }
}
