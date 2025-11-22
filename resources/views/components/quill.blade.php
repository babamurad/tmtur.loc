@push('quill-js')
<!-- Quill -->
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    <script>
        document.addEventListener('livewire:init', () => {          // <-- ждём появления Livewire
            document.querySelectorAll('.quill-wrapper').forEach(wrapper => {
                const container = wrapper.querySelector('[id^="quill_"]');
                if (!container || container.__quill) return;

                const id     = container.id;
                const hidden = wrapper.querySelector(`input[x-ref="hidden_${id}"]`);
                if (!hidden) return;

                const editor = new Quill(container, {
                    theme: 'snow',
                    modules: {
                        toolbar: [
                            [{ header: [1,2,3,false] }],
                            ['bold','italic','underline'],
                            [{list:'ordered'},{list:'bullet'}],
                            ['link','clean']
                        ]
                    }
                });
                container.__quill = editor;

                /* стартовое значение */
                editor.root.innerHTML = hidden.value ?? '';

                /* Quill → Livewire */
                editor.on('text-change', () => {
                    hidden.value = editor.root.innerHTML;
                    hidden.dispatchEvent(new Event('input'));
                });

                /* Livewire → Quill */
                Livewire.hook('message.processed', () => {
                    if (hidden.value !== editor.root.innerHTML) {
                        editor.root.innerHTML = hidden.value ?? '';
                    }
                });
            });
        });
    </script>
@endpush
