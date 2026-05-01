<x-filament-panels::page>
    <div class="rounded-2xl border border-dashed border-gray-300 bg-white p-10 text-center shadow-sm dark:border-gray-700 dark:bg-gray-900">
        <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-sky-100 text-sky-600 dark:bg-sky-500/10 dark:text-sky-400">
            <x-heroicon-o-sparkles class="h-7 w-7" />
        </div>

        <h2 class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
            {{ $placeholderTitle }}
        </h2>

        @if (! empty($placeholderSubtitle))
            <p class="mt-2 text-sm font-medium text-sky-600 dark:text-sky-400">
                {{ $placeholderSubtitle }}
            </p>
        @endif

        @if (! empty($placeholderDescription))
            <p class="mx-auto mt-4 max-w-xl text-sm text-gray-600 dark:text-gray-400">
                {{ $placeholderDescription }}
            </p>
        @endif

        @if (! empty($placeholderHighlights))
            <ul class="mx-auto mt-6 grid max-w-2xl gap-2 text-left text-sm text-gray-700 dark:text-gray-300 sm:grid-cols-2">
                @foreach ($placeholderHighlights as $highlight)
                    <li class="flex items-start gap-2 rounded-lg bg-gray-50 px-3 py-2 dark:bg-gray-800/60">
                        <x-heroicon-m-check-circle class="mt-0.5 h-4 w-4 flex-none text-sky-500" />
                        <span>{{ $highlight }}</span>
                    </li>
                @endforeach
            </ul>
        @endif

        <p class="mt-8 inline-flex items-center gap-2 rounded-full bg-sky-50 px-4 py-1.5 text-xs font-medium text-sky-700 dark:bg-sky-500/10 dark:text-sky-300">
            <x-heroicon-m-clock class="h-4 w-4" />
            Em breve
        </p>
    </div>
</x-filament-panels::page>
