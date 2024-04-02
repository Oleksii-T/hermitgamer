<?php

namespace App\Rules;

use Closure;
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
        foreach ($value as $block) {
            if (!$block['ident']) {
                $fail('Block ident is required');
            }
            if (!$block['name']) {
                $fail('Block name is required');
            }
            if (!$block['items']) {
                $fail('Block items is required');
            }

            // foreach ($block['items']??[] as $item) {
            //     $t = $item['type'];
            //     if ($t == BlockItemType::IMAGE_TITLE->value && $item['']) {

            //     }
            // }
        }
    }
}
