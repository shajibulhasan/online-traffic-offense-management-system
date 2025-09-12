@extends('layouts2.app')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-4">
            <select id="searchType" class="form-select">
                <option value="">Select Search Type</option>
                <option value="phone">Phone</option>
                <option value="email">Email</option>
                <option value="license">License</option>
                <option value="nid">NID</option>
            </select>
        </div>
        <div class="col-md-5">
            <input type="text" id="searchValue" class="form-control" placeholder="Enter search value">
        </div>
        <div class="col-md-3">
            <button id="searchBtn" class="btn btn-primary w-100">Search</button>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered table-striped text-black">
                <thead class="table-dark text-black">
                    <tr>
                        <th>#</th>
                        <th>Driver Name</th>
                        <th>Officer Name</th>
                        <th>Thana</th>
                        <th>Details</th>
                        <th>Fine</th>
                        <th>Point</th>
                        <th>Payment_Status</th>
                        <th>Action</th>

                    </tr>
                </thead>
                <tbody id="offenseTbody" class="text-black">
                    <tr><td colspan="8" class="text-center">Please search for a driver.</td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function(){
    $('#searchBtn').click(function(){
        let type = $('#searchType').val();
        let value = $('#searchValue').val();

        if(!type || !value){
            alert('Please select search type and enter value');
            return;
        }

        $.ajax({
            url: "{{ route('Officer.offenseList') }}",
            type: "GET",
            data: { type: type, value: value, ajax: 1 },
            success: function(res){
                let tbody = $('#offenseTbody');
                tbody.empty();

                if(res.success){
                    $('#driverName').show();
                    $('#driverNameText').text(res.driver_name);

                    if(res.data.length > 0){
                        $.each(res.data, function(i, item){
                            tbody.append(`
                                <tr>
                                    <td>${i+1}</td>
                                    <td>${item.driver_name ?? ''}</td>
                                    <td>${item.officer_name ?? ''}</td>
                                    <td>${item.thana_name ?? ''}</td>
                                    <td>${item.details_offense ?? ''}</td>
                                    <td>${item.fine ?? ''}</td>
                                    <td>${item.point ?? ''}</td>
                                    <td>
                                        ${item.status === 'paid' ? '<span class="badge bg-success">Paid</span>' : '<span class="badge bg-danger">Unpaid</span>'}
                                    </td>
                                    <td>
                                        ${item.status === 'paid'
                                            ? `<span class="badge bg-success">Pay by Bkash</span>`
                                            : `<a href="/Officer/updateOffense/${item.id}" class="btn btn-sm btn-info">Edit</a>
                                            <button class="btn btn-sm btn-danger" onclick="deleteOffense(${item.id})">Delete</button>`
                                        }
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        tbody.append('<tr><td colspan="8" class="text-center">No offenses found for this driver.</td></tr>');
                    }
                } else {
                    $('#driverName').hide();
                    tbody.append('<tr><td colspan="8" class="text-center">Driver not found.</td></tr>');
                }
            },
            error: function(){
                alert('Something went wrong!');
            }
        });
    });
});

function deleteOffense(id){
    if(confirm('Are you sure you want to delete this offense?')){
        $.ajax({
            url: `/Officer/deleteOffense/${id}`,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(res){
                alert('Offense deleted successfully');
                $('#searchBtn').click();
            },
            error: function(){
                alert('Failed to delete offense');
            }
        });
    }
}
</script>
@endsection
