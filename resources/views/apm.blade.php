<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Menu Pendaftaran Mandiri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.lordicon.com/lordicon.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background: linear-gradient(to right, #1e3c72, #2a5298);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .menu-wrapper {
            width: 100%;
            max-width: 1200px;
            padding: 40px;
        }

        .menu-title {
            font-size: 3rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 50px;
            color: #ffffff;
        }

        .menu-card {
            height: 250px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 20px;
            background-color: #ffffff;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .menu-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.3);
        }

        .menu-icon {
            width: 100px;
            height: 100px;
            margin-bottom: 20px;
        }

        .menu-label {
            font-size: 1.4rem;
            font-weight: 600;
            text-align: center;
            color: #343a40;
        }

        @media (max-width: 768px) {
            .menu-card {
                height: 200px;
            }

            .menu-icon {
                width: 80px;
                height: 80px;
            }

            .menu-label {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>
    <div class="menu-wrapper">
        <div class="menu-title">Menu Pendaftaran Mandiri</div>
        <div class="row g-4">

            <div class="col-12 col-md-4">
                <div class="menu-card">
                    <img src="{{ asset('loket.png') }}" width="45%" class="rounded mx-auto d-block m-2"
                        alt="">

                    <div class="menu-label">Pendaftaran Poliklinik</div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="menu-card">
                    <img src="{{ asset('waiting-room_13140083.png') }}" width="45%"
                        class="rounded mx-auto d-block m-2" alt="">
                    <div class="menu-label">Antrian Loket</div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="menu-card">
                    <img src="{{ asset('medical-report_11217161.png') }}" width="45%"
                        class="rounded mx-auto d-block m-2" alt="">
                    <div class="menu-label">SEP Kontrol</div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="menu-card">
                    <img src="{{ asset('smartphone_1301972.png') }}" width="45%" class="rounded mx-auto d-block m-2"
                        alt="">
                    <div class="menu-label">Checkin Mobile JKN</div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="menu-card">
                    <img src="{{ asset('health-insurance_7858245.png') }}" width="45%"
                        class="rounded mx-auto d-block m-2" alt="">
                    <div class="menu-label">Pasien JKN</div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="menu-card">
                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="hover" class="menu-icon"
                        colors="primary:#0d6efd"></lord-icon>
                    <div class="menu-label">Kontrol Beda POLI</div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="menu-card">
                    <lord-icon src="https://cdn.lordicon.com/yxczfiyc.json" trigger="hover" class="menu-icon"
                        colors="primary:#0d6efd"></lord-icon>
                    <div class="menu-label">Aktivasi Satu Sehat</div>
                </div>
            </div>

            <div class="col-12 col-md-4">
                <div class="menu-card">
                    <lord-icon src="https://cdn.lordicon.com/nocovwne.json" trigger="hover" class="menu-icon"
                        colors="primary:#0d6efd"></lord-icon>
                    <div class="menu-label">Check in UMUM</div>
                </div>
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
