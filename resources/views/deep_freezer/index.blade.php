@extends('layout.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3>Deep Freezers
                    </h3>
                    <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#new">Create
                        New</button>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th>#</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Status</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach ($deep_freezers as $key => $deep_freezer)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $deep_freezer->code }}</td>
                                    <td>{{ $deep_freezer->type }}</td>
                                    <td>{{ $deep_freezer->size }}</td>
                                    <td>{{ $deep_freezer->status }}</td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-soft-secondary btn-sm dropdown" type="button"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ri-more-fill align-middle"></i>
                                            </button>
                                            <ul class="dropdown-menu dropdown-menu-end">
                                                <li>
                                                    <button class="dropdown-item"
                                                        onclick="newWindow('{{ route('deep_freezer.show', $deep_freezer->id) }}')"
                                                        onclick=""><i
                                                            class="ri-eye-fill align-bottom me-2 text-muted"></i>
                                                        View
                                                    </button>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item"
                                                        onclick="newWindow('{{ route('deep_freezer.edit', $deep_freezer->id) }}')">
                                                        <i class="ri-pencil-fill align-bottom me-2 text-muted"></i>
                                                        Edit
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </td>
                                </tr>
                                <div id="edit_{{ $deep_freezer->id }}" class="modal fade" tabindex="-1"
                                    aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="myModalLabel">Edit Deep Freezer</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"> </button>
                                            </div>
                                            <form action="{{ route('deep_freezer.update', $deep_freezer->id) }}"
                                                method="Post">
                                                @csrf
                                                @method('patch')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="code">Code</label>
                                                        <input type="text" name="code"
                                                            value="{{ $deep_freezer->code }}" required id="code"
                                                            class="form-control">
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label for="type">Type</label>
                                                        <select type="text" name="type" id="type"
                                                            class="form-control">
                                                            <option value="Hard Top"
                                                                {{ $deep_freezer->type == 'Hard Top' ? 'selected' : '' }}>
                                                                Hard Top</option>
                                                            <option value="Glass Top"
                                                                {{ $deep_freezer->type == 'Glass Top' ? 'selected' : '' }}>
                                                                Glass Top</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group mt-2">
                                                        <label for="size">Size</label>
                                                        <input type="text" name="size"
                                                            value="{{ $deep_freezer->size }}" id="size"
                                                            class="form-control">
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal -->
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Default Modals -->

    <div id="new" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true"
        style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Create New Deep Freezer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                </div>
                <form action="{{ route('deep_freezer.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="code">Code</label>
                            <input type="text" name="code" required id="code" class="form-control">
                        </div>
                        <div class="form-group mt-2">
                            <label for="type">Type</label>
                            <select name="type" id="type" class="form-control">
                                <option value="Hard Top">Hard Top</option>
                                <option value="Glass Top">Glass Top</option>
                            </select>
                        </div>
                        <div class="form-group mt-2">
                            <label for="size">Size</label>
                            <input type="text" name="size" id="size" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endsection
