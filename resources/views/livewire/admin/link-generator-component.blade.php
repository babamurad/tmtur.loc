<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Генератор ссылок</h4>
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                             <li class="breadcrumb-item"><a href="{{ route('admin.link-generator') }}">Инструменты</a></li>
                             <li class="breadcrumb-item active">Генератор</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Left Column: Generator Form -->
            <div class="col-xl-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Создать новую ссылку</h4>
                        <p class="card-title-desc">Добавьте UTM-метку для отслеживания источника.</p>

                        <div class="form-group">
                            <label for="targetUrl">Целевая страница</label>
                            <input class="form-control @error('targetUrl') is-invalid @enderror" type="url" wire:model.blur="targetUrl" id="targetUrl" placeholder="https://tmtourism.com/...">
                             @error('targetUrl') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <div class="form-group">
                            <label for="source">Источник (Source)</label>
                            <input class="form-control @error('source') is-invalid @enderror" type="text" wire:model.blur="source" id="source" placeholder="instagram">
                            @error('source') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            <small class="form-text text-muted">Например: instagram, email, partner_name</small>
                        </div>

                        <button class="btn btn-primary waves-effect waves-light w-100" wire:click="generate">
                            <i class="bx bx-check-double font-size-16 align-middle mr-2"></i> Сгенерировать
                        </button>

                        @if($result)
                        <div class="alert alert-success mt-4 mb-0">
                            <label><strong>Готовая ссылка:</strong></label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ $result }}" id="generatedLink" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-primary" onclick="copyResult()">
                                        <i class="bx bx-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column: History List -->
            <div class="col-xl-7">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">История ({{ $links->total() }})</h4>
                        
                        <div class="table-responsive">
                            <table class="table table-centered table-nowrap table-hover mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Дата</th>
                                        <th>Источник</th>
                                        <th>Ссылка</th>
                                        <th style="width: 100px;">Действия</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($links as $link)
                                    <tr>
                                        <td>
                                            {{ $link->created_at->format('d.m.Y') }}<br>
                                            <small class="text-muted">{{ $link->created_at->format('H:i') }}</small>
                                        </td>
                                        <td><span class="badge badge-soft-primary font-size-12">{{ $link->source }}</span></td>
                                        <td>
                                            <div class="input-group input-group-sm" style="width: 100%;">
                                                <input type="text" class="form-control" value="{{ $link->full_url }}" id="link_{{ $link->id }}" readonly>
                                                <div class="input-group-append">
                                                    <button class="btn btn-light" onclick="copyLink('link_{{ $link->id }}')" title="Копировать">
                                                        <i class="bx bx-copy"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <small class="text-muted d-block mt-1 text-truncate" style="max-width: 200px;" title="{{ $link->target_url }}">
                                                {{ $link->target_url }}
                                            </small>
                                        </td>
                                        <td>
                                            <button wire:click="delete({{ $link->id }})" 
                                                    wire:confirm="Удалить эту ссылку?"
                                                    class="btn btn-sm btn-outline-danger waves-effect waves-light" 
                                                    title="Удалить">
                                                <i class="bx bx-trash font-size-16"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">История пуста</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-3">
                            {{ $links->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>
    
    <script>
        function copyResult() {
            copyLink("generatedLink");
        }

        function copyLink(elementId) {
            var copyText = document.getElementById(elementId);
            if (!copyText) return;
            
            copyText.select();
            copyText.setSelectionRange(0, 99999); 
            
            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(copyText.value).then(function() {
                    showSuccessToast();
                });
            } else {
                document.execCommand("copy");
                showSuccessToast();
            }
        }

        function showSuccessToast() {
            if(typeof Swal !== 'undefined') {
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: 'Ссылка скопирована',
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        }
    </script>
</div>
