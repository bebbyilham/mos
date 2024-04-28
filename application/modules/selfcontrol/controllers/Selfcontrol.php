<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Selfcontrol extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Pasien_model');
        $this->load->model('Edukasi_model');
        $this->load->model('Pernyataantarget_model');
        $this->load->model('Selfcontrol_model');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'pernyataantarget/index';

        echo modules::run('template/loadview', $data, $page);
    }

    public function pencegahanKejang()
    {
        $data['title'] = 'Perilaku Pencegahan Kejang';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'selfcontrol/pencegahan_kejang';
        echo modules::run('template/loadview', $data, $page);
    }

    public function getAllSelfcontrols()
    {
        $data = $this->Selfcontrol_model->fetch_all_selfcontrol();
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

    public function simpanAksesSelfcontrol()
    {
        $data = array(
            'id_selfcontrol'          => $_POST['metode'],
            'id_user'                       => $_POST['id_user'],
            'id_pasien'                     => $_POST['id_pasien'],
            'status'                        => 'aktif',
        );

        $this->Selfcontrol_model->simpan_akses_selfcontrol($data);
        echo json_encode($data);
    }

    public function tabelSelfcontrol()
    {
        $fetch_data = $this->Selfcontrol_model->make_datatables_akses_selfcontrol();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {


            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            if ($row->status == 'selesai') {
                $akses = '';
            } else {
                $akses = '<a href="#" class="fa fa-pen-square fa-lg ml-2 mr-2 text-primary akses_selfcontrol" id="' . $row->id . '" data-toggle="modal" data-target="#staticBackdrop" title="akses"></a>';
                // $akses = '';
            }

            $sub_array[] = $akses;
            $sub_array[] = "<b>" . $row->metode . "</b>";
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
            "recordsTotal"        => $this->Selfcontrol_model->get_all_data_akses_selfcontrol(),
            "recordsFiltered"     => $this->Selfcontrol_model->get_filtered_data_akses_selfcontrol(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function aksesselfcontrol($id)
    {
        $data['title'] = 'Self Control';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();
        $data['id_akses_selfcontrol'] = $id;

        $query_akses_target = $this->db->select('*')->get_where('akses_selfcontrol', ['id' => $id])->row_array();
        $id_selfcontrol = $query_akses_target['id_selfcontrol'];
        $data['idk'] = $id_selfcontrol;
        $data['idakses'] = $id;

        $data['data_materi'] =
            $this->db->select('
                            self_control.metode,
                            list_selfcontrol.link
                            ')
            ->join('list_selfcontrol', 'list_selfcontrol.id_selfcontrol = self_control.id', 'LEFT')
            ->get_where('self_control', ['self_control.id' => $id_selfcontrol])->result_array();

        $data['content'] = '';
        $page = 'selfcontrol/akses_selfcontrol';
        echo modules::run('template/loadview', $data, $page);
    }

    public function ubahStatusAksesSelcontrol()
    {
        $data = array(
            'status'            => $_POST['status'],
        );

        $this->Selfcontrol_model->ubah_status_akses_selfcontrol($data, $_POST['id']);
    }

    public function data_selfcontrol()
    {
        $id_selfcontrol = $_POST['id_selfcontrol'];
        $cek_selfcontrol = $this->db->select('
                            self_control.id AS id_self_control,
                            self_control.metode,
                            list_selfcontrol.link,
                            list_selfcontrol.id AS id_list_selfcontrol,

                            ')
            ->join('list_selfcontrol', 'list_selfcontrol.id_selfcontrol = self_control.id', 'LEFT')
            ->get_where('self_control', ['self_control.id' => $id_selfcontrol])->result_array();

        if ($cek_selfcontrol) {

            echo json_encode([
                'metadata' => [
                    'result' => [
                        'datamateri' => $cek_selfcontrol,
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
        $id_selfcontrol = $_POST['id_selfcontrol'];
        $cek_pertanyaan_edukasi = $this->db->select('
                            pertanyaan_konten_edukasi.id,
                            pertanyaan_konten_edukasi.id_selfcontrol,
                            pertanyaan_konten_edukasi.jenis,
                            pertanyaan_konten_edukasi.pertanyaan,
                            pertanyaan_konten_edukasi.keterangan,
                            pertanyaan_konten_edukasi.urutan,
                            pertanyaan_konten_edukasi.status,

                            ')
            // ->join('list_konten_edukasi', 'list_konten_edukasi.id_edukasi = konten_edukasi.id', 'LEFT')
            // ->join('pertanyaan_konten_edukasi', 'pertanyaan_konten_edukasi.id_selfcontrol = list_konten_edukasi.id', 'LEFT')
            // ->join('jawaban_konten_edukasi', 'jawaban_konten_edukasi.id_pertanyaan = pertanyaan_konten_edukasi.id', 'LEFT')
            ->get_where('pertanyaan_konten_edukasi', ['pertanyaan_konten_edukasi.id' => $id_selfcontrol])->result_array();

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
            ->get_where('pilih_jawaban_selfcontrol', ['pilih_jawaban_selfcontrol.id_pertanyaan' => $_POST['id_pertanyaan'], 'pilih_jawaban_selfcontrol.id_akses_selfcontrol' => $_POST['id_akses_selfcontrol']])->row_array();
        if ($cek_pilih_jawaban) {
            $data = array(
                'id_jawaban'          => $_POST['id_jawaban'],

            );

            $this->Selfcontrol_model->update_pilih_jawaban($data, $_POST['id_akses_selfcontrol'], $_POST['id_pertanyaan']);
        } else {
            $data = array(
                'id_akses_selfcontrol'            => $_POST['id_akses_selfcontrol'],
                'id_selfcontrol'            => $_POST['id_selfcontrol'],
                'id_pertanyaan'        => $_POST['id_pertanyaan'],
                'id_jawaban'          => $_POST['id_jawaban'],
                'id_pasien'          => $_POST['id_pasien'],
                'id_user'          => $_POST['id_user'],
            );

            $this->Selfcontrol_model->simpan_pilih_jawaban($data);
        }


        echo json_encode($data);
    }

    public function selesaiAksesSelfcontrol()
    {
        $data = array(
            'status'            => 'selesai',
        );

        $this->Selfcontrol_model->ubah_status_akses_selfcontrol($data, $_POST['id']);
    }
}
