<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="assets/css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;600&display=swap" rel="stylesheet">

    <style>
        /* 1. Animasi dan Latar Belakang Modal */
        .modal {
            /* MODIFIKASI: Menghilangkan latar belakang overlay yang gelap */
            background-color: transparent;

            /* Keadaan awal untuk animasi: tidak terlihat dan sedikit mengecil */
            opacity: 0;
            visibility: hidden;
            transform: scale(0.95);
            /* Transisi halus untuk properti yang dianimasikan */
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0s 0.3s;
        }

        .modal.show {
            /* Keadaan aktif: terlihat sepenuhnya dan ukuran normal */
            opacity: 1;
            visibility: visible;
            transform: scale(1);
            transition: opacity 0.3s ease, transform 0.3s ease, visibility 0s 0s;
        }

        /* 2. Tema Abu-abu Gelap untuk Form */
        #login form {
            background-color: #2D3748;
            /* Latar Belakang Abu-abu Gelap */
        }

        /* 3. Penyesuaian Warna Font dan Input */
        /* Label */
        #login form label {
            color: #E2E8F0;
            /* Warna terang agar mudah dibaca */
        }

        /* Kolom Input */
        #login form input[type="text"],
        #login form input[type="password"] {
            margin-top: 0;
            color: #E2E8F0;
            /* Warna terang untuk teks yang diketik */
            background-color: #4A5568;
            /* Abu-abu sedikit lebih terang untuk area input */
            border: 1px solid #718096;
            /* Border agar area input terlihat jelas */
        }

        /* Teks Placeholder */
        #login form input[type="text"]::placeholder,
        #login form input[type="password"]::placeholder {
            color: #A0AEC0;
            /* Warna abu-abu redup untuk placeholder */
        }

        #login form input[type="text"]::-ms-input-placeholder,
        #login form input[type="password"]::-ms-input-placeholder {
            /* IE 10-11 */
            color: #A0AEC0;
        }

        #login form input[type="text"]:-ms-input-placeholder,
        #login form input[type="password"]:-ms-input-placeholder {
            /* Edge */
            color: #A0AEC0;
        }

        /* Tombol Tutup (×) */
        #login form .close-btn {
            color: #E2E8F0;
            /* Warna terang untuk tombol 'x' */
        }
    </style>

</head>

<body>

    <button class="open-btn" onclick="openModal()" style="font-weight: 530">LOGIN</button>

    <div class="modal" id="login">
        <div class="background">
            <div class="shape"></div>
            <div class="shape"></div>
        </div>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <button type="button" class="close-btn" onclick="closeModal()">×</button>

            <label for="username">Username</label>
            <input type="text" id="username" name="username" placeholder="Username" value="{{ old('username') }}"
                required>

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password" required>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button type="submit">Log In</button>
        </form>
    </div>

    <script>
        function openModal() {
            const modal = document.getElementById("login");
            modal.style.display = "flex";
            setTimeout(() => {
                modal.classList.add("show");
            }, 10);
        }

        function closeModal() {
            const modal = document.getElementById("login");
            modal.classList.remove("show");
            setTimeout(() => {
                modal.style.display = "none";
            }, 300);
        }
    </script>

</body>

</html>
