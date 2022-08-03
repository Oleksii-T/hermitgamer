<?php


namespace App\Traits;

use App\Models\Translation;

trait TranslationTrait
{
    public function translations()
    {
        return $this->morphMany(Translation::class);
    }

    /**
     * @param $field
     * @param $locale
     * @return \Illuminate\Database\Eloquent\HigherOrderBuilderProxy|mixed|string
     */
    public function localed($field, $locale = null)
    {
        $value = $this->translations()
            ->where('locale', $locale ?? app()->getLocale())
            ->where('field', $field)
            ->value('value');

        if ($value) {
            return $value;
        } elseif (!$value && $locale) {
            return null;
        }

        $value = $this->translations()
            ->where('locale', 'en')
            ->where('field', $field)
            ->value('value');

        return $value;
    }

    /**
     * @param $translations
     */
    public function saveTranslations($translations)
    {
        foreach ($translations as $field_name => $data) {
            foreach ($data as $locale => $value) {
                if ($value) {
                    $this->translations()->updateOrCreate(
                        [
                            'locale' => $locale,
                            'field' => $field_name
                        ],
                        [
                            'locale' => $locale,
                            'field' => $field_name,
                            'value' => $value
                        ]
                    );
                }
            }
        }
    }

    public function getAllFieldTranslations($field)
    {
        $data = [];
        $translations = $this->translations()
            ->where('field', $field)
            ->get()
            ->keyBy('locale');

        foreach ($translations as $locale => $translation) {
            $data[$locale][] = $translation->value;
        }
        return $data;
    }
}
