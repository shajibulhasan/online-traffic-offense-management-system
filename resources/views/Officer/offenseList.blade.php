@extends('layouts2.app')

@section('content')
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@elseif(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-12">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-header text-white bg-dark text-center py-2">
                    <h4 class="mb-0"><b>Offense List</b></h4>
                </div>

                {{-- Search Form --}}
                <form id="searchForm" class="mb-4 mt-3 px-3">
                    <label for="searchType" class="form-label"><b>Search Driver:</b><span class="text-danger">*</span></label>
                    <div class="input-group mb-2">
                        <select id="searchType" name="type" class="form-select" required>
                            <option value="">Select Driver</option>
                            <option value="phone">Phone</option>
                            <option value="email">Email</option>
                            <option value="license">Driver License</option>
                        </select>
                        <input type="text" id="searchValue" name="value" class="form-control" placeholder="Enter value..." required>
                        <button type="submit" class="btn btn-outline-primary">Search</button>
                    </div>
                </form>

                <div id="loader" style="display:none;" class="text-center mb-2">Loading...</div>
                <div id="driverName" class="mb-3 h5 text-primary text-center"></div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered text-center align-middle" id="offenseTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>Serial No.</th>
                                    <th>Driver Name</th>
                                    <th>Officer Name</th>
                                    <th>Area Name</th>
                                    <th>Details Offense</th>
                                    <th>Fine</th>
                                    <th>Point</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="offenseTbody">
                                <tr>
                                    <td colspan="8">Please search for a driver.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>

{{-- JavaScript --}}
<script>
$(document).ready(function() {

    // Change placeholder dynamically
    $('#searchType').on('change', function () {
        const selected = $(this).val();
        const input = $('#searchValue');

        if (!selected) {
            input.attr('placeholder', 'Enter value...');
        } else if (selected === 'phone') {
            input.attr('placeholder', 'Enter phone number...');
        } else if (selected === 'email') {
            input.attr('placeholder', 'Enter email address...');
        } else if (selected === 'license') {
            input.attr('placeholder', 'Enter driver license...');
        }
    });

    // Search offense data by driver
    $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        let type = $('#searchType').val();
        let value = $('#searchValue').val();

        if (!type || !value) return;

        $('#loader').show();
        $('#offenseTbody').html('<tr><td colspan="8">Loading...</td></tr>');
        $('#driverName').text('');

        $.ajax({
            url: "{{ route('Officer.offenseList') }}",
            type: "GET",
            data: { type: type, value: value, ajax: 1 },
            success: function(res) {
                $('#loader').hide();
                let rows = '';

                if (res.driver_name) {
                    $('#driverName').text('Driver Name: ' + res.driver_name);
                }

                if (res.success && res.data.length > 0) {
                    $.each(res.data, function(i, offense) {
                        rows += `
                            <tr>
                                <td>${i + 1}</td>
                                <td>${offense.driver_name ?? ''}</td>
                                <td>${offense.officer_name ?? ''}</td>
                                <td>${offense.thana_name ?? ''}</td>
                                <td>${offense.details_offense ?? ''}</td>
                                <td>${offense.fine ?? ''}</td>
                                <td>${offense.point ?? ''}</td>
                                <td>
                                    <a href="/Officer/updateOffense/${offense.id}" class="btn btn-sm btn-info">Edit</a>
                                    <div class="modal fade" id="deleteModal${offense.id}" tabindex="-1" aria-labelledby="deleteModalLabel${offense.id}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content border-0 rounded-3 shadow">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="deleteModalLabel${offense.id}">Confirm Delete</h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete this offense?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <form class="delete-form" data-id="${offense.id}">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <button type="submit" class="btn btn-danger">Yes, Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        `;
                    });
                } else {
                    rows = '<tr><td colspan="8">No data found.</td></tr>';
                }

                $('#offenseTbody').html(rows);
            },
            error: function() {
                $('#loader').hide();
                $('#offenseTbody').html('<tr><td colspan="8">Error loading data.</td></tr>');
            }
        });
    });

});
</script>
@endsection
