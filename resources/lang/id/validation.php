<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => ':attribute harus disetujui.',
    'active_url'           => ':attribute harus valid URL.',
    'after'                => ':attribute tanggal setelah :date.',
    'after_or_equal'       => ':attribute harus tanggal setelah atau sama dengan :date.',
    'alpha'                => ':attribute hanya diperbolehkan alfabet.',
    'alpha_dash'           => ':attribute hanya boleh berisi huruf, angka, dan strip.',
    'alpha_num'            => ':attribute hanya boleh berisi angka dan alfabet.',
    'array'                => ':attribute harus sebuah array.',
    'before'               => ':attribute harus tanggal sebelum :date.',
    'before_or_equal'      => ':attribute harus tanggal sebelum atau sama dengan :date.',
    'between'              => [
        'numeric' => ':attribute harus diantara :min dan :max.',
        'file'    => ':attribute harus diantara :min dan :max kilobyte.',
        'string'  => ':attribute harus diantara :min dan :max karakter.',
        'array'   => ':attribute harus diantara :min dan :max item.',
    ],
    'boolean'              => ':attribute hanya bernilai benar atau salah.',
    'confirmed'            => ':attribute konfirmasi tidak cocok.',
    'date'                 => ':attribute bukan tanggal yang valid.',
    'date_format'          => ':attribute tidak cocok dengan format :format.',
    'different'            => ':attribute dan :other harus berbeda.',
    'digits'               => ':attribute harus :digits digit.',
    'digits_between'       => ':attribute harus diantara :min and :max digit.',
    'dimensions'           => ':attribute dimensi salah.',
    'distinct'             => ':attribute tidak boleh duplikat.',
    'email'                => ':attribute harus valid email format.',
    'exists'               => ':attribute yang dipilih salah.',
    'file'                 => ':attribute harus sebuah file.',
    'filled'               => ':attribute dibutuhkan.',
    'image'                => ':attribute harus sebuah gambar.',
    'in'                   => ':attribute yang dipilih salah.',
    'in_array'             => ':attribute tidak ada di :other.',
    'integer'              => ':attribute harus angka.',
    'ip'                   => ':attribute harus valid format IP address.',
    'json'                 => ':attribute harus valid format JSON string.',
    'max'                  => [
        'numeric' => ':attribute tidak boleh lebih dari :max.',
        'file'    => ':attribute tidak boleh lebih dari :max kilobyte.',
        'string'  => ':attribute tidak boleh lebih dari :max karakter.',
        'array'   => ':attribute tidak boleh lebih dari :max item.',
    ],
    'mimes'                => ':attribute harus bertipe: :values.',
    'mimetypes'            => ':attribute harus bertipe: :values.',
    'min'                  => [
        'numeric' => ':attribute harus setidaknya :min.',
        'file'    => ':attribute harus setidaknya :min kilobyte.',
        'string'  => ':attribute harus setidaknya :min karakter.',
        'array'   => ':attribute harus setidaknya :min item.',
    ],
    'not_in'               => ':attribute tidak benar.',
    'numeric'              => ':attribute harus angka.',
    'present'              => ':attribute harus ada.',
    'regex'                => ':attribute format salah.',
    'required'             => ':attribute tidak boleh kosong.',
    'required_if'          => ':attribute harus ada ketika :other bernilai :value.',
    'required_unless'      => ':attribute harus ada kecuali jika :other bernilai :values.',
    'required_with'        => ':attribute harus ada ketika :values ada.',
    'required_with_all'    => ':attribute harus ada ketika :values ada.',
    'required_without'     => ':attribute harus ada ketika :values ada.',
    'required_without_all' => ':attribute harus ada ketika tidak satupun dari :values ada.',
    'same'                 => ':attribute dan :other harus cocok.',
    'size'                 => [
        'numeric' => ':attribute harus tepat :size.',
        'file'    => ':attribute harus tepat :size kilobyte.',
        'string'  => ':attribute harus tepat :size karakter.',
        'array'   => ':attribute harus berisi :size item.',
    ],
    'string'               => ':attribute harus sebuah string.',
    'timezone'             => ':attribute harus zona waktu yang valid.',
    'unique'               => ':attribute sudah pernah digunakan.',
    'uploaded'             => ':attribute gagal mengunggah.',
    'url'                  => ':attribute format salah.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'email' => [
            'required' => 'kami harus tahu email anda',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [
        'name' => 'Nama',
        'username' => 'Nama user',
        'password' => 'Kata sandi',
        'password_confirmation' => 'Konfirmasi kata sandi',
        'email' => 'Alamat email',
        'about' => 'Tentang',
        'birthday' => 'Tanggal lahir',
        'location' => 'Lokasi',
        'contact' => 'Kontak',
        'category' => 'Category',
        'detail' => 'Rincian',
    ],

];
