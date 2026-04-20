<div class="block-item bg-gray-50 p-6 rounded-xl border border-gray-200 relative" data-index="{{ $index }}">

    <input type="hidden" name="blocks[{{ $index }}][id]" value="{{ $block->id }}">
    <input type="hidden" name="blocks[{{ $index }}][component]" value="{{ $block->component }}">

    <button type="button" 
            onclick="removeBlock(this)" 
            class="absolute top-4 right-4 text-red-600 hover:text-red-800 text-sm font-medium">
        Удалить блок
    </button>

    @php
        $compClass = $availableComponents[$block->component] ?? null;
    @endphp

    @if($compClass)
        <h3 class="font-semibold text-lg mb-5">{{ $compClass::name() }}</h3>

        @php
            $fields = $compClass::fields();
        @endphp

        @foreach($fields as $field)
            @php
                $fieldName = "blocks[{$index}][content][{$field['name']}]";
                $value = old($fieldName, $block->content[$field['name']] ?? '');
            @endphp

            <div class="mb-5">
                <label class="block text-sm font-medium mb-2">{{ $field['label'] }}</label>

                @if($field['type'] === 'text')
                    <input type="text" 
                           name="{{ $fieldName }}" 
                           value="{{ $value }}" 
                           class="w-full border border-gray-300 rounded-md px-4 py-3">
                @elseif($field['type'] === 'textarea')
                    <textarea name="{{ $fieldName }}" 
                              class="w-full border border-gray-300 rounded-md px-4 py-3 h-28">{{ $value }}</textarea>
                @endif
            </div>
        @endforeach

    @else
        <div class="bg-red-100 border border-red-400 text-red-700 p-4 rounded-lg">
            <strong>Ошибка:</strong> Компонент <code>{{ $block->component }}</code> не зарегистрирован!<br>
            Добавь его в метод <code>getAvailableComponents()</code> контроллера.
        </div>
    @endif

</div>