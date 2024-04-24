<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Edukasi extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Pasien_model');
        $this->load->model('Edukasi_model');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'user/index';

        echo modules::run('template/loadview', $data, $page);
    }

    public function materiedukasi()
    {
        $data['title'] = 'Materi Edukasi';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'edukasi/materi_edukasi';
        echo modules::run('template/loadview', $data, $page);
    }

    public function getAllmateris()
    {
        $data = $this->Edukasi_model->fetch_all_materis();
        echo json_encode($data);
    }

    public function fetchSingleUser()
    {
        $output = array();
        $data = $this->Edukasi_model->fetch_single_user($_POST['id']);

        foreach ($data as $row) {
            $output['nama_akun'] = $row->nama;
            $output['nama_pegawai'] = $row->nama;
            $output['username'] = $row->username;
            $output['id_user'] = $row->id_user;
            $output['role_id'] = $row->role_id;
            $output['nama_akun'] = $row->nama;;
        }
        echo json_encode($output);
    }

    public function simpanaksesmateri()
    {
        $data = array(
            'id_konten_edukasi'            => $_POST['materi'],
            'id_user'            => $_POST['id_user'],
            'id_pasien'        => $_POST['id_pasien'],
            'status'          => 'aktif',
        );

        $this->Edukasi_model->simpan_akses_materi($data);
        echo json_encode($data);
    }

    public function tabelkontenedukasi()
    {
        $fetch_data = $this->Edukasi_model->make_datatables_akses_materi();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            if ($row->status == 'selesai') {
                $status = '<span href="#" class="status badge badge-primary" title="waktu akses" >' . $row->status . '</span>';
            } else {
                $status = '<span href="#" class="status badge badge-success" title="waktu akses" >' . $row->status . '</span>';
            }

            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            if ($row->status == 'selesai') {
                $akses = '';
            } else {
                $akses = '<a href="#" class="fa fa-pen-square fa-lg ml-2 mr-2 text-primary akses_materi" id="' . $row->id . '" data-toggle="modal" data-target="#staticBackdrop" title="akses"></a>';
            }

            $sub_array[] = $akses;
            $sub_array[] = "<b>" . $row->judul . "</b>";
            $sub_array[] = '<span href="#" class="status badge badge-primary" title="waktu akses" >' . $row->created_at . '</span><br>' . '<span href="#" class="status badge badge-info" title="Diperbarui" >' . $row->updated_at . '</span><br>';
            $sub_array[] = $status;

            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Edukasi_model->get_all_data_akses_materi(),
            "recordsFiltered"     => $this->Edukasi_model->get_filtered_data_akses_materi(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function aksesmateri($id)
    {
        $data['title'] = 'Konten';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();
        $data['id_akses_materi'] = $id;

        $query_akses_materi = $this->db->select('*')->get_where('akses_materi', ['id' => $id])->row_array();
        $id_konten_edukasi = $query_akses_materi['id_konten_edukasi'];
        $data['idk'] = $id_konten_edukasi;
        $data['idakses'] = $id;

        $data['data_materi'] =
            $this->db->select('
                            konten_edukasi.judul,
                            list_konten_edukasi.link
                            ')
            ->join('list_konten_edukasi', 'list_konten_edukasi.id_edukasi = konten_edukasi.id', 'LEFT')
            ->get_where('konten_edukasi', ['konten_edukasi.id' => $id_konten_edukasi])->result_array();

        $data['content'] = '';
        $page = 'edukasi/akses_materi';
        echo modules::run('template/loadview', $data, $page);
    }

    public function data_materi_edukasi()
    {
        $id_materi_edukasi = $_POST['id_materi_edukasi'];
        $cek_materi_edukasi = $this->db->select('
                            konten_edukasi.id AS id_konten_edukasi,
                            konten_edukasi.judul,
                            list_konten_edukasi.link,
                            list_konten_edukasi.id AS id_list_edukasi,

                            ')
            ->join('list_konten_edukasi', 'list_konten_edukasi.id_edukasi = konten_edukasi.id', 'LEFT')
            // ->join('pertanyaan_konten_edukasi', 'pertanyaan_konten_edukasi.id_list_edukasi = list_konten_edukasi.id', 'LEFT')
            // ->join('jawaban_konten_edukasi', 'jawaban_konten_edukasi.id_pertanyaan = pertanyaan_konten_edukasi.id', 'LEFT')
            ->get_where('konten_edukasi', ['konten_edukasi.id' => $id_materi_edukasi])->result_array();

        if ($cek_materi_edukasi) {

            echo json_encode([
                'metadata' => [
                    'result' => [
                        'datamateri' => $cek_materi_edukasi,
                    ],
                    'message' => 'Data ada',
                    'code' => 200
                ],
            ], 201);
        } else {
            echo json_encode([
                'metadata' => [
                    'message' => 'Data tidak ada',
                    'code' => 201
                ],
            ], 200);
        }
    }

    public function datapertanyaan()
    {
        $id_list_edukasi = $_POST['id_list_edukasi'];
        $cek_pertanyaan_edukasi = $this->db->select('
                            pertanyaan_konten_edukasi.id,
                            pertanyaan_konten_edukasi.id_list_edukasi,
                            pertanyaan_konten_edukasi.jenis,
                            pertanyaan_konten_edukasi.pertanyaan,
                            pertanyaan_konten_edukasi.keterangan,
                            pertanyaan_konten_edukasi.urutan,
                            pertanyaan_konten_edukasi.status,

                            ')
            // ->join('list_konten_edukasi', 'list_konten_edukasi.id_edukasi = konten_edukasi.id', 'LEFT')
            // ->join('pertanyaan_konten_edukasi', 'pertanyaan_konten_edukasi.id_list_edukasi = list_konten_edukasi.id', 'LEFT')
            // ->join('jawaban_konten_edukasi', 'jawaban_konten_edukasi.id_pertanyaan = pertanyaan_konten_edukasi.id', 'LEFT')
            ->get_where('pertanyaan_konten_edukasi', ['pertanyaan_konten_edukasi.id' => $id_list_edukasi])->result_array();

        if ($cek_pertanyaan_edukasi) {

            echo json_encode([
                'metadata' => [
                    'result' => [
                        'datapertanyaan' => $cek_pertanyaan_edukasi,
                    ],
                    'message' => 'Data ada',
                    'code' => 200
                ],
            ], 201);
        } else {
            echo json_encode([
                'metadata' => [
                    'message' => 'Data tidak ada',
                    'code' => 201
                ],
            ], 200);
        }
    }

    public function simpanPilihJawaban()
    {
        $cek_pilih_jawaban = $this->db->select('
                           *
                            ')
            ->get_where('pilih_jawaban_edukasi', ['pilih_jawaban_edukasi.id_pertanyaan' => $_POST['id_pertanyaan'], 'pilih_jawaban_edukasi.id_akses_materi' => $_POST['id_akses_materi']])->row_array();
        if ($cek_pilih_jawaban) {
            $data = array(
                'id_jawaban'          => $_POST['id_jawaban'],

            );

            $this->Edukasi_model->update_pilih_jawaban($data, $_POST['id_akses_materi'], $_POST['id_pertanyaan']);
        } else {
            $data = array(
                'id_akses_materi'            => $_POST['id_akses_materi'],
                'id_konten_edukasi'            => $_POST['id_konten_edukasi'],
                'id_pertanyaan'        => $_POST['id_pertanyaan'],
                'id_jawaban'          => $_POST['id_jawaban'],
                'id_pasien'          => $_POST['id_pasien'],
                'id_user'          => $_POST['id_user'],
            );

            $this->Edukasi_model->simpan_pilih_jawaban($data);
        }


        echo json_encode($data);
    }

    public function selesaiAksesMateri()
    {
        $data = array(
            'status'            => 'selesai',
        );

        $this->Edukasi_model->simpan_selesai_akses_materi($data, $_POST['id']);
    }
}
