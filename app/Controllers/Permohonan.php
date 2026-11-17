<?php

namespace App\Controllers;

use App\Models\JenisIzinModel;
use App\Models\PermohonanModel;
use App\Models\RiwayatTahapanModel;
use App\Models\TahapanAlurModel;

class Permohonan extends BaseController
{
    private array $namaBulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
        7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    private function jenisAktif(): array
    {
        return (new JenisIzinModel())->where('aktif', 1)->orderBy('urutan')->findAll();
    }

    private function pilihJenis(array $daftarJenis, int $id): ?array
    {
        foreach ($daftarJenis as $j) {
            if ((int) $j['id'] === $id) {
                return $j;
            }
        }

        return $daftarJenis[0] ?? null;
    }

    private function buatNomor(array $jenis, int $tahun): string
    {
        $model = new PermohonanModel();

        $urut = $model->where('jenis_izin_id', $jenis['id'])
            ->where('tanggal_terima >=', "$tahun-01-01")
            ->where('tanggal_terima <=', "$tahun-12-31")
            ->countAllResults() + 1;

        do {
            $nomor = sprintf('%s/%d/%04d', $jenis['kode'], $tahun, $urut++);
            $ada   = $model->where('nomor_register', $nomor)->countAllResults() > 0;
        } while ($ada);

        return $nomor;
    }

    public function index()
    {
        $daftarJenis = $this->jenisAktif();
        $jenis       = $this->pilihJenis($daftarJenis, (int) $this->request->getGet('jenis'));

        if ($jenis === null) {
            return view('permohonan/index', ['judul' => 'Daftar Berkas', 'daftarJenis' => [], 'jenis' => null]);
        }

        $proses = $this->request->getGet('proses') === 'pencabutan' ? 'pencabutan' : 'permohonan';
        if (! $jenis['punya_pencabutan']) {
            $proses = 'permohonan';
        }

        $tahun = (int) ($this->request->getGet('tahun') ?? date('Y'));
        if ($tahun < 2000 || $tahun > 2100) {
            $tahun = (int) date('Y');
        }

        $bulan = (int) ($this->request->getGet('bulan') ?? date('n'));
        if ($bulan < 0 || $bulan > 12) {
            $bulan = 0;
        }

        if ($bulan > 0) {
            $awal  = sprintf('%04d-%02d-01', $tahun, $bulan);
            $akhir = date('Y-m-t', strtotime($awal));
        } else {
            $awal  = sprintf('%04d-01-01', $tahun);
            $akhir = sprintf('%04d-12-31', $tahun);
        }

        $daftar = (new PermohonanModel())
            ->select('permohonan.*, tahapan_alur.nama_tahap')
            ->join('tahapan_alur', 'tahapan_alur.id = permohonan.tahapan_id', 'left')
            ->where('permohonan.jenis_izin_id', $jenis['id'])
            ->where('permohonan.jenis_proses', $proses)
            ->where('permohonan.tanggal_terima >=', $awal)
            ->where('permohonan.tanggal_terima <=', $akhir)
            ->orderBy('permohonan.tanggal_terima', 'DESC')
            ->orderBy('permohonan.id', 'DESC')
            ->findAll();

        $ringkasan = ['total' => count($daftar), 'proses' => 0, 'selesai' => 0];
        foreach ($daftar as $row) {
            if ($row['status'] === 'selesai') {
                $ringkasan['selesai']++;
            } elseif ($row['status'] === 'proses') {
                $ringkasan['proses']++;
            }
        }

        return view('permohonan/index', [
            'judul'       => 'Daftar Berkas',
            'daftarJenis' => $daftarJenis,
            'jenis'       => $jenis,
            'proses'      => $proses,
            'bulan'       => $bulan,
            'tahun'       => $tahun,
            'namaBulan'   => $this->namaBulan,
            'daftar'      => $daftar,
            'ringkasan'   => $ringkasan,
        ]);
    }

    public function tambah()
    {
        $jenis = $this->pilihJenis($this->jenisAktif(), (int) $this->request->getGet('jenis'));

        if ($jenis === null) {
            return redirect()->to('/permohonan')->with('error', 'Belum ada jenis izin aktif.');
        }

        $proses = ($this->request->getGet('proses') === 'pencabutan' && $jenis['punya_pencabutan'])
            ? 'pencabutan'
            : 'permohonan';

        return view('permohonan/form', [
            'judul'  => 'Register Berkas Baru',
            'jenis'  => $jenis,
            'proses' => $proses,
        ]);
    }

    public function simpan()
    {
        $jenis = (new JenisIzinModel())
            ->where('aktif', 1)
            ->find((int) $this->request->getPost('jenis_izin_id'));

        if (! $jenis) {
            return redirect()->to('/permohonan')->with('error', 'Jenis izin tidak valid.');
        }

        $rules = [
            'nama_pemohon'   => 'required|max_length[150]',
            'nama_kuasa'     => 'permit_empty|max_length[150]',
            'no_hp'          => 'permit_empty|max_length[30]',
            'tanggal_terima' => 'required|valid_date[Y-m-d]',
            'kelengkapan'    => 'required|in_list[lengkap,tidak_lengkap]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $proses = ($this->request->getPost('jenis_proses') === 'pencabutan' && $jenis['punya_pencabutan'])
            ? 'pencabutan'
            : 'permohonan';

        $tanggal = $this->request->getPost('tanggal_terima');
        $tahun   = (int) substr($tanggal, 0, 4);

        $tahapan = (new TahapanAlurModel())
            ->where('jenis_izin_id', $jenis['id'])
            ->orderBy('urutan')
            ->findAll();

        if (empty($tahapan)) {
            return redirect()->back()->withInput()->with('error', 'Tahapan alur untuk jenis izin ini belum diatur.');
        }

        // Tahap awal yang dikerjakan front office dianggap selesai; berikutnya menunggu peran lain
        $selesai = [];
        $berikut = null;
        foreach ($tahapan as $t) {
            if ($t['peran'] === 'front_office') {
                $selesai[] = $t;
            } else {
                $berikut = $t;
                break;
            }
        }

        $nomor = $this->buatNomor($jenis, $tahun);

        $db = \Config\Database::connect();
        $db->transStart();

        $model = new PermohonanModel();
        $model->insert([
            'nomor_register'    => $nomor,
            'jenis_izin_id'     => $jenis['id'],
            'jenis_proses'      => $proses,
            'uraian_permohonan' => trim((string) $this->request->getPost('uraian_permohonan')),
            'nama_pemohon'      => trim($this->request->getPost('nama_pemohon')),
            'nama_kuasa'        => trim((string) $this->request->getPost('nama_kuasa')),
            'lokasi'            => trim((string) $this->request->getPost('lokasi')),
            'no_hp'             => trim((string) $this->request->getPost('no_hp')),
            'kelengkapan'       => $this->request->getPost('kelengkapan'),
            'tanggal_terima'    => $tanggal,
            'tahapan_id'        => $berikut['id'] ?? null,
            'status'            => $berikut ? 'proses' : 'selesai',
            'dibuat_oleh'       => session()->get('user_id'),
        ]);
        $permohonanId = $model->getInsertID();

        $riwayat  = new RiwayatTahapanModel();
        $sekarang = date('Y-m-d H:i:s');
        foreach ($selesai as $t) {
            $riwayat->insert([
                'permohonan_id' => $permohonanId,
                'tahapan_id'    => $t['id'],
                'pengguna_id'   => session()->get('user_id'),
                'tanggal'       => $sekarang,
                'catatan'       => null,
            ]);
        }

        $db->transComplete();

        if (! $db->transStatus()) {
            return redirect()->back()->withInput()->with('error', 'Gagal menyimpan berkas, silakan coba lagi.');
        }

        $bulan = (int) date('n', strtotime($tanggal));

        return redirect()
            ->to('/permohonan?jenis=' . $jenis['id'] . '&proses=' . $proses . '&bulan=' . $bulan . '&tahun=' . $tahun)
            ->with('sukses', 'Berkas terdaftar dengan nomor ' . $nomor);
    }
}