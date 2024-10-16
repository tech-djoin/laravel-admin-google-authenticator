<style>
    .qr-code {
        text-align: center;
        margin-bottom: 20px;
    }
    .qr-code img {
        max-width: 200px;
        height: auto;
    }
</style>
<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Two-Factor Authentication</h3>
    </div>
    <div class="box-body">
        <div class="row">
            @if(!$isEnabled)
                <div class="col-md-4">
                    <div class="alert alert-info alert-dismissible">
                        <h4>
                            <i class="fa fa-info-circle"></i>
                        </h4>
                        <h5>
                            Fitur ini digunakan untuk meningkatkan proteksi terhadap akun anda. 
                            Sebagai langkah awal, anda dapat mendownload aplikasi Google Authenticator pada handphone anda
                        </h5>
                        <h5>
                            Untuk memulai, silahkan mendownload aplikasi Google Authenticator pada handphone anda
                        </h5>
                        <h5>
                            Kemudian dilanjutkan dengan aktivasi sesuai langkah - langkah berikut
                        </h5>
                    </div>
                </div>
                <div class="col-md-8">
                    <form id="enable2FAForm">
                        @csrf
                        <ol>
                            <li>
                                <p class="mb-0"><strong>Pendaftaran Pengamanan akun</strong></p>
                                <div class="text-left mb-3">
                                    <label for="img">Scan QR Code dibawah ini menggunakan Aplikasi Google Authenticator</label><br>
                                    <img class="img img-reponsive" src="data:image/png;base64,{{ $qrCodeUrl }}" alt="QR Code">
                                    <p class="mt-2 mb-1">atau dengan memasukkan kode berikut ini</p>
                                    <label for="img"><b>{{ $secret }}</b></label><br>
                                </div>
                            </li>
                            <li>
                                <p class="mb-0"><strong>Aktivasi 2 Factor Authentication</strong></p>
                                <div class="text-left mb-3">
                                    <label for="one_time_password">Masukan kode yang tertera pada aplikasi anda</label><br>
                                    <div class="form-group">
                                        <input type="hidden" name="{{config('google2fa.otp_secret_column')}}" value="{{ $secret }}">
                                        <input type="text" class="form-control" name="{{config('google2fa.otp_input')}}" placeholder="Enter 6-digit code" required>
                                    </div>
                                    <button type="submit" class="btn btn-info submit btn-sm mt-2">
                                        <i class="fa fa-floppy"></i> Aktifkan
                                    </button>
                                </div>
                            </li>
                            <li>
                                <p class="mb-3"><strong>Selanjutnya, anda akan diarahkan ke halaman verifikasi dan masukkan kembali kode yang tertera pada aplikasi</strong></p>
                            </li>
                            <li>
                                <p class="mb-3"><strong>Pengaturan pengamanan akun telah selesai</strong></p>
                            </li>
                        </ol>
                    </form>
                </div>
            @else
                <div class="col-md-12">
                    <div class="alert alert-success">
                        <i class="fa fa-check"></i> Akun anda telah terhubung dengan pengamanan tingkat lanjut
                    </div>
                    <form id="disable2FAForm">
                        @csrf
                        <div class="form-group">
                            <label>Untuk menonaktifkan 2 Factor Authentication, masukan kode pada aplikasi Google Authenticator</label>
                            <input type="text" class="form-control" name="{{config('google2fa.otp_input')}}" placeholder="Masukan 6-digit kode" required>
                        </div>
                        <button type="submit" class="btn btn-danger">Non Aktifkan 2FA</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
$(function() {
    @if(!$isEnabled)
        $('#enable2FAForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                url: '{{ admin_url("2fa/enable") }}',
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    $.pjax.reload('#pjax-container');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        toastr.error(xhr.responseJSON.message);
                    }
                }
            });
        });
    @else
        $('#disable2FAForm').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                url: '{{ admin_url("2fa/disable") }}',
                type: 'POST',
                data: form.serialize(),
                success: function(response) {
                    $.pjax.reload('#pjax-container');
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        toastr.error(xhr.responseJSON.message);
                    }
                }
            });
        });
    @endif
});
</script>