@extends('AdminDashboard.master')
@section('title', 'Add Invoice')
@section('content')

<div class="container-fluid">
    <div class="card">
        <form method="POST" action="{{ route('invoices.store') }}">
            @csrf
            <div class="card-header">
                <h4 class="card-title">Add Invoice</h4>
            </div>
            <div class="card-body row">

                <!-- Project Info -->
                <div class="col-md-6 mb-3">
                    <label>Project *</label>
                    <input type="hidden" name="project_id" value="{{ $project->id }}">
                    <input type="text" class="form-control" value="{{ $project->name }} ({{ $project->project_code }})" readonly>
                    @error('project_id')
                    <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <!-- Invoice Items -->
                <div class="col-12">
                    <label class="form-label">Invoice Items</label>
                    <table class="table table-bordered" id="items-table">
                        <thead>
                            <tr>
                                <th style="width:60%">Description</th>
                                <th style="width:30%">Amount</th>
                                <th style="width:10%">Action</th>
                            </tr>
                        </thead>
                        <tbody id="items-body">
                            <tr>
                                <td><input type="text" name="items[0][item]" class="form-control" placeholder="Description" required></td>
                                <td><input type="number" name="items[0][amount]" class="form-control amount-field" placeholder="0.00" required></td>
                                <td><button type="button" class="btn btn-danger btn-sm remove-item">X</button></td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="button" class="btn btn-sm btn-secondary mt-2" id="add-item">+ Add Item</button>
                </div>

                <!-- Calculated Fields -->
                <!-- Calculated Fields aligned to right -->
                <div class="col-12 mt-4 d-flex justify-content-end">
                    <div style="width: 400px;">
                        <div class="mb-2">
                            <label>Sub Total</label>
                            <input type="text" class="form-control text-end" id="sub_total" name="sub_total" readonly>
                        </div>
                        <div class="mb-2">
                            <label>SSCL (2.5%)</label>
                            <input type="text" class="form-control text-end" id="sscl" name="sscl" readonly>
                        </div>
                        <div class="mb-2">
                            <label>VAT (18%)</label>
                            <input type="text" class="form-control text-end" id="vat" name="vat" readonly>
                        </div>
                        <div class="mb-2">
                            <label>Total Amount</label>
                            <input type="text" class="form-control text-end" id="total" name="total_amount" readonly>
                        </div>
                    </div>
                </div>


            </div>
            <div class="card-footer text-end">
                <button class="btn btn-primary" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    let itemIndex = 1;

    function recalculateTotals() {
        let subTotal = 0;
        document.querySelectorAll('.amount-field').forEach(input => {
            const val = parseFloat(input.value) || 0;
            subTotal += val;
        });

        const sscl = subTotal * 0.025;
        const vat = subTotal * 0.18;
        const total = subTotal + sscl + vat;

        document.getElementById('sub_total').value = subTotal.toFixed(2);
        document.getElementById('sscl').value = sscl.toFixed(2);
        document.getElementById('vat').value = vat.toFixed(2);
        document.getElementById('total').value = total.toFixed(2);
    }

    document.getElementById('add-item').addEventListener('click', function() {
        const tbody = document.getElementById('items-body');
        const newRow = document.createElement('tr');
        newRow.innerHTML = `
            <td><input type="text" name="items[${itemIndex}][item]" class="form-control" placeholder="Description" required></td>
            <td><input type="number" name="items[${itemIndex}][amount]" class="form-control amount-field" placeholder="0.00" required></td>
            <td><button type="button" class="btn btn-danger btn-sm remove-item">X</button></td>
        `;
        tbody.appendChild(newRow);
        itemIndex++;
    });

    document.getElementById('items-body').addEventListener('input', function(e) {
        if (e.target.classList.contains('amount-field')) {
            recalculateTotals();
        }
    });

    document.getElementById('items-body').addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            e.target.closest('tr').remove();
            recalculateTotals();
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        recalculateTotals();
    });
</script>
@endsection