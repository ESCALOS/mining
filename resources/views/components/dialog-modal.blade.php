@props(['id' => null, 'maxWidth' => null])

<x-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4">
        <div class="text-lg font-medium text-gray-900">
            {{ $title }}
        </div>

        <div class="mt-4 text-sm"  style="max-height: 460px;overflow-y:auto">
            {{ $content }}
        </div>
    </div>

    <div class="flex flex-row justify-end px-6 py-4 text-right bg-gray-100">
        {{ $footer }}
    </div>
</x-modal>
