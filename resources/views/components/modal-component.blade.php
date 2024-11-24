@if (session('success'))
    @include('components.modal', ['message' => session('success')])
@endif
@if ($errors->any())
    @include('components.modal', [
        'message' => str_contains($errors->first(), 'required')
            ? 'Mohon isi semua kolom'
            : (str_contains($errors->first(), 'thumbnail failed to upload')
                ? 'Format thumbnail tidak sesuai (max 2MB dan .jpg, .jpeg, .png)'
                : 'Terdapat format data yang salah'),
    ])
@endif
@if (session('invalid'))
    @include('components.modal', ['message' => session('invalid')])
@endif
