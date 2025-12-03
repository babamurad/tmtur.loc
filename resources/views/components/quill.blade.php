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
                // Register custom image alignment format
                const ImageBlot = Quill.import('formats/image');
                class AlignedImage extends ImageBlot {
                    static create(value) {
                        const node = super.create(value);
                        if (typeof value === 'object') {
                            node.setAttribute('src', value.src || value);
                            if (value.align) {
                                node.setAttribute('data-align', value.align);
                                node.classList.add(`ql-align-${value.align}`);
                            }
                        }
                        return node;
                    }
                    
                    static formats(node) {
                        return {
                            src: node.getAttribute('src'),
                            align: node.getAttribute('data-align') || 'center'
                        };
                    }
                }
                AlignedImage.blotName = 'image';
                AlignedImage.tagName = 'img';
                Quill.register(AlignedImage, true);
                
                // Register ImageResize module
                if (!Quill.imports['modules/imageResize']) {
                    try {
                        Quill.register('modules/imageResize', window.ImageResize.default || window.ImageResize);
                        modules.imageResize = {
                            modules: ['Resize', 'DisplaySize', 'Toolbar'],
                            handleStyles: {
                                backgroundColor: 'black',
                                border: 'none',
                                color: 'white'
                            },
                            displayStyles: {
                                backgroundColor: 'black',
                                border: 'none',
                                color: 'white',
                                padding: '4px 8px',
                                borderRadius: '4px'
                            }
                        };
                        console.log('ImageResize module enabled');
                    } catch (e) {
                        console.warn('ImageResize registration failed, continuing without it:', e);
                    }
                } else {
                    modules.imageResize = {
                        modules: ['Resize', 'DisplaySize', 'Toolbar']
                    };
                }
            } else {
                console.info('ImageResize module not available, editor will work without image resizing');
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

            // Add alignment controls when image is clicked
            editor.root.addEventListener('click', (e) => {
                if (e.target.tagName === 'IMG') {
                    const img = e.target;
                    
                    // Remove existing alignment menu
                    const existingMenu = document.querySelector('.image-align-menu');
                    if (existingMenu) existingMenu.remove();
                    
                    // Create alignment menu
                    const menu = document.createElement('div');
                    menu.className = 'image-align-menu';
                    menu.innerHTML = `
                        <button data-align="left" title="Выровнять слева">⬅️</button>
                        <button data-align="center" title="Выровнять по центру">↔️</button>
                        <button data-align="right" title="Выровнять справа">➡️</button>
                    `;
                    
                    // Position menu above image
                    const rect = img.getBoundingClientRect();
                    menu.style.position = 'absolute';
                    menu.style.top = (rect.top + window.scrollY - 40) + 'px';
                    menu.style.left = (rect.left + window.scrollX + rect.width / 2 - 75) + 'px';
                    
                    document.body.appendChild(menu);
                    
                    // Handle alignment clicks
                    menu.querySelectorAll('button').forEach(btn => {
                        btn.addEventListener('click', (e) => {
                            e.stopPropagation();
                            const align = btn.getAttribute('data-align');
                            
                            // Remove old alignment classes
                            img.classList.remove('ql-align-left', 'ql-align-center', 'ql-align-right');
                            
                            // Add new alignment
                            img.classList.add(`ql-align-${align}`);
                            img.setAttribute('data-align', align);
                            
                            // Trigger content change
                            editor.root.dispatchEvent(new Event('input', { bubbles: true }));
                            
                            menu.remove();
                        });
                    });
                    
                    // Close menu when clicking outside
                    setTimeout(() => {
                        document.addEventListener('click', function closeMenu(e) {
                            if (!menu.contains(e.target) && e.target !== img) {
                                menu.remove();
                                document.removeEventListener('click', closeMenu);
                            }
                        });
                    }, 0);
                }
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
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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