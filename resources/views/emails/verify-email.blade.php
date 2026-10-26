<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Alamat Email - SMAN 1 Malingping</title>
    <style>
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; border: 0; outline: none; text-decoration: none; }
        body { margin: 0; padding: 0; width: 100% !important; background-color: #F9F8F6; font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #3D3935; }
        @media only screen and (max-width: 620px) {
            .email-container { width: 100% !important; padding: 12px !important; }
            .card-body { padding: 24px 20px !important; }
            .btn-verify { display: block !important; width: 100% !important; text-align: center !important; }
            .h1-title { font-size: 22px !important; line-height: 28px !important; }
        }
    </style>
</head>
<body style="margin: 0; padding: 0; background-color: #F9F8F6; -webkit-font-smoothing: antialiased;">

    <!-- Wrapper Table -->
    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #F9F8F6; padding: 36px 12px;">
        <tr>
            <td align="center">

                <!-- Main Container (Max 580px) -->
                <table role="presentation" class="email-container" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 580px; margin: 0 auto;">

                    <!-- Brand Header -->
                    <tr>
                        <td align="center" style="padding-bottom: 24px;">
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td align="center" style="padding-bottom: 8px;">
                                        <a href="{{ url('/') }}" target="_blank" style="text-decoration: none; display: inline-block;">
                                            <img src="{{ asset('icon.png') }}" alt="Logo SMAN 1 Malingping" width="52" height="52" style="display: block; width: 52px; height: 52px; border: 0;">
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="center">
                                        <div style="font-family: 'Fraunces', Georgia, 'Times New Roman', serif; font-size: 22px; font-weight: 700; color: #2A5C43; letter-spacing: -0.3px;">
                                            SMAN 1 <span style="color: #CC7A6B;">Malingping</span>
                                        </div>
                                        <div style="font-size: 11px; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px; color: #8A857F; margin-top: 3px;">
                                            Portal Komunitas & Informasi Sekolah
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Main Content Card -->
                    <tr>
                        <td>
                            <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #FFFFFF; border-radius: 20px; border: 1px solid #EBE7E0; box-shadow: 0 4px 16px rgba(42, 39, 36, 0.04); overflow: hidden;">
                                
                                <!-- Top Accent Bar (Gradient Forest to Terracotta) -->
                                <tr>
                                    <td height="6" style="background: linear-gradient(90deg, #2A5C43 0%, #3D8B62 60%, #CC7A6B 100%); line-height: 6px; font-size: 6px;">&nbsp;</td>
                                </tr>

                                <!-- Card Body -->
                                <tr>
                                    <td class="card-body" style="padding: 36px 36px 32px 36px;">

                                        <!-- Badge -->
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 20px;">
                                            <tr>
                                                <td style="background-color: #EBF3EE; border: 1px solid #D1E5D8; border-radius: 50px; padding: 4px 14px;">
                                                    <span style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1.2px; color: #2A5C43;">
                                                        Konfirmasi Pendaftaran Akun
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Greeting & Title -->
                                        <h1 class="h1-title" style="margin: 0 0 16px 0; font-family: 'Fraunces', Georgia, 'Times New Roman', serif; font-size: 26px; line-height: 32px; font-weight: 700; color: #1A1816; letter-spacing: -0.4px;">
                                            Verifikasi Alamat Email Anda
                                        </h1>

                                        <p style="margin: 0 0 16px 0; font-size: 15px; line-height: 24px; color: #3D3935;">
                                            Halo, <strong>{{ $user->name ?? 'Warga Sekolah' }}</strong>!
                                        </p>

                                        <p style="margin: 0 0 24px 0; font-size: 14px; line-height: 23px; color: #57534E;">
                                            Terima kasih telah bergabung di <strong>Portal Komunitas SMAN 1 Malingping</strong>
                                            @if(!empty($user->role_type))
                                                sebagai <strong>{{ $user->role_badge['label'] ?? ucfirst($user->role_type) }}</strong>
                                            @endif.
                                            Untuk menjaga keamanan data dan mengaktifkan akun Anda, silakan verifikasi alamat email ini dengan mengeklik tombol di bawah:
                                        </p>

                                        <!-- Verification CTA Button -->
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 28px 0 32px 0;">
                                            <tr>
                                                <td align="center">
                                                    <!--[if mso]>
                                                    <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ $url }}" style="height:48px;v-text-anchor:middle;width:280px;" arcsize="25%" stroke="f" fillcolor="#2A5C43">
                                                    <w:anchorlock/>
                                                    <center style="color:#ffffff;font-family:sans-serif;font-size:14px;font-weight:bold;">Verifikasi Email Saya</center>
                                                    </v:roundrect>
                                                    <![endif]-->
                                                    <a href="{{ $url }}" target="_blank" class="btn-verify" style="background-color: #2A5C43; border-radius: 12px; color: #FFFFFF; display: inline-block; font-size: 14px; font-weight: 700; line-height: 48px; text-align: center; text-decoration: none; width: auto; padding: 0 32px; -webkit-text-size-adjust: none; mso-hide: all; box-shadow: 0 4px 12px rgba(42, 92, 67, 0.25);">
                                                        Verifikasi Email Saya &rarr;
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Expiry Notice Box -->
                                        <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #F9F8F6; border: 1px solid #EBE7E0; border-radius: 12px; margin-bottom: 24px;">
                                            <tr>
                                                <td style="padding: 14px 16px;">
                                                    <table role="presentation" border="0" cellpadding="0" cellspacing="0" width="100%">
                                                        <tr>
                                                            <td width="24" valign="top" style="font-size: 16px; line-height: 20px; padding-right: 8px;">⏳</td>
                                                            <td style="font-size: 12px; line-height: 18px; color: #57534E;">
                                                                Tautan verifikasi ini akan kedaluwarsa dalam waktu <strong>60 menit</strong> sejak email ini dikirimkan.
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Fallback Raw Link -->
                                        <p style="margin: 0 0 8px 0; font-size: 12px; line-height: 18px; color: #8A857F;">
                                            Jika Anda mengalami kesulitan mengeklik tombol di atas, salin dan tempelkan alamat tautan berikut ke peramban (browser) Anda:
                                        </p>
                                        <p style="margin: 0; font-size: 11px; line-height: 18px; word-break: break-all;">
                                            <a href="{{ $url }}" target="_blank" style="color: #2A5C43; text-decoration: underline;">
                                                {{ $url }}
                                            </a>
                                        </p>

                                    </td>
                                </tr>

                                <!-- Card Bottom Motto Banner -->
                                <tr>
                                    <td style="background-color: #FAF8F5; border-top: 1px solid #EBE7E0; padding: 14px 24px; text-align: center;">
                                        <span style="font-size: 12px; font-weight: 600; color: #2A5C43; letter-spacing: 0.5px;">
                                            🌿 Cageur, Bageur, Bener, Pinter.
                                        </span>
                                    </td>
                                </tr>

                            </table>
                        </td>
                    </tr>

                    <!-- Footer Info & Disclaimer -->
                    <tr>
                        <td align="center" style="padding-top: 28px; padding-bottom: 12px;">
                            <p style="margin: 0 0 6px 0; font-size: 12px; line-height: 18px; color: #8A857F;">
                                <strong>SMA Negeri 1 Malingping</strong><br>
                                Jl. Beyeh - Simpang, Malingping, Kab. Lebak, Banten 42392
                            </p>
                            <p style="margin: 0 0 12px 0; font-size: 11px; line-height: 16px; color: #A8A29E;">
                                &copy; {{ date('Y') }} SMAN 1 Malingping. Seluruh Hak Cipta Dilindungi.
                            </p>
                            <p style="margin: 0; font-size: 11px; line-height: 16px; color: #A8A29E;">
                                Anda menerima email ini karena alamat email Anda didaftarkan pada portal sekolah. Jika Anda tidak pernah merasa mendaftar, Anda dapat mengabaikan email ini dengan aman.
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
