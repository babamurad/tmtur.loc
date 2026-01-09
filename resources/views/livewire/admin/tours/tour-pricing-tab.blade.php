<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5>Cost Components</h5>
            </div>
            <div class="card-body">
                <form wire:submit.prevent="saveCosts">
                    <div class="mb-3">
                        <label class="form-label">Transport Total (per group)</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" class="form-control" wire:model.live="cost_transport_cents"
                                placeholder="Total cost for bus/driver">
                        </div>
                        <div class="form-text">Stored as cents</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Guide Total (per group)</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" class="form-control" wire:model.live="cost_guide_cents"
                                placeholder="Total salary for guide">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Meals (per person / day)</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" class="form-control"
                                wire:model.live="cost_meal_per_day_cents" placeholder="Avg meal cost">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Company Margin (%)</label>
                        <div class="input-group">
                            <input type="number" step="0.01" class="form-control"
                                wire:model.live="company_margin_percent">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Save Costs</button>

                    <hr>
                    <button type="button" wire:click="generatePrices" class="btn btn-success w-100">
                        <span wire:loading.remove wire:target="generatePrices">Generate Price Matrix</span>
                        <span wire:loading wire:target="generatePrices">Calculating...</span>
                    </button>
                    <div class="form-text text-center mt-2">
                        Calculates prices based on: Costs above + Hotel (Std/Comf) + Places (Tickets)
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5>Price Matrix</h5>
                <button wire:click="saveMatrix" class="btn btn-primary btn-sm">Save Matrix</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>Type</th>
                                <th>Min ppl</th>
                                <th>Max ppl</th>
                                <th>Price per Person ($)</th>
                                <th>Single Suppl ($)</th>
                                <th>Total (Group)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pricingMatrix as $index => $row)
                                <tr>
                                    <td>
                                        <select class="form-select form-select-sm"
                                            wire:model="pricingMatrix.{{ $index }}.accommodation_type">
                                            <option value="standard">Standard</option>
                                            <option value="comfort">Comfort</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" style="width: 60px"
                                            wire:model="pricingMatrix.{{ $index }}.min_people">
                                    </td>
                                    <td>
                                        <input type="number" class="form-control form-control-sm" style="width: 60px"
                                            wire:model="pricingMatrix.{{ $index }}.max_people">
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <input type="number" step="0.1" class="form-control"
                                                wire:model="pricingMatrix.{{ $index }}.price">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="input-group input-group-sm">
                                            <input type="number" step="0.1" class="form-control"
                                                wire:model="pricingMatrix.{{ $index }}.single_supplement">
                                        </div>
                                    </td>
                                    <td>
                                        {{ number_format(($row['price'] * $row['min_people']), 2) }}
                                    </td>
                                </tr>
                            @endforeach

                            @if(count($pricingMatrix) === 0)
                                <tr>
                                    <td colspan="6" class="text-center text-muted">No prices generated yet. Fill costs and
                                        click Generate.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>