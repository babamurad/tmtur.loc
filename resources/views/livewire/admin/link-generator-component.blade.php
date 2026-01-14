<div class="page-content">
    <div class="container-fluid">

        <!-- Page Title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="mb-0 font-size-18">Генератор ссылок</h4>
                    <div class="page-title-right d-flex align-items-center">
                        <button type="button" class="btn btn-primary btn-sm waves-effect waves-light mr-3"
                            data-toggle="modal" data-target="#createLinkModal">
                            <i class="bx bx-plus font-size-16 align-middle mr-1"></i> Создать ссылку
                        </button>
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('admin.link-generator') }}">Инструменты</a>
                            </li>
                            <li class="breadcrumb-item active">Генератор</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- History List -->
            <div class="col-12">
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
                                        <th class="text-center">Клики</th>
                                        <th class="text-center">Заказы</th>
                                        <th class="text-right">Баланс</th>
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
                                            <td><span
                                                    class="badge badge-soft-primary font-size-12">{{ $link->source }}</span>
                                            </td>
                                            <td>
                                                <div class="input-group input-group-sm" style="width: 100%;">
                                                    <input type="text" class="form-control" value="{{ $link->full_url }}"
                                                        id="link_{{ $link->id }}" readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-light"
                                                            onclick="copyLink('link_{{ $link->id }}')" title="Копировать">
                                                            <i class="bx bx-copy"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <small class="text-muted d-block mt-1 text-truncate"
                                                    style="max-width: 200px;" title="{{ $link->target_url }}">
                                                    {{ $link->target_url }}
                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <span
                                                    class="badge badge-pill badge-primary font-size-12">{{ $link->click_count }}</span>
                                            </td>
                                            <td class="text-center">
                                                <span class="badge badge-pill badge-success font-size-12">
                                                    {{ $link->bookings->where('status', '!=', 'cancelled')->count() }}
                                                </span>
                                            </td>
                                            <td class="text-right">
                                                @if($link->balance > 0)
                                                    <span
                                                        class="text-success font-weight-bold">${{ number_format($link->balance, 2) }}</span>
                                                    <br>
                                                    <button class="btn btn-xs btn-outline-success mt-1"
                                                        wire:click="openPayoutModal({{ $link->id }})">
                                                        Выплатить
                                                    </button>
                                                @else
                                                    <span class="text-muted text-nowrap">
                                                        Всего: ${{ number_format($link->total_earnings, 2) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.link-generator.stats', $link->id) }}"
                                                    class="btn btn-sm btn-outline-primary waves-effect waves-light"
                                                    title="Статистика">
                                                    <i class="bx bx-stats font-size-16"></i>
                                                </a>
                                                <button wire:click="openQrCodeModal({{ $link->id }})"
                                                    class="btn btn-sm btn-outline-info waves-effect waves-light"
                                                    title="QR Код">
                                                    <i class="bx bx-qr font-size-16"></i>
                                                </button>
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
                                            <td colspan="5" class="text-center text-muted py-4">История пуста</td>
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

    <!-- Create Link Modal -->
    <div wire:ignore.self class="modal fade" id="createLinkModal" tabindex="-1" role="dialog"
        aria-labelledby="createLinkModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createLinkModalLabel">Создать новую ссылку</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="text-muted mb-3">Добавьте UTM-метку для отслеживания источника.</p>

                    <div class="form-group">
                        <label for="targetUrl">Целевая страница</label>
                        <input class="form-control @error('targetUrl') is-invalid @enderror" type="url"
                            wire:model.blur="targetUrl" id="targetUrl" placeholder="https://tmtourism.com/...">
                        @error('targetUrl') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="source">Источник (Source)</label>
                        <input class="form-control @error('source') is-invalid @enderror" type="text"
                            wire:model.blur="source" id="source" placeholder="instagram">
                        @error('source') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        <small class="form-text text-muted">Например: instagram, email, partner_name</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-primary" wire:click="generate">
                        <i class="bx bx-check-double font-size-16 align-middle mr-2"></i> Сгенерировать
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Payout Modal -->
    <div wire:ignore.self class="modal fade" id="payoutModal" tabindex="-1" role="dialog"
        aria-labelledby="payoutModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="payoutModalLabel">Оформить выплату</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if($payoutLink)
                        <div class="alert alert-info">
                            Источник: <strong>{{ $payoutLink->source }}</strong><br>
                            Баланс: ${{ number_format($payoutLink->balance, 2) }}
                        </div>
                    @endif

                    <div class="form-group">
                        <label>Сумма выплаты ($)</label>
                        <input type="number" step="0.01" class="form-control" wire:model="payoutAmount">
                        @error('payoutAmount') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label>Комментарий / Заметка</label>
                        <textarea class="form-control" rows="3" wire:model="payoutNotes"
                            placeholder="Например: Передано наличными в офисе"></textarea>
                        @error('payoutNotes') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
                    <button type="button" class="btn btn-success" wire:click="savePayout">Подтвердить выплату</button>
                </div>
            </div>
        </div>
    </div>

    <!-- QR Code Modal -->
    <div wire:ignore.self class="modal fade" id="qrCodeModal" tabindex="-1" role="dialog"
        aria-labelledby="qrCodeModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="qrCodeModalLabel">QR Код ссылки</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    @if($qrCodeLink)
                        <div class="mb-3 d-inline-block p-3 border rounded bg-white" id="qrCodeContainer">
                            {!! SimpleSoftwareIO\QrCode\Facades\QrCode::size(250)->margin(2)->generate($qrCodeLink->full_url) !!}
                        </div>
                        <div class="mt-2">
                            <p class="text-muted">{{ $qrCodeLink->full_url }}</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-primary" onclick="downloadQrCode('png')">
                        <i class="bx bx-download font-size-16 align-middle mr-2"></i> Скачать PNG
                    </button>
                    <button type="button" class="btn btn-info" onclick="downloadQrCode('svg')">
                        <i class="bx bx-download font-size-16 align-middle mr-2"></i> Скачать SVG
                    </button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('close-create-modal', event => {
            $('#createLinkModal').modal('hide');
        });

        window.addEventListener('open-payout-modal', event => {
            $('#payoutModal').modal('show');
        });

        window.addEventListener('close-payout-modal', event => {
            $('#payoutModal').modal('hide');
        });

        window.addEventListener('open-qr-modal', event => {
            $('#qrCodeModal').modal('show');
        });

        function downloadQrCode(format) {
            const container = document.getElementById('qrCodeContainer');
            const svg = container.querySelector('svg');

            if (!svg) return;

            if (format === 'svg') {
                const svgData = new XMLSerializer().serializeToString(svg);
                const blob = new Blob([svgData], { type: 'image/svg+xml;charset=utf-8' });
                const url = URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = url;
                link.download = 'qrcode.svg';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            } else if (format === 'png') {
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                const svgData = new XMLSerializer().serializeToString(svg);
                const img = new Image();

                // Add white background for PNG
                // We need to verify SVG has width/height or set it
                const svgWidth = svg.getAttribute('width') || 250;
                const svgHeight = svg.getAttribute('height') || 250;

                canvas.width = svgWidth;
                canvas.height = svgHeight;

                img.onload = function () {
                    // White background
                    ctx.fillStyle = '#ffffff';
                    ctx.fillRect(0, 0, canvas.width, canvas.height);

                    ctx.drawImage(img, 0, 0);

                    const link = document.createElement('a');
                    link.download = 'qrcode.png';
                    link.href = canvas.toDataURL('image/png');
                    document.body.appendChild(link);
                    link.click();
                    document.body.removeChild(link);
                };

                img.src = 'data:image/svg+xml;base64,' + btoa(unescape(encodeURIComponent(svgData)));
            }
        }

        function copyResult() {
            copyLink("generatedLink");
        }

        function copyLink(elementId) {
            var copyText = document.getElementById(elementId);
            if (!copyText) return;

            copyText.select();
            copyText.setSelectionRange(0, 99999);

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(copyText.value).then(function () {
                    showSuccessToast();
                });
            } else {
                document.execCommand("copy");
                showSuccessToast();
            }
        }

        function showSuccessToast() {
            if (typeof Swal !== 'undefined') {
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