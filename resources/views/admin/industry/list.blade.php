@extends('admin.layout.app')
@section('title', 'Industries List')
@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card my-4">
                <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
                    <div class="bg-gradient-primary shadow-primary border-radius-lg pb-3 " style="height:50px;padding-top: 0.8rem !important">
                        <h6 class="text-white text-capitalize ps-3">Industries table</h6>
                    </div>
                </div>

                <div class="custom-margin-auto">
                    <button type="button" class="btn bg-gradient-primary mt-2 custom-button-class" data-bs-toggle="modal" data-bs-target="#addModal">
                        Add Industry
                    </button>
                </div>

                <div class="card-body px-0 pb-2">
                    <div class="table-responsive p-0 mx-3">
                        <table id="industry_list_table" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Industry</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($industries as $key=>$industry)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{$industry->name}}</td>
                                    <td>
                                        <a href="" data-bs-toggle="modal" data-bs-target="#editModal" data-id="{{$industry->id}}" data-value="{{$industry->name}}">
                                            <i class="material-icons opacity-10">edit</i>
                                        </a>
                                        <a href="{{route('questions.industry.delete',['id' => $industry->id])}}">
                                            <i class="material-icons opacity-10">delete</i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-normal" id="addModalLabel">Add Industry</h5>
                    </div>
                    <div class="modal-body">
                        <form role="form text-left" id="addForm" action="{{ route('questions.industry.store') }}" method="POST">
                            @csrf
                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">Industry</label>
                                <input type="text" class="form-control" name="name" onfocus="focused(this)" onfocusout="defocused(this)" required autocomplete="off">
                            </div>
                            <div class="add-error-message text-danger"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-primary">Save</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-normal" id="editModalLabel">Update Industry</h5>
                    </div>
                    <div class="modal-body">
                        <form role="form text-left" id="editForm" action="{{ route('questions.industry.update') }}" method="POST">
                            @csrf
                            <input type="hidden" class="form-control editId" name="id">
                            <div class="input-group input-group-outline my-3">
                                <label class="form-label">Industry</label>
                                <input type="text" class="form-control editInput" name="name" onfocus="focused(this)" onfocusout="defocused(this)" required autocomplete="off">
                            </div>
                            <div class="edit-error-message text-danger"></div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#industry_list_table').DataTable();
    });
</script>
@endsection