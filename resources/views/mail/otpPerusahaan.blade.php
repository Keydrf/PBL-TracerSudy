<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kode OTP Perusahaan</title>
    <style>
        .survey-button {
            display: inline-block;
            background-color: #04182d;
            color: white;
            padding: 6px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .survey-button:hover {
            background-color: #062e52;
        }
    </style>
</head>
<body>
    <h2>Yth. Bapak/Ibu,</h2>
    <p>Dengan hormat,</p>
    <p>Kami mengucapkan terima kasih atas partisipasi dan kerjasama Bapak/Ibu.</p>
    <p>Berikut ini adalah kode OTP perusahaan yang diperlukan untuk mengisi survei:</p>
    <h3>{{ $companyOtp }}</h3>
    @if(!empty($alumniName))
        <p>
            Nama alumni yang perlu dinilai oleh perusahaan Anda:
            <br>
            <strong>{{ $alumniName }}</strong>
        </p>
    @endif
    <p>Mohon untuk memasukkan kode tersebut pada halaman survei yang telah kami sediakan di bawah ini.</p>

    <p>
        <a href="{{ route('survei.perusahaan.verification') }}" class="survey-button">Isi Survei Sekarang</a>
    </p>

    <p>Atas perhatian dan partisipasi Bapak/Ibu, kami ucapkan terima kasih.</p>
    <p>Salam hormat,</p>
    <p><strong>Tim Survei</strong></p>
</body>
</html>
