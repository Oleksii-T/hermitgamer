<?php

namespace App\Traits;

use App\Models\Translation;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

trait HasTranslations
{
    public function translations()
    {
        return $this->morphMany(Translation::class, 'translatable');
    }

    public function translated($field, $locale=null)
    {
        $currLocale = LaravelLocalization::getCurrentLocale();
        $translations = $this->translations->where('field', $field);
        $defLocale = 'en';

        $result = $translations->where('locale', $locale??$currLocale)->value('value');

        if (!$result && !$locale) {
            $result = $translations->where('locale', $defLocale)->value('value');
        }

        return $result;
    }

    public function getLocalizedRouteKey($locale=null)
    {
        return $this->translated('slug', $locale);
    }

    public function saveTranslations($fieldsTranslations)
    {
        $translatables = self::TRANSLATABLES;
        foreach ($fieldsTranslations as $field => $translations) {
            if (!in_array($field, $translatables)) {
                continue;
            }
            $this->saveTranslation($translations, $field);
        }
    }

    public function saveTranslation($translations, $field)
    {
        foreach ($translations as $locale => $value) {
            $value ??= '';
            $this->translations()->updateOrCreate(
                [
                    'field' => $field,
                    'locale' => $locale
                ],
                [
                    'field' => $field,
                    'locale' => $locale,
                    'value' => $value
                ]
            );
        }
    }

    public function compileTranslation($field)
    {
        $translations = $this->translations->where('field', $field);
        foreach ($translations as $translation) {
            $res[$translation->locale] = $translation->value;
        }
        return $res;
    }

    public function purgeTranslations()
    {
        $this->translations()->delete();
    }

    public function resolveRouteBinding($slug, $field = null)
    {
        if (request()->segment(1) === 'admin' || !in_array('slug', self::TRANSLATABLES)) {
            $res = self::find($slug);
        } else {
            $res = Translation::where('field', 'slug')
                ->where('translatable_type', self::class)
                ->where('locale', LaravelLocalization::getCurrentLocale())
                ->where('value', $slug)
                ->first()->translatable ?? null;
        }

        return $res ?? abort(404);
    }
}
