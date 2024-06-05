@if (session('success'))
    @include('components.modal', ['message' => session('success')])
@endif
@if ($errors->any())
    @include('components.modal', [
        'message' => str_contains($errors->first(), 'required')
            ? 'Mohon isi semua kolom'
            : (str_contains($errors->first(), 'must be a number')
                ? 'Terdapat format data yang salah'
                : 'Terjadi kesalahan'),
    ])
@endif
@if (session('invalid'))
    @include('components.modal', ['message' => session('invalid')])
@endif
