@extends('layouts.app')

@section('content')
    <style>
        .table td,
        .table th {
            padding: .35rem;
            vertical-align: middle !important;
            text-align: center;
        }
    </style>

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <div class="row">
                    <div class="col-6">
                        <h4 class="m-0 font-weight-bold text-primary">Storages</h4>
                    </div>
                    <div class="col-6 text-right">
                        @if ($access['is_insert'])
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalUpload"
                                id="triggerUpload">Upload</button>
                        @endif
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" width="100%" cellspacing="0" style="font-size: 15px;">
                        <thead class="thead-dark">
                            <tr>
                                <th>File Name</th>
                                <th>Size</th>
                                <th>Modified</th>
                                <th>Owner</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($storages as $item)
                                <tr>
                                    <td class="{{ $item['id'] . 'filename' }} text-left" data-filename="{{ $item['filename'] }}">
                                        @if (in_array(strtoupper($item['extension']), ['PDF', 'JPG', 'JPEG', 'PNG', 'GIF']) && $item['status'] != 'Encrypted')
                                            <a href="{{ $item['path'] }}" class="text-primary mr-3" target="_blank" title="Preview">
                                                {{ $item['filename'] }}
                                            </a>
                                        @else
                                            {{ $item['filename'] }}
                                        @endif
                                    </td>
                                    <td class="{{ $item['id'] . 'size' }} text-left">{{ $item['size'] }}</td>
                                    <td class="{{ $item['id'] . 'updated_at' }}">
                                        {{ date('d-m-Y H:i:s', strtotime($item['updated_at'])) }}</td>
                                    <td class="{{ $item['id'] . 'owner' }}">{{ $item['owner'] }}</td>
                                    <td class="{{ $item['id'] . 'status' }}">
                                        @if ($item['status'] == 'Encrypted')
                                            <span class="badge badge-success">{{ $item['status'] }}</span>
                                        @else
                                            <span class="badge badge-secondary">{{ $item['status'] }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            @if ($access['is_edit'] && $item['status'] != 'Encrypted')
                                                <a href="javascript:void(0);" data-id="{{ $item['id'] }}" class="text-primary mr-3 btnEdit"
                                                    data-toggle="modal" data-target="#modalRename" title="Edit">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            @endif

                                            @if ($access['is_delete'] && $item['status'] != 'Encrypted')
                                                {{ Form::open(['route' => ['storages.destroy', $item['id']], 'method' => 'delete']) }}
                                                <a href="javascript:void(0);" onclick="$(this).closest('form').submit();"
                                                    class="text-danger mr-3" title="Delete"><i
                                                        class="fa fa-trash"></i></a>
                                                {{ Form::close() }}
                                            @endif

                                            <a href="/download/{{ $item['id'] }}" class="text-success mr-3"
                                                title="Download">
                                                <i class="fa fa-download"></i>
                                            </a>

                                            @if (auth()->user()->id == $item['user_id'])
                                                @if ($item['status'] == 'Encrypted')
                                                    <a href="/decryption/{{ $item['id'] }}" class="text-secondary mr-3"
                                                        title="Decryption">
                                                        <i class="fa fa-unlock-alt"></i>
                                                    </a>
                                                @else
                                                    <a href="javascript:void(0);" data-id="{{ $item['id'] }}" class="text-secondary mr-3 btnEncryption"
                                                        data-toggle="modal" data-target="#modalEncryption" title="Encryption">
                                                        <i class="fa fa-key"></i>
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    {{-- Modal for upload file --}}
    <div class="modal fade" id="modalUpload" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Upload File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('storages.store') }}" method="POST" id="upload-form" class="dropzone" enctype="multipart/form-data">
                        @csrf
                        <div class="previews"></div>
                        <div class="dz-message" data-dz-message>
                            <span>Drag and drop files here or click to upload.</span>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" id="btnUpload" class="btn btn-primary">Selesai</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal for rename file --}}
    <div class="modal fade" id="modalRename" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Rename File Name</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('rename') }}" id="formRename" method="POST" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="rename">New File Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" maxlength="50" id="rename" name="rename"
                                    required>
                                <input type="hidden" class="form-control file_id" name="file_id">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal for encryption file --}}
    <div class="modal fade" id="modalEncryption" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Encryption File</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('encryption') }}" method="POST" autocomplete="off">
                    @csrf
                    <div class="modal-body">
                        <div class="form-row">
                            <div class="col-md-12 mb-3">
                                <label for="secret_key">Secret Key <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" maxlength="50" id="secret_key" name="secret_key"
                                    required>
                                <input type="hidden" class="form-control file_id" name="file_id">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    @push('script')
        <script>
            Dropzone.options.uploadForm = { // camelized version of the `id`
                paramName: "file", // The name that will be used to transfer the file
                maxFilesize: 50, // MB
                addRemoveLinks: true,
                uploadMultiple: true,
                parallelUploads: 5,
                acceptedFiles: ".doc, .docx, .xlsx, .xls, .ppt, .pptx, .pdf, .jpg, .jpeg, .png, .gif, .dxf, .dwg, .ai, .psd, .cdm, .zip, .rar",
                accept: function(file, done) {
                    done();
                }
            };

            $(document).ready(function(){

                $("#btnUpload").click(function() {
                    location.reload();
                });

                $('.btnEdit').click(function() {
                    let id = $(this).attr('data-id');
                    let filename = $('.' + id + 'filename').attr('data-filename');
                    let arrFilename = filename.split('.');
                    $('#rename').val(arrFilename[0]);
                    $('.file_id').val(id);
                });

                $('.btnEncryption').click(function() {
                    let id = $(this).attr('data-id');
                    $('#secret_key').val('');
                    $('.file_id').val(id);
                });

                $("#triggerUpload").click(function() {
                    $('#fileName').val('');
                });
            });
        </script>
    @endpush
@endsection
