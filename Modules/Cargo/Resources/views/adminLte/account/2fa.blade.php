<div class="card">
    <div class="card-body">
        <h4>Enable Two-Factor Authentication</h4>
        <p>Secure your account by enabling two-factor authentication (2FA).</p>

        @if(!auth()->user()->two_factor_secret)
            <form method="POST" action="{{ route('2fa.enable') }}">
                @csrf
                <button type="submit" class="btn btn-primary">Enable 2FA</button>
            </form>
        @else
            <p><strong>2FA is enabled.</strong></p>
            <p>Scan the QR code below using your authentication app.</p>


            {{-- <div class="my-3">{!! auth()->user()->twoFactorQrCodeSvg() !!}</div>
            <p>Backup Codes:</p>
            <ul>
                @foreach(json_decode(decrypt(auth()->user()->two_factor_recovery_codes), true) as $code)
                    <li>{{ $code }}</li>
                @endforeach
            </ul> --}}
            <div class="my-3">
                {!! QrCode::size(200)->generate(
                    (new \PragmaRX\Google2FA\Google2FA)->getQRCodeUrl(
                        config('app.name'),
                        auth()->user()->email,
                        decrypt(auth()->user()->two_factor_secret)
                    )
                ) !!}
            </div>

            <form method="POST" action="{{ route('2fa.regenerate') }}">
                @csrf
                <button type="submit" class="btn btn-warning">Regenerate Backup Codes</button>
            </form>
            <form method="POST" action="{{ route('2fa.disable') }}" class="mt-3">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Disable 2FA</button>
            </form>
        @endif
    </div>
</div>

