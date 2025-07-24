@extends('AdminDashboard.master')
@section('title', 'Create Tax Invoice')
@section('content')

<div class="container-fluid">
    <div class="card">
        <form method="POST" action="{{ route('invoices.store') }}">
            @csrf
            <div class="card-header">
                <h4 class="card-title">Create Tax Invoice</h4>
            </div>
            <div class="card-body row">

                <input type="hidden" name="project_id" value="{{ $project->id }}">
                <input type="hidden" name="type" value="tax">

                <div class="col-md-6 mb-3">
                    <label>Project</label>
                    <input type="text" class="form-control" value="{{ $project->name }} ({{ $project->project_code }})" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Your VAT Number</label>
                    <input type="text" class="form-control" value="{{ config('app.vat_number', '123456789-7000') }}" readonly>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Client VAT Number</label>
                    <input type="text" name="client_vat_no" class="form-control" placeholder="Enter client VAT number">
                </div>

                <div class="col-md-6 mb-3">
                    <label>Discount (%)</label>
                    <input type="number" name="discount_percentage" id="discount_percentage" class="form-control" value="0" min="0" max="100" step="0.01">
                </div>

                <div class="col-12">
                    <label>Invoice Items</label>
                    <table class="table table-bordered" id="items-table">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>Amount</th>
                                <th style="width: 50px;">Action</th>
                            </tr>
                        </thead>
                        <tbody id="items-body">
                            <tr>
                                <td><input type="text" name="items[0][item]" class="form-control" required></td>
                                <td><input type="number" name="items[0][amount]" class="form-control amount-field" step="0.01" required></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-item">X</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-item">+ Add Item</button>
                </div>

                <!-- Totals -->
                <div class="col-12 mt-4 d-flex justify-content-end">
                    <div style="width: 400px;">
                        <div class="mb-2">
                            <label>Total</label>
                            <input type="text" class="form-control text-end" id="total" name="total" readonly>
                        </div>
                        <div class="mb-2">
                            <label>Discount Amount</label>
                            <input type="text" class="form-control text-end" id="discount_amount" name="discount_amount" readonly>
                        </div>
                        <div class="mb-2">
                            <label>After Discount Total</label>
                            <input type="text" class="form-control text-end" id="after_discount_total" name="after_discount_total" readonly>
                        </div>
                        <div class="mb-2">
                            <label>SSCL (2.5%)</label>
                            <input type="text" class="form-control text-end" id="sscl" name="sscl" readonly>
                        </div>
                        <div class="mb-2">
                            <label>After SSCL Total</label>
                            <input type="text" class="form-control text-end" id="after_sscl_total" name="after_sscl_total" readonly>
                        </div>
                        <div class="mb-2">
                            <label>VAT (18%)</label>
                            <input type="text" class="form-control text-end" id="vat" name="vat" readonly>
                        </div>
                        <div class="mb-2">
                            <label><strong>Final Total</strong></label>
                            <input type="text" class="form-control text-end" id="final_total" name="final_total" readonly>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary" type="submit">Save Invoice</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    let itemIndex = 1;

    function recalculateTotals() {
        let total = 0;
        document.querySelectorAll('.amount-field').forEach(input => {
            const val = parseFloat(input.value) || 0;
            total += val;
        });

        const discountPercentage = parseFloat(document.getElementById('discount_percentage').value) || 0;
        const discountAmount = total * (discountPercentage / 100);
        const afterDiscountTotal = total - discountAmount;

        const sscl = afterDiscountTotal * 0.025;
        const afterSSCLTotal = afterDiscountTotal + sscl;

        const vat = afterSSCLTotal * 0.18;
        const finalTotal = afterSSCLTotal + vat;

        document.getElementById('total').value = total.toFixed(2);
        document.getElementById('discount_amount').value = discountAmount.toFixed(2);
        document.getElementById('after_discount_total').value = afterDiscountTotal.toFixed(2);
        document.getElementById('sscl').value = sscl.toFixed(2);
        document.getElementById('after_sscl_total').value = afterSSCLTotal.toFixed(2);
        document.getElementById('vat').value = vat.toFixed(2);
        document.getElementById('final_total').value = finalTotal.toFixed(2);
    }

    document.getElementById('add-item').addEventListener('click', function () {
        const tbody = document.getElementById('items-body');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td><input type="text" name="items[${itemIndex}][item]" class="form-control" required></td>
            <td><input type="number" name="items[${itemIndex}][amount]" class="form-control amount-field" step="0.01" required></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-item">X</button></td>
        `;
        tbody.appendChild(newRow);
        itemIndex++;
    });

    document.getElementById('items-body').addEventListener('input', function (e) {
        if (e.target.classList.contains('amount-field')) {
            recalculateTotals();
        }
    });

    document.getElementById('items-body').addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('tr').remove();
            recalculateTotals();
        }
    });

    document.getElementById('discount_percentage').addEventListener('input', recalculateTotals);

    document.addEventListener('DOMContentLoaded', recalculateTotals);
</script>
@endsection
