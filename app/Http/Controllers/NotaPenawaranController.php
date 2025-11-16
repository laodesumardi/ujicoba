<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class NotaPenawaranController extends Controller
{
    /**
     * Generate dan download nota penawaran harga sebagai PDF
     */
    public function download()
    {
        $data = $this->getNotaData();

        try {
            $pdf = Pdf::loadView('nota-penawaran', $data)
                ->setPaper('a4', 'portrait')
                ->setOption('enable-local-file-access', true)
                ->setOption('isHtml5ParserEnabled', true)
                ->setOption('isRemoteEnabled', true)
                ->setOption('isPhpEnabled', true)
                ->setOption('chroot', [
                    public_path(),
                    base_path('public'),
                ]);

            $filename = 'Nota_Penawaran_Harga_SMP_Negeri_01_Namrole_' . date('Y-m-d') . '.pdf';

            return $pdf->download($filename);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal membuat PDF: ' . $e->getMessage());
        }
    }

    /**
     * Preview nota penawaran (HTML)
     */
    public function preview()
    {
        $data = $this->getNotaData();

        return view('nota-penawaran', $data);
    }

    /**
     * Get nota data with QR code path
     */
    private function getNotaData()
    {
        // Get absolute path for QR code - DomPDF needs absolute path
        $qrCodePath = public_path('qrcode.png');
        $qrCodeSrc = '';
        
        if (file_exists($qrCodePath) && is_readable($qrCodePath)) {
            // Convert to base64 (most reliable for DomPDF)
            try {
                $imageData = file_get_contents($qrCodePath);
                if ($imageData !== false && strlen($imageData) > 0) {
                    $base64 = base64_encode($imageData);
                    if ($base64 !== false && strlen($base64) > 0) {
                        $qrCodeSrc = 'data:image/png;base64,' . $base64;
                    }
                }
            } catch (\Exception $e) {
                \Log::warning('Failed to encode QR code: ' . $e->getMessage());
            }
        }

        return [
            'tanggal' => now()->locale('id')->translatedFormat('d F Y'),
            'no_penawaran' => 'PEN/SPN01/2025/001',
            'kepada' => 'Kepala Sekolah SMP Negeri 01 Namrole',
            'dari' => 'Tim Pengembang Website',
            'qr_code' => $qrCodeSrc,
        ];
    }
}


