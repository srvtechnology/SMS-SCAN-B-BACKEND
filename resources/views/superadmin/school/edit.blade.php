@extends('layouts.main')
@section('page_title', 'Schools')
@section('content')

    <div class="content-wrapper">
        <!-- Content -->
        <div class="container-xxl flex-grow-1 container-p-y">
            <div class="d-flex justify-content-between">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb breadcrumb-style2 mb-0">
                        <li class="breadcrumb-item">
                            <a href="{{ url('home') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('superadmin.schools') }}">Schools</a>
                        </li>
                        <li class="breadcrumb-item active">Create School</li>
                    </ol>
                </nav>
                <a href="{{ route('superadmin.schools') }}" class="btn rounded-pill btn-primary text-white">Back</a>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="my-3">
                        <div class="card mb-4">
                            <div class="card-body">
                                <form action="{{ route('superadmin.schools.update') }}" method="POST"
                                    enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="{{ $school->id }}">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <div class="d-flex align-items-start align-items-sm-center gap-4">
                                                <img src="{{ getSchoolLogo($school->id) }}" alt="user-avatar"
                                                    class="d-block img-fluid rounded" height="100" width="100"
                                                    id="uploadedAvatar" />
                                                <div class="button-wrapper">
                                                    <label for="upload" class="btn btn-primary me-2 mb-4" tabindex="0">
                                                        <span class="d-none d-sm-block">Upload new photo</span>
                                                        <i class="bx bx-upload d-block d-sm-none"></i>
                                                        <input type="file" name="image" id="upload"
                                                            class="account-file-input" hidden
                                                            accept="image/png, image/jpeg" />
                                                    </label>

                                                    <p class="text-muted mb-0">Allowed JPG or PNG.</p>
                                                </div>
                                            </div>
                                            @error('image')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="name">School Name</label>
                                            <input type="text" name="name"
                                                class="form-control @error('name') is-invalid @enderror" id="name" value="{{ old('name',$school->name) }}">
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="email">Email</label>
                                            <div class="input-group input-group-merge">
                                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email',$school->email) }}" readonly>
                                            </div>
                                            @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="contact_number">Contact Number</label>
                                            <input type="text" name="contact_number" id="contact_number"
                                                class="form-control phone-mask @error('contact_number') is-invalid @enderror"  value="{{ old('contact_number',$school->contact_number) }}">
                                            @error('contact_number')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="landline_number">Landland Number</label>
                                            <input type="text" name="landline_number" id="landline_number"
                                                class="form-control phone-mask @error('landline_number') is-invalid @enderror" value="{{ old('landline_number',$school->landline_number) }}">
                                            @error('landline_number')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="affilliation_number">Affilliation Number</label>
                                            <input type="text" name="affilliation_number" class="form-control @error('affilliation_number',$school->affilliation_number) is-invalid @enderror"
                                                id="affilliation_number" value="{{ old('affilliation_number',$school->affilliation_number) }}">
                                            @error('affilliation_number')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="board">Board</label>
                                            <input type="text" name="board" class="form-control @error('board') is-invalid @enderror" id="board" value="{{ old('name',$school->board) }}">
                                            @error('board')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="school_type">School Type</label>
                                            <select name="type" class="form-control @error('type') is-invalid @enderror" id="type">
                                                <option value="secondary" @if($school->type == 'secondary') selected @endif>Secondary</option>
                                                <option value="higher_secondary" @if($school->type == 'higher_secondary') selected @endif>Higher Secondary</option>
                                            </select>
                                            @error('school_type')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label class="form-label" for="medium">Education Medium</label>
                                            <select name="medium" class="form-control @error('medium') is-invalid @enderror" id="medium">
                                                <option value="english" @if($school->medium == 'english') selected @endif>English</option>
                                                <option value="bhutness" @if($school->medium == 'bhutness') selected @endif>Bhutness</option>
                                                <option value="both" @if($school->medium == 'both') selected @endif>Both</option>
                                            </select>
                                            @error('medium')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-md-12 mb-3">
                                            <label class="form-label" for="address">Address</label>
                                            <textarea id="address" name="address" class="form-control @error('address') is-invalid @enderror">{{ old('address',$school->address) }}</textarea>
                                            @error('address')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary float-end">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- / Content -->
        <div class="content-backdrop fade"></div>
    </div>

    @push('footer-script')
        <script>
            $(document).ready(function() {
                $('#example').DataTable({
                    responsive: true
                });
            });
        </script>
    @endpush
@endsection
