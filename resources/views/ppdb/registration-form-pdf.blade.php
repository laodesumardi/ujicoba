<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pendaftaran PPDB - {{ $registration->registration_number }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            border-bottom: 3px solid #14213d;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            color: #14213d;
            margin: 0;
            font-size: 24px;
        }
        .header h2 {
            color: #666;
            margin: 10px 0 0 0;
            font-size: 18px;
            font-weight: normal;
        }
        .registration-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            border-left: 4px solid #14213d;
        }
        .registration-info h3 {
            color: #14213d;
            margin: 0 0 10px 0;
            font-size: 16px;
        }
        .registration-number {
            font-size: 18px;
            font-weight: bold;
            color: #14213d;
        }
        .form-section {
            margin-bottom: 25px;
        }
        .form-section h3 {
            color: #14213d;
            border-bottom: 2px solid #e9ecef;
            padding-bottom: 8px;
            margin-bottom: 15px;
            font-size: 16px;
        }
        .form-row {
            display: flex;
            margin-bottom: 15px;
        }
        .form-group {
            flex: 1;
            margin-right: 15px;
        }
        .form-group:last-child {
            margin-right: 0;
        }
        .form-group label {
            display: block;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
            font-size: 12px;
        }
        .form-group .value {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            padding: 8px 12px;
            border-radius: 4px;
            font-size: 12px;
            min-height: 20px;
        }
        .form-group.full-width {
            flex: 100%;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            color: #666;
            font-size: 12px;
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-approved {
            background: #d4edda;
            color: #155724;
        }
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        .status-rejected {
            background: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <h1>FORM PENDAFTARAN PPDB</h1>
            <h2>SMP Negeri 01 Namrole</h2>
            <p>Tahun Ajaran 2024/2025</p>
        </div>

        <!-- Registration Info -->
        <div class="registration-info">
            <h3>Informasi Pendaftaran</h3>
            <p><strong>Nomor Pendaftaran:</strong> <span class="registration-number">{{ $registration->registration_number }}</span></p>
            <p><strong>Tanggal Pendaftaran:</strong> {{ $registration->created_at->format('d F Y') }}</p>
            <p><strong>Status:</strong> 
                <span class="status-badge status-{{ $registration->status }}">
                    {{ ucfirst($registration->status) }}
                </span>
            </p>
        </div>

        <!-- Personal Information -->
        <div class="form-section">
            <h3>Data Pribadi</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <div class="value">{{ $registration->student_name }}</div>
                </div>
                <div class="form-group">
                    <label>Nomor Pendaftaran</label>
                    <div class="value">{{ $registration->registration_number }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <div class="value">{{ $registration->birth_place }}</div>
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <div class="value">{{ \Carbon\Carbon::parse($registration->birth_date)->format('d F Y') }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Jenis Kelamin</label>
                    <div class="value">{{ $registration->gender == 'L' ? 'Laki-laki' : 'Perempuan' }}</div>
                </div>
                <div class="form-group">
                    <label>Agama</label>
                    <div class="value">{{ $registration->religion }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group full-width">
                    <label>Alamat Lengkap</label>
                    <div class="value">{{ $registration->address }}</div>
                </div>
            </div>
        </div>

        <!-- Contact Information -->
        <div class="form-section">
            <h3>Informasi Kontak</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Email</label>
                    <div class="value">{{ $registration->email }}</div>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <div class="value">{{ $registration->phone_number }}</div>
                </div>
            </div>
        </div>

        <!-- Parent Information -->
        <div class="form-section">
            <h3>Data Orang Tua/Wali</h3>
            <div class="form-row">
                <div class="form-group">
                    <label>Nama Orang Tua/Wali</label>
                    <div class="value">{{ $registration->parent_name }}</div>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon Orang Tua/Wali</label>
                    <div class="value">{{ $registration->parent_phone }}</div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group full-width">
                    <label>Pekerjaan Orang Tua/Wali</label>
                    <div class="value">{{ $registration->parent_occupation }}</div>
                </div>
            </div>
        </div>

        <!-- Academic Information -->
        <div class="form-section">
            <h3>Informasi Akademik</h3>
            <div class="form-row">
                <div class="form-group full-width">
                    <label>Sekolah Asal</label>
                    <div class="value">{{ $registration->previous_school ?: 'Tidak diisi' }}</div>
                </div>
            </div>
            @if($registration->achievements)
            <div class="form-row">
                <div class="form-group full-width">
                    <label>Prestasi</label>
                    <div class="value">{{ $registration->achievements }}</div>
                </div>
            </div>
            @endif
            @if($registration->motivation)
            <div class="form-row">
                <div class="form-group full-width">
                    <label>Motivasi Masuk Sekolah</label>
                    <div class="value">{{ $registration->motivation }}</div>
                </div>
            </div>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p><strong>Catatan:</strong> Form ini adalah bukti pendaftaran PPDB. Simpan dengan baik untuk keperluan administrasi selanjutnya.</p>
            <p>Dicetak pada: {{ now()->format('d F Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>
