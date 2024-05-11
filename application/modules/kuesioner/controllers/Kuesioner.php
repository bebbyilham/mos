<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kuesioner extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Pasien_model');
        $this->load->model('Edukasi_model');
        $this->load->model('Kuesioner_model');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'kuesioner/index';

        echo modules::run('template/loadview', $data, $page);
    }

    // public function kuesioner()
    // {
    //     $data['title'] = 'Kuesioner';
    //     $data['user'] = $this->db->get_where('user', ['username' =>
    //     $this->session->userdata('username')])->row_array();

    //     $data['content'] = '';
    //     $page = 'observasi/kuesioner_pasien';
    //     echo modules::run('template/loadview', $data, $page);
    // }

    public function pretest()
    {
        $data['title'] = 'Pre-test';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'kuesioner/pretest';
        echo modules::run('template/loadview', $data, $page);
    }

    public function posttest()
    {
        $data['title'] = 'Post-test';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'kuesioner/posttest';
        echo modules::run('template/loadview', $data, $page);
    }

    public function getAllKuesioner()
    {
        $data = $this->Kuesioner_model->fetch_all_kuesioner();
        echo json_encode($data);
    }

    public function getKuesionerPretest()
    {
        $data = $this->Kuesioner_model->fetch_kuesioner_pretest();
        echo json_encode($data);
    }

    public function getKuesionerPosttest()
    {
        $data = $this->Kuesioner_model->fetch_kuesioner_posttest();
        echo json_encode($data);
    }

    public function simpanAksesKuesioner()
    {
        $data = array(
            'id_kuesioner'          => $_POST['kuesioner'],
            'id_user'                       => $_POST['id_user'],
            'id_pasien'                     => $_POST['id_pasien'],
            'status'                        => 'aktif',
        );

        $this->Kuesioner_model->simpan_akses_kuesioner($data);
        echo json_encode($data);
    }

    public function tabelKuesioner()
    {
        $fetch_data = $this->Kuesioner_model->make_datatables_akses_kuesioner();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {

            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            if ($row->status == 'selesai') {
                $akses = '';
            } else {
                $akses = '<a href="#" class="fa fa-pen-square fa-lg ml-2 mr-2 text-primary akses_kuesioner" id="' . $row->id . '" data-toggle="modal" data-target="#staticBackdrop" title="akses"></a>';
                // $akses = '';
            }

            $sub_array[] = $akses;
            $sub_array[] = "<b>" . $row->keterangan . "</b>";
            $sub_array[] = '<span href="#" class="status badge badge-primary" title="waktu akses" >' . $row->created_at . '</span><br>' . '<span href="#" class="status badge badge-info" title="Diperbarui" >' . $row->updated_at . '</span><br>';
            if ($row->status == 'aktif') {
                $sub_array[] = '
                <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="badge badge-primary">' . $row->status . '</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a id="' . $row->id . '" status="aktif" class="dropdown-item ubahstatus">Aktif</a>
                            <a id="' . $row->id . '" status="selesai" class="dropdown-item ubahstatus">Selesai</a>
                        </div>
                </div>';
            } else {
                $sub_array[] = '
                <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="badge badge-success">' . $row->status . '</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a id="' . $row->id . '" status="aktif" class="dropdown-item ubahstatus">Aktif</a>
                            <a id="' . $row->id . '" status="selesai" class="dropdown-item ubahstatus">Selesai</a>
                        </div>
                </div>';
            }

            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Kuesioner_model->get_all_data_akses_kuesioner(),
            "recordsFiltered"     => $this->Kuesioner_model->get_filtered_data_akses_kuesioner(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function akseskuesioner($id)
    {
        $data['title'] = 'Kuesioner';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();
        $data['id_akses_materi'] = $id;

        $query_akses_target = $this->db->select('*')->get_where('akses_kuesioner', ['id' => $id])->row_array();
        $id_kuesioner = $query_akses_target['id_kuesioner'];
        $data['idk'] = $id_kuesioner;
        $data['idakses'] = $id;

        $data['data_materi'] =
            $this->db->select('
                            kuesioner.keterangan,
                            list_kuesioner.link
                            ')
            ->join('list_kuesioner', 'list_kuesioner.id_kuesioner = kuesioner.id', 'LEFT')
            ->get_where('kuesioner', ['kuesioner.id' => $id_kuesioner])->result_array();

        $data['content'] = '';
        $page = 'kuesioner/akses_kuesioner';
        echo modules::run('template/loadview', $data, $page);
    }

    public function ubahStatusAksesKuesioner()
    {
        $data = array(
            'status'            => $_POST['status'],
        );

        $this->Kuesioner_model->ubah_status_akses_kuesioner($data, $_POST['id']);
    }

    public function data_kuesioner()
    {
        $id_kuesioner = $_POST['id_kuesioner'];
        $cek_kuesioner = $this->db->select('
                            kuesioner.id AS id_kuesioner,
                            kuesioner.keterangan,
                            list_kuesioner.link,
                            list_kuesioner.id AS id_list_kuesioner,

                            ')
            ->join('list_kuesioner', 'list_kuesioner.id_kuesioner = kuesioner.id', 'LEFT')
            ->get_where('kuesioner', ['kuesioner.id' => $id_kuesioner])->result_array();

        if ($cek_kuesioner) {

            echo json_encode([
                'metadata' => [
                    'result' => [
                        'datamateri' => $cek_kuesioner,
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

    public function datapertanyaankuesioner()
    {
        $id_kuesioner = $_POST['id_kuesioner'];
        $cek_pertanyaan_edukasi = $this->db->select('
                            pertanyaan_konten_edukasi.id,
                            pertanyaan_konten_edukasi.id_kuesioner,
                            pertanyaan_konten_edukasi.jenis,
                            pertanyaan_konten_edukasi.pertanyaan,
                            pertanyaan_konten_edukasi.keterangan,
                            pertanyaan_konten_edukasi.urutan,
                            pertanyaan_konten_edukasi.status,

                            ')
            // ->join('list_konten_edukasi', 'list_konten_edukasi.id_edukasi = konten_edukasi.id', 'LEFT')
            // ->join('pertanyaan_konten_edukasi', 'pertanyaan_konten_edukasi.id_kuesioner = list_konten_edukasi.id', 'LEFT')
            // ->join('jawaban_konten_edukasi', 'jawaban_konten_edukasi.id_pertanyaan = pertanyaan_konten_edukasi.id', 'LEFT')
            ->get_where('pertanyaan_konten_edukasi', ['pertanyaan_konten_edukasi.id' => $id_kuesioner])->result_array();

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

    public function simpanPilihJawabankuesioner()
    {
        $cek_pilih_jawaban = $this->db->select('
                           *
                            ')
            ->get_where('pilih_jawaban_kuesioner', ['pilih_jawaban_kuesioner.id_pertanyaan' => $_POST['id_pertanyaan'], 'pilih_jawaban_kuesioner.id_akses_kuesioner' => $_POST['id_akses_kuesioner']])->row_array();
        if ($cek_pilih_jawaban) {
            // $jawaban_type=$_POST['jawaban_type'];
            // if ($jawaban_type=='text') {
            //     $data = array(
            //         'jawaban'          => $_POST['jawaban'],
            //         'id_jawaban'          => $_POST['id_jawaban'],
            //     );
            // } else {
            //     $data = array(
            //         'id_jawaban'          => $_POST['id_jawaban'],
            //     );
            // }
            $data = array(
                'jawaban'          => $_POST['jawaban'],
                'id_jawaban'          => $_POST['id_jawaban'],
            );



            $this->Kuesioner_model->update_pilih_jawaban($data, $_POST['id_akses_kuesioner'], $_POST['id_pertanyaan']);
        } else {
            $data = array(
                'id_akses_kuesioner'            => $_POST['id_akses_kuesioner'],
                'id_kuesioner'            => $_POST['id_kuesioner'],
                'id_pertanyaan'        => $_POST['id_pertanyaan'],
                'id_jawaban'          => $_POST['id_jawaban'],
                'id_pasien'          => $_POST['id_pasien'],
                'id_user'          => $_POST['id_user'],
            );

            $this->Kuesioner_model->simpan_pilih_jawaban($data);
        }


        echo json_encode($data);
    }

    public function selesaiAksesKuesioner()
    {
        $data = array(
            'status'            => 'selesai',
        );

        $this->Kuesioner_model->ubah_status_akses_kuesioner($data, $_POST['id']);
    }
}
