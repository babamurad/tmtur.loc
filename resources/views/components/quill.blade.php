@props([
    'id' => 'quill_' . md5($attributes->wire('model')),
])

<div wire:ignore>
    <div id="{{ $id }}" style="min-height:200px;"></div>
</div>

<input type="hidden" {{ $attributes->wire('model') }} x-ref="hidden">

@push('quill-css')
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
@endpush

@push('quill-js')
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        document.addEventListener('livewire:load', function () {
            initQuill_{{ $id }}();
        });

        function initQuill_{{ $id }}() {

            const container = document.getElementById('{{ $id }}');
            if (!container) return;

            if (container.__quill) return; // защита от повторной инициализации

            // <-- ВАЖНО: берём hidden input надёжным способом
            const hidden = container.parentElement.parentElement.querySelector('input[x-ref=hidden]');
            if (!hidden) return;

            const editor = new Quill(container, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ header: [1,2,3,false] }],
                        ['bold','italic','underline'],
                        [{list:'ordered'}, {list:'bullet'}],
                        ['link','clean']
                    ]
                }
            });

            container.__quill = editor;

            // 1. Загружаем начальное значение
            editor.root.innerHTML = hidden.value ?? "";

            // 2. Отправляем Livewire новые данные
            editor.on('text-change', function () {
                hidden.value = editor.root.innerHTML;
                hidden.dispatchEvent(new Event('input'));
            });

            // 3. Если Livewire обновляет значение — обновить Quill
            Livewire.hook('message.processed', () => {
                if (hidden.value !== editor.root.innerHTML) {
                    editor.root.innerHTML = hidden.value ?? "";
                }
            });
        }
    </script>
@endpush
