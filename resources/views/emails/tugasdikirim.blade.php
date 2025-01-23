<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Tugas Baru Dikirim</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        h1 {
            color: #444;
        }

        p {
            margin: 0 0 15px;
        }

        ul {
            list-style: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 10px;
        }

        a {
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <h1>Tugas Baru Dikirim</h1>

    <p>Yth. {{ $task->dospem1->nama }}!</p>

    <p>Mahasiswa berikut baru saja mengunggah tugas untuk bimbingan:</p>

    <ul>
        <li><strong>Nama Mahasiswa:</strong> {{ $mahasiswa->nama }}</li>
        <li><strong>NIM:</strong> {{ $mahasiswa->nim }}</li>
        <li><strong>Nama Tugas:</strong> {{ $task->nama_tugas }}</li>
        <li><strong>Deskripsi:</strong> {{ $task->deskripsi }}</li>
        <li><strong>Link Dokumen:</strong>
            <a href="{{ $task->link_dokumen }}" target="_blank">{{ $task->link_dokumen }}</a>
        </li>
    </ul>

    <p>Mohon untuk memeriksa tugas ini di sistem bimbingan. <a href="http://bimbingan-skripsi-pnb.test:8080/">Klik
            disini</a> </p>

    <p>Terima kasih.</p>

    <hr>
    <footer>
        <p><small>Email ini dikirim secara otomatis oleh sistem bimbingan skripsi.</small></p>
    </footer>
</body>

</html>
