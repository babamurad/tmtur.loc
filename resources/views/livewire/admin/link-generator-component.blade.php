<div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Генератор ссылок</h4>
                    <p class="card-title-desc">Создайте ссылку с UTM-меткой для отслеживания источника перехода.</p>

                    <div class="form-group row">
                        <label for="targetUrl" class="col-md-2 col-form-label">Целевая ссылка</label>
                        <div class="col-md-10">
                            <input class="form-control" type="url" wire:model.live="targetUrl" id="targetUrl" placeholder="https://tmtur.loc/...">
                            <small class="form-text text-muted">Ссылка на страницу, куда должен попасть пользователь.</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="source" class="col-md-2 col-form-label">Источник (Source)</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" wire:model.live="source" id="source" placeholder="instagram">
                            <small class="form-text text-muted">Откуда придет пользователь? (например: instagram, email, partner_name)</small>
                        </div>
                    </div>

                    @if($result)
                    <div class="alert alert-success mt-4">
                        <label><strong>Ваша уникальная ссылка:</strong></label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="{{ $result }}" id="generatedLink" readonly>
                            <div class="input-group-append">
                                <button class="btn btn-primary" onclick="copyResult()">
                                    <i class="bx bx-copy"></i> Копировать
                                </button>
                            </div>
                        </div>
                    </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <script>
        function copyResult() {
            var copyText = document.getElementById("generatedLink");
            copyText.select();
            copyText.setSelectionRange(0, 99999); /* For mobile devices */
            
            // Modern copy approach
            if (navigator.clipboard && window.isSecureContext) {
                // navigator clipboard api method'
                navigator.clipboard.writeText(copyText.value).then(function() {
                    showSuccessToast();
                }, function(err) {
                    fallbackCopyTextToClipboard(copyText.value);
                });
            } else {
                // text area method
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
            } else {
                 alert("Ссылка скопирована!");
            }
        }
        
    </script>
</div>
