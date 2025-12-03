@props(['value' => ''])

<div x-data="{
        content: @entangle($attributes->wire('model')),
        initQuill() {
            if (typeof Quill === 'undefined') {
                console.error('Quill library not loaded!');
                return;
            }

            // Подключаем модуль Image Resize (если загружен)
            let modules = {
                toolbar: [
                    [{ 'header': [1, 2, 3, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'align': [] }],
                    ['link', 'image', 'clean']
                ]
            };

            // Try to register ImageResize if available
            if (typeof window.ImageResize !== 'undefined' && Quill.imports) {
                if (!Quill.imports['modules/imageResize']) {
                    try {
                        Quill.register('modules/imageResize', window.ImageResize.default || window.ImageResize);
                        modules.imageResize = {
                            modules: ['Resize', 'DisplaySize']
                        };
                        console.log('ImageResize module enabled');
                    } catch (e) {
                        console.warn('ImageResize registration failed:', e);
                    }
                }
            } else {
                console.info('ImageResize module not available');
            }

            console.log('Initializing Quill on element:', this.$refs.editor);

            const editor = new Quill(this.$refs.editor, {
                theme: 'snow',
                modules: modules
            });
            
            console.log('Quill initialized successfully');

            // Custom image handler
            const toolbar = editor.getModule('toolbar');
            toolbar.addHandler('image', () => {
                const input = document.createElement('input');
                input.setAttribute('type', 'file');
                input.setAttribute('accept', 'image/*');
                input.click();

                input.onchange = async () => {
                    const file = input.files[0];
                    if (!file) return;

                    // Validate file type
                    if (!file.type.startsWith('image/')) {
                        alert('Пожалуйста, выберите изображение');
                        return;
                    }

                    // Validate file size (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        alert('Размер изображения не должен превышать 2 МБ');
                        return;
                    }

                    try {
                        // Process image: resize and compress
                        const processedDataUrl = await this.processImage(file);
                        
                        // Insert image into editor
                        const range = editor.getSelection(true);
                        editor.insertEmbed(range.index, 'image', processedDataUrl);
                        editor.setSelection(range.index + 1);
                    } catch (error) {
                        console.error('Image processing error:', error);
                        alert('Ошибка при обработке изображения');
                    }
                };
            });

    // Initial content
    editor.root.innerHTML = this.content;

    // Livewire → Quill
    editor.on('text-change', () => {
    this.content = editor.root.innerHTML;
    });

    // Quill → Livewire
    this.$watch('content', (value) => {
    if (editor.root.innerHTML !== value) {
    editor.root.innerHTML = value;
    }
    });
    },

    // Image processing function
    processImage(file) {
    return new Promise((resolve, reject) => {
    const reader = new FileReader();

    reader.onload = (e) => {
    const img = new Image();

    img.onload = () => {
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');

    // Calculate new dimensions (max 1800px)
    let width = img.width;
    let height = img.height;
    const maxSize = 1800;

    if (width > maxSize || height > maxSize) {
    if (width > height) {
    height = (height / width) * maxSize;
    width = maxSize;
    } else {
    width = (width / height) * maxSize;
    height = maxSize;
    }
    }

    canvas.width = width;
    canvas.height = height;

    // Draw and compress (75% quality)
    ctx.drawImage(img, 0, 0, width, height);
    const compressedDataUrl = canvas.toDataURL('image/jpeg', 0.75);

    resolve(compressedDataUrl);
    };

    img.onerror = reject;
    img.src = e.target.result;
    };

    reader.onerror = reject;
    reader.readAsDataURL(file);
    });
    }
    }" x-init="initQuill" wire:ignore class="quill-wrapper">

    <div x-ref="editor"></div>
</div>

@once
    @push('quill-css')
        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
        <style>
            .quill-wrapper {
                display: block;
                width: 100%;
                background: #fff;
                border: 1px solid #ccc;
            }

            .quill-wrapper .ql-editor {
                min-height: 200px;
                height: auto;
                background-color: #fff;
                color: #333;
            }

            /* Centered and responsive images */
            .quill-wrapper .ql-editor img {
                display: block;
                margin: 1rem auto;
                max-width: 100%;
                height: auto;
                border-radius: 4px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            }

            .quill-wrapper .ql-container {
                font-family: 'Inter', sans-serif;
                font-size: 16px;
                height: auto;
            }

            .quill-wrapper .ql-toolbar {
                background: #f8f9fa;
                border-bottom: 1px solid #ccc;
            }
        </style>
    @endpush

    @push('quill-js')
        <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

        <!-- ImageResize module from jsDelivr -->
        <script src="https://cdn.jsdelivr.net/npm/quill-image-resize-module@3.0.0/image-resize.min.js"></script>

        <script>
            function quillEditor(content) {
                return {
                    content,
                    init() {

                        // Регистрация
                        Quill.register('modules/imageResize', window.ImageResize);

                        const editor = new Quill(this.$refs.editor, {
                            theme: 'snow',
                            modules: {
                                toolbar: {
                                    container: [
                                        [{ 'header': [1, 2, 3, false] }],
                                        ['bold', 'italic', 'underline'],
                                        [{ list: 'ordered' }, { list: 'bullet' }],
                                        [{ 'align': [] }],
                                        ['link', 'image']
                                    ],
                                    handlers: {
                                        image: () => this.selectLocalImage(editor)
                                    }
                                },

                                imageResize: {
                                    modules: ['Resize', 'DisplaySize', 'Toolbar'],
                                }
                            }
                        });

                        editor.root.innerHTML = this.content;

                        editor.on('text-change', () => {
                            this.content = editor.root.innerHTML;
                        });

                        this.$watch('content', (value) => {
                            if (editor.root.innerHTML !== value) {
                                editor.root.innerHTML = value;
                            }
                        });
                    }
                }
            }
        </script>

    @endpush
@endonce