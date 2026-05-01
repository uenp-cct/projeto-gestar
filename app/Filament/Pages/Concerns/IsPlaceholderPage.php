<?php

namespace App\Filament\Pages\Concerns;

trait IsPlaceholderPage
{
    public function getTitle(): string
    {
        return static::$navigationLabel ?? class_basename(static::class);
    }

    /**
     * @return array<string, mixed>
     */
    protected function getViewData(): array
    {
        $statics = (array) (new \ReflectionClass(static::class))->getStaticProperties();

        return [
            'placeholderTitle' => $this->getTitle(),
            'placeholderSubtitle' => $statics['placeholderSubtitle'] ?? null,
            'placeholderDescription' => $statics['placeholderDescription'] ?? null,
            'placeholderHighlights' => $statics['placeholderHighlights'] ?? [],
        ];
    }
}
