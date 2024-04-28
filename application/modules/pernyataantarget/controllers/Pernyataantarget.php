<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pernyataantarget extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();

        $this->load->model('Pasien_model');
        $this->load->model('Edukasi_model');
        $this->load->model('Pernyataantarget_model');
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

    public function targetAktivitas()
    {
        $data['title'] = 'Target Aktivitas';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'pernyataantarget/target_aktivitas';
        echo modules::run('template/loadview', $data, $page);
    }

    public function getAlltargets()
    {
        $data = $this->Pernyataantarget_model->fetch_all_targets();
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

    public function simpanAksesTarget()
    {
        $data = array(
            'id_pernyataan_target'          => $_POST['target'],
            'id_user'                       => $_POST['id_user'],
            'id_pasien'                     => $_POST['id_pasien'],
            'status'                        => 'aktif',
        );

        $this->Pernyataantarget_model->simpan_akses_taget($data);
        echo json_encode($data);
    }

    public function tabelPernyataanTarget()
    {
        $fetch_data = $this->Pernyataantarget_model->make_datatables_akses_target();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {


            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            if ($row->status == 'selesai') {
                $akses = '';
            } else {
                // $akses = '<a href="#" class="fa fa-pen-square fa-lg ml-2 mr-2 text-primary akses_target" id="' . $row->id . '" data-toggle="modal" data-target="#staticBackdrop" title="akses"></a>';
                $akses = '';
            }

            $sub_array[] = $akses;
            $sub_array[] = "<b>" . $row->target . "</b>";
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
            "recordsTotal"        => $this->Pernyataantarget_model->get_all_data_akses_target(),
            "recordsFiltered"     => $this->Pernyataantarget_model->get_filtered_data_akses_target(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function aksestarget($id)
    {
        $data['title'] = 'Target';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();
        $data['id_akses_target'] = $id;

        $query_akses_target = $this->db->select('*')->get_where('akses_target', ['id' => $id])->row_array();
        $id_pernyataan_target = $query_akses_target['id_pernyataan_target'];
        $data['idk'] = $id_pernyataan_target;
        $data['idakses'] = $id;

        $data['data_materi'] =
            $this->db->select('
                            pernyataan_target.target,
                            list_pernyataan_target.link
                            ')
            ->join('list_pernyataan_target', 'list_pernyataan_target.id_target = pernyataan_target.id', 'LEFT')
            ->get_where('pernyataan_target', ['pernyataan_target.id' => $id_pernyataan_target])->result_array();

        $data['content'] = '';
        $page = 'pernyataantarget/akses_target';
        echo modules::run('template/loadview', $data, $page);
    }

    public function ubahStatusAksesMateri()
    {
        $data = array(
            'status'            => $_POST['status'],
        );

        $this->Pernyataantarget_model->ubah_status_akses_target($data, $_POST['id']);
    }
}
