@props(['value' => ''])

<div
    x-data="{
        content: @entangle($attributes->wire('model')),
        initQuill() {
            const editor = new Quill(this.$refs.editor, {
                theme: 'snow',
                modules: {
                    toolbar: [
                        [{ 'header': [1, 2, 3, false] }],
                        ['bold', 'italic', 'underline', 'strike'],
                        [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                        [{ 'color': [] }, { 'background': [] }],
                        [{ 'align': [] }],
                        ['link', 'clean']
                    ]
                }
            });

            // Set initial content
            editor.root.innerHTML = this.content;

            // Update Livewire property on text change
            editor.on('text-change', () => {
                this.content = editor.root.innerHTML;
            });

            // Watch for external changes (e.g. from Livewire)
            this.$watch('content', (value) => {
                if (editor.root.innerHTML !== value) {
                    editor.root.innerHTML = value;
                }
            });
        }
    }"
    x-init="initQuill"
    wire:ignore
    class="quill-wrapper"
>
    <div x-ref="editor"></div>
</div>

@once
    @push('quill-css')
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    @endpush
    @push('quill-js')
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
    @endpush
@endonce
