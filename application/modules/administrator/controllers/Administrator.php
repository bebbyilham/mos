<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Administrator extends MX_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
        $this->load->model('Admin_model');
        $this->load->model('Creator_model');
        $this->load->model('Edukasi_model');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'administrator/index';
        // echo modules::run('template/loadview', $data);
        echo modules::run('template/loadview', $data, $page);
    }

    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['role'] = $this->db->get_where('user_role', ['id' => $role_id])
            ->row_array();

        // $this->db->where('id !=', 2);
        $data['menu'] = $this->db->order_by('deskripsi', 'ASC')->get('user_menu')->result_array();

        $data['content'] = '';
        $page = 'administrator/role_access';
        echo modules::run('template/loadview', $data, $page);
    }

    public function changeAccess()
    {
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');

        $data = [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ];

        $result = $this->db->get_where('user_access_menu', $data);

        if ($result->num_rows() < 1) {
            $this->db->insert('user_access_menu', $data);
        } else {
            $this->db->delete('user_access_menu', $data);
        }

        echo 'Role Akses Berhasil Diubah';
    }


    // ------------------------------------------------------------- ROLE
    public function role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'administrator/role';
        echo modules::run('template/loadview', $data, $page);
    }

    public function tabelRole()
    {
        $fetch_data = $this->Admin_model->make_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->role;
            $sub_array[] = '<a href="#" class="edit" id="' . $row->id . '" data-toggle="modal" title="Akses"> <i class="fa fa-edit mr-2"></i> </a>
                            <a href="#" class="delete" id="' . $row->id . '" data-toggle="modal" title="Hapus"> <i class="fa fa-trash text-danger mr-2"></i> </a>
                            <a href="#" class="access" id="' . $row->id . '" data-toggle="modal" title="Role Access"> <i class="fa fa-user-cog text-dark"></i> </a>
                            ';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function tambahRole()
    {
        if ($_POST['action'] == 'tambah') {
            $data = array(
                'role'    => $this->input->post('role')
            );

            $this->Admin_model->tambah_role($data);
            echo 'Data Role berhasil disimpan!';
        }

        if ($_POST['action'] == 'edit') {
            $data = array(
                'role'    => $this->input->post('role')
            );

            $this->Admin_model->edit_role($this->input->post('id_role'), $data);
            echo 'Data Role berhasil diedit!';
        }
    }

    public function editRole()
    {
        $output = array();
        $data = $this->Admin_model->fetch_single_role($_POST['id']);

        foreach ($data as $row) {
            $output['role'] = $row->role;
        }
        echo json_encode($output);
    }

    public function deleteRole()
    {
        $this->Admin_model->delete_role($_POST['id']);
        echo "Role berhasil dihapus!";
    }
    // ------------------------------------------------------------- END ROLE





    // ------------------------------------------------------------- MENU
    public function menu()
    {
        $data['title'] = 'Menu';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'administrator/menu';
        echo modules::run('template/loadview', $data, $page);
    }

    public function tabelMenu()
    {
        $fetch_data = $this->Admin_model->make_datatables_menu();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->menu;
            $sub_array[] = $row->deskripsi;
            $sub_array[] = '<a href="#" class="edit" id="' . $row->id . '" data-toggle="tooltip" title="Akses"> <i class="fa fa-edit mr-2"></i> </a>
                            <a href="#" class="delete" id="' . $row->id . '" data-toggle="tooltip" title="Hapus"> <i class="fa fa-trash text-danger"></i> </a>';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_menu(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_menu(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function tambahMenu()
    {
        if ($_POST['action'] == 'tambah') {
            $data = array(
                'menu'    => $this->input->post('menu'),
                'deskripsi'    => $this->input->post('deskripsi'),
            );

            $this->Admin_model->tambah_menu($data);
            echo 'Data Menu berhasil disimpan!';
        }

        if ($_POST['action'] == 'edit') {
            $data = array(
                'menu'    => $this->input->post('menu'),
                'deskripsi'    => $this->input->post('deskripsi'),
            );

            $this->Admin_model->edit_menu($this->input->post('id_menu'), $data);
            echo 'Data Menu berhasil diedit!';
        }
    }

    public function editMenu()
    {
        $output = array();
        $data = $this->Admin_model->fetch_single_menu($_POST['id']);

        foreach ($data as $row) {
            $output['menu'] = $row->menu;
            $output['deskripsi'] = $row->deskripsi;
        }
        echo json_encode($output);
    }

    public function deleteMenu()
    {
        $this->Admin_model->delete_menu($_POST['id']);
        echo "Menu berhasil dihapus!";
    }
    // ------------------------------------------------------------- END MENU








    // ------------------------------------------------------------- SUBMENU
    public function submenu()
    {
        $data['title'] = 'Sub Menu';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();
        $data['menu'] = $this->db->order_by('deskripsi', 'ASC')->get('user_menu')->result_array();

        $data['content'] = '';
        $page = 'administrator/submenu';
        echo modules::run('template/loadview', $data, $page);
    }

    public function tabelSubmenu()
    {
        $fetch_data = $this->Admin_model->make_datatables_submenu();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->title;
            $sub_array[] = $row->deskripsi;
            $sub_array[] = $row->url;
            $sub_array[] = $row->icon;
            $sub_array[] = $row->is_active;
            $sub_array[] = '<a href="#" class="edit" id="' . $row->id . '" data-toggle="tooltip" title="Akses"> <i class="fa fa-edit mr-2"></i> </a>
                            <a href="#" class="delete" id="' . $row->id . '" data-toggle="tooltip" title="Hapus"> <i class="fa fa-trash text-danger"></i> </a>';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_submenu(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_submenu(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function tambahSubmenu()
    {
        if ($_POST['action'] == 'tambah') {
            $data = array(
                'menu_id'   => $this->input->post('menu_id'),
                'title'     => $this->input->post('title'),
                'url'       => $this->input->post('url'),
                'icon'      => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            );

            $this->Admin_model->tambah_submenu($data);
            echo 'Data Sub Menu berhasil disimpan!';
        }

        if ($_POST['action'] == 'edit') {
            $data = array(
                'menu_id'   => $this->input->post('menu_id'),
                'title'     => $this->input->post('title'),
                'url'       => $this->input->post('url'),
                'icon'      => $this->input->post('icon'),
                'is_active' => $this->input->post('is_active')
            );

            $this->Admin_model->edit_submenu($this->input->post('id_submenu'), $data);
            echo 'Data Sub Menu berhasil diedit!';
        }
    }

    public function editSubmenu()
    {
        $output = array();
        $data = $this->Admin_model->fetch_single_submenu($_POST['id']);

        foreach ($data as $row) {
            $output['menu_id'] = $row->menu_id;
            $output['title'] = $row->title;
            $output['url'] = $row->url;
            $output['icon'] = $row->icon;
            $output['is_active'] = $row->is_active;
        }
        echo json_encode($output);
    }

    public function deleteSubmenu()
    {
        $this->Admin_model->delete_submenu($_POST['id']);
        echo "Menu berhasil dihapus!";
    }
    // ------------------------------------------------------------- END SUBMENU








    // ------------------------------------------------------------- REFERENSI
    public function referensi()
    {
        $data['title'] = 'Referensi';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'administrator/referensi';
        echo modules::run('template/loadview', $data, $page);
    }

    // TANDA PENGENAL
    public function tabelPengenal()
    {
        $fetch_data = $this->Admin_model->make_datatables_pengenal();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->pengenal;
            if ($row->status_pengenal == 1) {
                $sub_array[] = '<span class="badge badge-success">Aktif</span>';
            } else {
                $sub_array[] = '<span class="badge badge-danger">Non Aktif</span>';
            }
            $sub_array[] = '<a href="#" class="edit_pengenal" id="' . $row->id_pengenal . '" data-toggle="tooltip" title="Akses"> <i class="fa fa-edit mr-2"></i> </a>';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_pengenal(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_pengenal(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function tambahPengenal()
    {
        if ($_POST['action'] == 'tambah') {
            $data = array(
                'pengenal'          => $this->input->post('pengenal'),
                'status_pengenal'   => $this->input->post('status_pengenal')
            );

            $this->Admin_model->tambah_pengenal($data);
            echo 'Pengenal berhasil disimpan!';
        }

        if ($_POST['action'] == 'edit') {
            $data = array(
                'pengenal'          => $this->input->post('pengenal'),
                'status_pengenal'   => $this->input->post('status_pengenal')
            );

            $this->Admin_model->edit_pengenal($this->input->post('id_tanda_pengenal'), $data);
            echo 'Pengenal berhasil diedit!';
        }
    }

    public function editPengenal()
    {
        $output = array();
        $data = $this->Admin_model->fetch_single_pengenal($_POST['id']);

        foreach ($data as $row) {
            $output['pengenal'] = $row->pengenal;
            $output['status_pengenal'] = $row->status_pengenal;
        }
        echo json_encode($output);
    }



    // AGAMA
    public function tabelAgama()
    {
        $fetch_data = $this->Admin_model->make_datatables_agama();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->ket_agama;
            if ($row->status_agama == 1) {
                $sub_array[] = '<span class="badge badge-success">Aktif</span>';
            } else {
                $sub_array[] = '<span class="badge badge-danger">Non Aktif</span>';
            }
            $sub_array[] = '<a href="#" class="edit_agama" id="' . $row->id_agama . '" data-toggle="tooltip" title="Akses"> <i class="fa fa-edit mr-2"></i> </a>';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_agama(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_agama(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function tambahAgama()
    {
        if ($_POST['action1'] == 'tambah') {
            $data = array(
                'ket_agama'      => $this->input->post('ket_agama'),
                'status_agama'   => $this->input->post('status_agama')
            );

            $this->Admin_model->tambah_agama($data);
            echo 'Agama berhasil disimpan!';
        }

        if ($_POST['action1'] == 'edit') {
            $data = array(
                'ket_agama'          => $this->input->post('ket_agama'),
                'status_agama'   => $this->input->post('status_agama')
            );

            $this->Admin_model->edit_agama($this->input->post('id_agama'), $data);
            echo 'Agama berhasil diedit!';
        }
    }

    public function editAgama()
    {
        $output = array();
        $data = $this->Admin_model->fetch_single_agama($_POST['id']);

        foreach ($data as $row) {
            $output['ket_agama'] = $row->ket_agama;
            $output['status_agama'] = $row->status_agama;
        }
        echo json_encode($output);
    }





    // WARGA NEGARA
    public function tabelWarganegara()
    {
        $fetch_data = $this->Admin_model->make_datatables_warganegara();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->ket_warganegara;
            if ($row->status_warganegara == 1) {
                $sub_array[] = '<span class="badge badge-success">Aktif</span>';
            } else {
                $sub_array[] = '<span class="badge badge-danger">Non Aktif</span>';
            }
            $sub_array[] = '<a href="#" class="edit_warganegara" id="' . $row->id_warganegara . '" data-toggle="tooltip" title="Akses"> <i class="fa fa-edit mr-2"></i> </a>';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_warganegara(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_warganegara(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function tambahWarganegara()
    {
        if ($_POST['action2'] == 'tambah') {
            $data = array(
                'ket_warganegara'      => $this->input->post('ket_warganegara'),
                'status_warganegara'   => $this->input->post('status_warganegara')
            );

            $this->Admin_model->tambah_warganegara($data);
            echo 'Warga Negara berhasil disimpan!';
        }

        if ($_POST['action2'] == 'edit') {
            $data = array(
                'ket_warganegara'      => $this->input->post('ket_warganegara'),
                'status_warganegara'   => $this->input->post('status_warganegara')
            );

            $this->Admin_model->edit_warganegara($this->input->post('id_warganegara'), $data);
            echo 'Warga Negara berhasil diedit!';
        }
    }

    public function editWarganegara()
    {
        $output = array();
        $data = $this->Admin_model->fetch_single_warganegara($_POST['id']);

        foreach ($data as $row) {
            $output['ket_warganegara'] = $row->ket_warganegara;
            $output['status_warganegara'] = $row->status_warganegara;
        }
        echo json_encode($output);
    }





    // SUKU BANGSA
    public function tabelSukubangsa()
    {
        $fetch_data = $this->Admin_model->make_datatables_sukubangsa();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->ket_sukubangsa;
            if ($row->status_sukubangsa == 1) {
                $sub_array[] = '<span class="badge badge-success">Aktif</span>';
            } else {
                $sub_array[] = '<span class="badge badge-danger">Non Aktif</span>';
            }
            $sub_array[] = '<a href="#" class="edit_sukubangsa" id="' . $row->id_sukubangsa . '" data-toggle="tooltip" title="Akses"> <i class="fa fa-edit mr-2"></i> </a>';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_sukubangsa(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_sukubangsa(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function tambahSukubangsa()
    {
        if ($_POST['action3'] == 'tambah') {
            $data = array(
                'ket_sukubangsa'      => $this->input->post('ket_sukubangsa'),
                'status_sukubangsa'   => $this->input->post('status_sukubangsa')
            );

            $this->Admin_model->tambah_sukubangsa($data);
            echo 'Warga Negara berhasil disimpan!';
        }

        if ($_POST['action3'] == 'edit') {
            $data = array(
                'ket_sukubangsa'      => $this->input->post('ket_sukubangsa'),
                'status_sukubangsa'   => $this->input->post('status_sukubangsa')
            );

            $this->Admin_model->edit_sukubangsa($this->input->post('id_sukubangsa'), $data);
            echo 'Warga Negara berhasil diedit!';
        }
    }

    public function editSukubangsa()
    {
        $output = array();
        $data = $this->Admin_model->fetch_single_sukubangsa($_POST['id']);

        foreach ($data as $row) {
            $output['ket_sukubangsa'] = $row->ket_sukubangsa;
            $output['status_sukubangsa'] = $row->status_sukubangsa;
        }
        echo json_encode($output);
    }


    // STATUS NIKAH
    public function tabelStatusnikah()
    {
        $fetch_data = $this->Admin_model->make_datatables_statusnikah();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->ket_statusnikah;
            if ($row->status_statusnikah == 1) {
                $sub_array[] = '<span class="badge badge-success">Aktif</span>';
            } else {
                $sub_array[] = '<span class="badge badge-danger">Non Aktif</span>';
            }
            $sub_array[] = '<a href="#" class="edit_statusnikah" id="' . $row->id_statusnikah . '" data-toggle="tooltip" title="Akses"> <i class="fa fa-edit mr-2"></i> </a>';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_statusnikah(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_statusnikah(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function tambahStatusnikah()
    {
        if ($_POST['action4'] == 'tambah') {
            $data = array(
                'ket_statusnikah'      => $this->input->post('ket_statusnikah'),
                'status_statusnikah'   => $this->input->post('status_statusnikah')
            );

            $this->Admin_model->tambah_statusnikah($data);
            echo 'Status Nikah berhasil disimpan!';
        }

        if ($_POST['action4'] == 'edit') {
            $data = array(
                'ket_statusnikah'      => $this->input->post('ket_statusnikah'),
                'status_statusnikah'   => $this->input->post('status_statusnikah')
            );

            $this->Admin_model->edit_statusnikah($this->input->post('id_statusnikah'), $data);
            echo 'Status Nikah berhasil diedit!';
        }
    }

    public function editStatusnikah()
    {
        $output = array();
        $data = $this->Admin_model->fetch_single_statusnikah($_POST['id']);

        foreach ($data as $row) {
            $output['ket_statusnikah'] = $row->ket_statusnikah;
            $output['status_statusnikah'] = $row->status_statusnikah;
        }
        echo json_encode($output);
    }



    // PENDIDIKAN
    public function tabelPendidikan()
    {
        $fetch_data = $this->Admin_model->make_datatables_pendidikan();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->ket_pendidikan;
            if ($row->status_pendidikan == 1) {
                $sub_array[] = '<span class="badge badge-success">Aktif</span>';
            } else {
                $sub_array[] = '<span class="badge badge-danger">Non Aktif</span>';
            }
            $sub_array[] = '<a href="#" class="edit_pendidikan" id="' . $row->id_pendidikan . '" data-toggle="tooltip" title="Akses"> <i class="fa fa-edit mr-2"></i> </a>';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_pendidikan(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_pendidikan(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function tambahPendidikan()
    {
        if ($_POST['action5'] == 'tambah') {
            $data = array(
                'ket_pendidikan'      => $this->input->post('ket_pendidikan'),
                'status_pendidikan'   => $this->input->post('status_pendidikan')
            );

            $this->Admin_model->tambah_pendidikan($data);
            echo 'Pendidikan berhasil disimpan!';
        }

        if ($_POST['action5'] == 'edit') {
            $data = array(
                'ket_pendidikan'      => $this->input->post('ket_pendidikan'),
                'status_pendidikan'   => $this->input->post('status_pendidikan')
            );

            $this->Admin_model->edit_pendidikan($this->input->post('id_pendidikan'), $data);
            echo 'Pendidikan berhasil diedit!';
        }
    }

    public function editPendidikan()
    {
        $output = array();
        $data = $this->Admin_model->fetch_single_pendidikan($_POST['id']);

        foreach ($data as $row) {
            $output['ket_pendidikan'] = $row->ket_pendidikan;
            $output['status_pendidikan'] = $row->status_pendidikan;
        }
        echo json_encode($output);
    }



    // PEKERJAAN
    public function tabelPekerjaan()
    {
        $fetch_data = $this->Admin_model->make_datatables_pekerjaan();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->ket_pekerjaan;
            if ($row->status_pekerjaan == 1) {
                $sub_array[] = '<span class="badge badge-success">Aktif</span>';
            } else {
                $sub_array[] = '<span class="badge badge-danger">Non Aktif</span>';
            }
            $sub_array[] = '<a href="#" class="edit_pekerjaan" id="' . $row->id_pekerjaan . '" data-toggle="tooltip" title="Akses"> <i class="fa fa-edit mr-2"></i> </a>';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_pekerjaan(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_pekerjaan(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function tambahPekerjaan()
    {
        if ($_POST['action6'] == 'tambah') {
            $data = array(
                'ket_pekerjaan'      => $this->input->post('ket_pekerjaan'),
                'status_pekerjaan'   => $this->input->post('status_pekerjaan')
            );

            $this->Admin_model->tambah_pekerjaan($data);
            echo 'Pekerjaan berhasil disimpan!';
        }

        if ($_POST['action6'] == 'edit') {
            $data = array(
                'ket_pekerjaan'      => $this->input->post('ket_pekerjaan'),
                'status_pekerjaan'   => $this->input->post('status_pekerjaan')
            );

            $this->Admin_model->edit_pekerjaan($this->input->post('id_pekerjaan'), $data);
            echo 'Pekerjaan berhasil diedit!';
        }
    }

    public function editPekerjaan()
    {
        $output = array();
        $data = $this->Admin_model->fetch_single_pekerjaan($_POST['id']);

        foreach ($data as $row) {
            $output['ket_pekerjaan'] = $row->ket_pekerjaan;
            $output['status_pekerjaan'] = $row->status_pekerjaan;
        }
        echo json_encode($output);
    }



    // HUBUNGAN
    public function tabelHubungan()
    {
        $fetch_data = $this->Admin_model->make_datatables_hubungan();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->ket_hubungan;
            if ($row->status_hubungan == 1) {
                $sub_array[] = '<span class="badge badge-success">Aktif</span>';
            } else {
                $sub_array[] = '<span class="badge badge-danger">Non Aktif</span>';
            }
            $sub_array[] = '<a href="#" class="edit_hubungan" id="' . $row->id_hubungan . '" data-toggle="tooltip" title="Akses"> <i class="fa fa-edit mr-2"></i> </a>';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_hubungan(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_hubungan(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function tambahHubungan()
    {
        if ($_POST['action7'] == 'tambah') {
            $data = array(
                'ket_hubungan'      => $this->input->post('ket_hubungan'),
                'status_hubungan'   => $this->input->post('status_hubungan')
            );

            $this->Admin_model->tambah_hubungan($data);
            echo 'Ket Hubungan berhasil disimpan!';
        }

        if ($_POST['action7'] == 'edit') {
            $data = array(
                'ket_hubungan'      => $this->input->post('ket_hubungan'),
                'status_hubungan'   => $this->input->post('status_hubungan')
            );

            $this->Admin_model->edit_hubungan($this->input->post('id_hubungan'), $data);
            echo 'Ket Hubungan berhasil diedit!';
        }
    }

    public function editHubungan()
    {
        $output = array();
        $data = $this->Admin_model->fetch_single_hubungan($_POST['id']);

        foreach ($data as $row) {
            $output['ket_hubungan'] = $row->ket_hubungan;
            $output['status_hubungan'] = $row->status_hubungan;
        }
        echo json_encode($output);
    }

    // PROFESI
    public function tabelProfesi()
    {
        $fetch_data = $this->Admin_model->make_datatables_profesi();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->ket_profesi;
            if ($row->status_profesi == 1) {
                $sub_array[] = '<span class="badge badge-success">Aktif</span>';
            } else {
                $sub_array[] = '<span class="badge badge-danger">Non Aktif</span>';
            }
            $sub_array[] = '<a href="#" class="edit_profesi" id="' . $row->id_profesi . '" data-toggle="tooltip" title="Akses"> <i class="fa fa-edit mr-2"></i> </a>';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_profesi(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_profesi(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function tambahProfesi()
    {
        if ($_POST['action8'] == 'tambah') {
            $data = array(
                'ket_profesi'       => $this->input->post('ket_profesi'),
                'status_profesi'    => $this->input->post('status_profesi')
            );

            $this->Admin_model->tambah_profesi($data);
            echo 'Data Profesi berhasil disimpan!';
        }

        if ($_POST['action8'] == 'edit') {
            $data = array(
                'ket_profesi'       => $this->input->post('ket_profesi'),
                'status_profesi'    => $this->input->post('status_profesi')
            );

            $this->Admin_model->edit_profesi($this->input->post('id_profesi'), $data);
            echo 'Data Profesi berhasil diedit!';
        }
    }

    public function editProfesi()
    {
        $output = array();
        $data = $this->Admin_model->fetch_single_profesi($_POST['id']);

        foreach ($data as $row) {
            $output['ket_profesi'] = $row->ket_profesi;
            $output['status_profesi'] = $row->status_profesi;
        }
        echo json_encode($output);
    }

    // WISMA
    public function tabelWisma()
    {
        $fetch_data = $this->Admin_model->make_datatables_wisma();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->nama_wisma;
            if ($row->status_wisma == 1) {
                $sub_array[] = '<span class="badge badge-success">Aktif</span>';
            } else {
                $sub_array[] = '<span class="badge badge-danger">Non Aktif</span>';
            }
            $sub_array[] = '<a href="#" class="edit_wisma" id="' . $row->id_wisma . '" data-toggle="tooltip" title="Akses"> <i class="fa fa-edit mr-2"></i> </a>';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_wisma(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_wisma(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function tambahWisma()
    {
        if ($_POST['action9'] == 'tambah') {
            $data = array(
                'nama_wisma'       => $this->input->post('nama_wisma'),
                'status_wisma'     => $this->input->post('status_wisma')
            );

            $this->Admin_model->tambah_wisma($data);
            echo 'Data Wisma berhasil disimpan!';
        }

        if ($_POST['action9'] == 'edit') {
            $data = array(
                'nama_wisma'       => $this->input->post('nama_wisma'),
                'status_wisma'     => $this->input->post('status_wisma')
            );

            $this->Admin_model->edit_wisma($this->input->post('id_wisma'), $data);
            echo 'Data Wisma berhasil diedit!';
        }
    }

    public function editWisma()
    {
        $output = array();
        $data = $this->Admin_model->fetch_single_wisma($_POST['id']);

        foreach ($data as $row) {
            $output['nama_wisma'] = $row->nama_wisma;
            $output['status_wisma'] = $row->status_wisma;
        }
        echo json_encode($output);
    }

    // KELAS RAWATAN
    public function tabelKelas()
    {
        $fetch_data = $this->Admin_model->make_datatables_kelas();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->nama_kelas;
            $sub_array[] = $row->kode_kelas;
            if ($row->status_kelas == 1) {
                $sub_array[] = '<span class="badge badge-success">Aktif</span>';
            } else {
                $sub_array[] = '<span class="badge badge-danger">Non Aktif</span>';
            }
            $sub_array[] = '<a href="#" class="edit_kelas" id="' . $row->id_kelas . '" data-toggle="tooltip" title="Akses"> <i class="fa fa-edit mr-2"></i> </a>';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_kelas(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_kelas(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function tambahKelas()
    {
        if ($_POST['action10'] == 'tambah') {
            $data = array(
                'nama_kelas'       => $this->input->post('nama_kelas'),
                'kode_kelas'       => $this->input->post('kode_kelas'),
                'status_kelas'     => $this->input->post('status_kelas')
            );

            $this->Admin_model->tambah_kelas($data);
            echo 'Data Kelas berhasil disimpan!';
        }

        if ($_POST['action10'] == 'edit') {
            $data = array(
                'nama_kelas'       => $this->input->post('nama_kelas'),
                'kode_kelas'       => $this->input->post('kode_kelas'),
                'status_kelas'     => $this->input->post('status_kelas')
            );

            $this->Admin_model->edit_kelas($this->input->post('id_kelas'), $data);
            echo 'Data Kelas berhasil diedit!';
        }
    }

    public function editKelas()
    {
        $output = array();
        $data = $this->Admin_model->fetch_single_kelas($_POST['id']);

        foreach ($data as $row) {
            $output['nama_kelas'] = $row->nama_kelas;
            $output['kode_kelas'] = $row->kode_kelas;
            $output['status_kelas'] = $row->status_kelas;
        }
        echo json_encode($output);
    }

    // PENJAMIN
    public function tabelPenjamin()
    {
        $fetch_data = $this->Admin_model->make_datatables_penjamin();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->nama_penjamin;
            $sub_array[] = $row->kode_penjamin;
            if ($row->status_penjamin == 1) {
                $sub_array[] = '<span class="badge badge-success">Aktif</span>';
            } else {
                $sub_array[] = '<span class="badge badge-danger">Non Aktif</span>';
            }
            $sub_array[] = '<a href="#" class="edit_penjamin" id="' . $row->id_penjamin . '" data-toggle="tooltip" title="Akses"> <i class="fa fa-edit mr-2"></i> </a>';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_penjamin(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_penjamin(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function tambahPenjamin()
    {
        if ($_POST['action11'] == 'tambah') {
            $data = array(
                'nama_penjamin'       => $this->input->post('nama_penjamin'),
                'kode_penjamin'       => $this->input->post('kode_penjamin'),
                'status_penjamin'     => $this->input->post('status_penjamin')
            );

            $this->Admin_model->tambah_penjamin($data);
            echo 'Data Kelas berhasil disimpan!';
        }

        if ($_POST['action11'] == 'edit') {
            $data = array(
                'nama_penjamin'       => $this->input->post('nama_penjamin'),
                'kode_penjamin'       => $this->input->post('kode_penjamin'),
                'status_penjamin'     => $this->input->post('status_penjamin')
            );

            $this->Admin_model->edit_penjamin($this->input->post('id_penjamin'), $data);
            echo 'Data Penjamin berhasil diedit!';
        }
    }

    public function editPenjamin()
    {
        $output = array();
        $data = $this->Admin_model->fetch_single_penjamin($_POST['id']);

        foreach ($data as $row) {
            $output['nama_penjamin'] = $row->nama_penjamin;
            $output['kode_penjamin'] = $row->kode_penjamin;
            $output['status_penjamin'] = $row->status_penjamin;
        }
        echo json_encode($output);
    }

    // SATUAN LABOR
    public function tabelSatuanLabor()
    {
        $fetch_data = $this->Admin_model->make_datatables_satuan_labor();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->nama_satuan_labor;
            if ($row->status_satuan_labor == 1) {
                $sub_array[] = '<span class="badge badge-success">Aktif</span>';
            } else {
                $sub_array[] = '<span class="badge badge-danger">Tidak Aktif</span>';
            }
            $sub_array[] = '<a href="#" class="edit_satuan_labor" id="' . $row->id_satuan_labor . '" data-toggle="tooltip" title="Akses"> <i class="fa fa-edit mr-2"></i> </a>';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_satuan_labor(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_satuan_labor(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function tambahSatuanLabor()
    {
        if ($_POST['action13'] == 'tambah') {
            $data = array(
                'nama_satuan_labor'       => $this->input->post('nama_satuan_labor'),
                'status_satuan_labor'     => $this->input->post('status_satuan_labor')
            );

            $this->Admin_model->tambah_satuan_labor($data);
            echo 'Data Satuan berhasil disimpan!';
        }

        if ($_POST['action13'] == 'edit') {
            $data = array(
                'nama_satuan_labor'       => $this->input->post('nama_satuan_labor'),
                'status_satuan_labor'     => $this->input->post('status_satuan_labor')
            );

            $this->Admin_model->edit_satuan_labor($this->input->post('id_satuan_labor'), $data);
            echo 'Data Satuan berhasil diedit!';
        }
    }

    public function editSatuanLabor()
    {
        $output = array();
        $data = $this->Admin_model->fetch_single_satuan_labor($_POST['id']);

        foreach ($data as $row) {
            $output['nama_satuan_labor'] = $row->nama_satuan_labor;
            $output['status_satuan_labor'] = $row->status_satuan_labor;
        }
        echo json_encode($output);
    }

    // GRUP TINDAKAN LABOR
    public function tabelGrupLabor()
    {
        $fetch_data = $this->Admin_model->make_datatables_grup_labor();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->nama_kategori_tindakan_labor;
            if ($row->status_kategori_tindakan_labor == 1) {
                $sub_array[] = '<span class="badge badge-success">Aktif</span>';
            } else {
                $sub_array[] = '<span class="badge badge-danger">Tidak Aktif</span>';
            }
            $sub_array[] = '<a href="#" class="edit_grup_labor" id="' . $row->id_kategori_tindakan_labor . '" data-toggle="tooltip" title="Akses"> <i class="fa fa-edit mr-2"></i> </a>';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_grup_labor(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_grup_labor(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function tambahGrupLabor()
    {
        if ($_POST['action14'] == 'tambah') {
            $data = array(
                'nama_kategori_tindakan_labor'       => $this->input->post('nama_kategori_tindakan_labor'),
                'status_kategori_tindakan_labor'     => $this->input->post('status_kategori_tindakan_labor')
            );

            $this->Admin_model->tambah_grup_labor($data);
            echo 'Data Satuan berhasil disimpan!';
        }

        if ($_POST['action14'] == 'edit') {
            $data = array(
                'nama_kategori_tindakan_labor'       => $this->input->post('nama_kategori_tindakan_labor'),
                'status_kategori_tindakan_labor'     => $this->input->post('status_kategori_tindakan_labor')
            );

            $this->Admin_model->edit_grup_labor($this->input->post('id_grup_labor'), $data);
            echo 'Data Satuan berhasil diedit!';
        }
    }

    public function editGrupLabor()
    {
        $output = array();
        $data = $this->Admin_model->fetch_single_grup_labor($_POST['id']);

        foreach ($data as $row) {
            $output['nama_kategori_tindakan_labor'] = $row->nama_kategori_tindakan_labor;
            $output['status_kategori_tindakan_labor'] = $row->status_kategori_tindakan_labor;
        }
        echo json_encode($output);
    }


    // BAHAN RADIOLOGI
    public function tabelBahanRadiologi()
    {
        $fetch_data = $this->Admin_model->make_datatables_bahan_radiologi();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->nama_bahan_radiologi;
            if ($row->status_bahan_radiologi == 1) {
                $sub_array[] = '<span class="badge badge-success">Aktif</span>';
            } else {
                $sub_array[] = '<span class="badge badge-danger">Tidak Aktif</span>';
            }
            $sub_array[] = '<a href="#" class="edit_bahan_radiologi" id="' . $row->id_bahan_radiologi . '" data-toggle="tooltip" title="Akses"> <i class="fa fa-edit mr-2"></i> </a>';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_bahan_radiologi(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_bahan_radiologi(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function tambahBahanRadiologi()
    {
        if ($_POST['action15'] == 'tambah') {
            $data = array(
                'nama_bahan_radiologi'       => $this->input->post('nama_bahan_radiologi'),
                'status_bahan_radiologi'     => $this->input->post('status_bahan_radiologi')
            );

            $this->Admin_model->tambah_bahan_radiologi($data);
            echo 'Data Satuan berhasil disimpan!';
        }

        if ($_POST['action15'] == 'edit') {
            $data = array(
                'nama_bahan_radiologi'       => $this->input->post('nama_bahan_radiologi'),
                'status_bahan_radiologi'     => $this->input->post('status_bahan_radiologi')
            );

            $this->Admin_model->edit_bahan_radiologi($this->input->post('id_bahan_radiologi'), $data);
            echo 'Data Satuan berhasil diedit!';
        }
    }

    public function editBahanRadiologi()
    {
        $output = array();
        $data = $this->Admin_model->fetch_single_bahan_radiologi($_POST['id']);

        foreach ($data as $row) {
            $output['nama_bahan_radiologi'] = $row->nama_bahan_radiologi;
            $output['status_bahan_radiologi'] = $row->status_bahan_radiologi;
        }
        echo json_encode($output);
    }


    // CARA KELUAR
    public function tabelCaraKeluar()
    {
        $fetch_data = $this->Admin_model->make_datatables_cara_keluar();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = $row->cara_keluar;
            if ($row->status_cara_keluar == 1) {
                $sub_array[] = '<span class="badge badge-success">Aktif</span>';
            } else {
                $sub_array[] = '<span class="badge badge-danger">Tidak Aktif</span>';
            }
            $sub_array[] = '<a href="#" class="edit_cara_keluar" id="' . $row->id_cara_keluar . '" data-toggle="tooltip" title="Edit"> <i class="fa fa-edit mr-2"></i> </a>';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_cara_keluar(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_cara_keluar(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function tambahCaraKeluar()
    {
        if ($_POST['action16'] == 'tambah') {
            $data = array(
                'cara_keluar'           => $this->input->post('cara_keluar'),
                'status_cara_keluar'    => $this->input->post('status_cara_keluar')
            );

            $this->Admin_model->tambah_cara_keluar($data);
            echo 'Data Cara Keluar berhasil disimpan!';
        }

        if ($_POST['action16'] == 'edit') {
            $data = array(
                'cara_keluar'           => $this->input->post('cara_keluar'),
                'status_cara_keluar'    => $this->input->post('status_cara_keluar')
            );

            $this->Admin_model->edit_cara_keluar($this->input->post('id_cara_keluar'), $data);
            echo 'Data Cara Keluar berhasil diedit!';
        }
    }

    public function editCaraKeluar()
    {
        $output = array();
        $data = $this->Admin_model->fetch_single_cara_keluar($_POST['id']);

        foreach ($data as $row) {
            $output['cara_keluar'] = $row->cara_keluar;
            $output['status_cara_keluar'] = $row->status_cara_keluar;
        }
        echo json_encode($output);
    }
    // ------------------------------------------------------------- END REFERENSI









    // ------------------------------------------------------------- PEGAWAI
    public function pegawai()
    {
        $data['title'] = 'Pegawai';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'administrator/pegawai';
        echo modules::run('template/loadview', $data, $page);
    }

    public function getProfesi()
    {
        $data = $this->db->get_where('referensi_profesi', ['status_profesi' => 1])->result();
        echo json_encode($data);
    }

    public function getRole()
    {
        $data = $this->db->select('*')
            ->from('user_role')
            ->where('id !=', '1')
            ->get()->result();
        echo json_encode($data);
    }

    public function tabelPegawai()
    {
        $fetch_data = $this->Admin_model->make_datatables_pegawai();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = '<div>' . $row->gelar_depan . ' ' . $row->nama_pegawai . ' ' . $row->gelar_belakang . '<br>
                            ' . $row->tempat_lahir . ' / ' . $row->tanggal_lahir . '<br>
                            NIP. ' . $row->nip . ' <br> 
                            NIK. ' . $row->nik . '
                            </div>';
            $sub_array[] = $row->ket_profesi;
            if ($row->status_pegawai == 1) {
                $sub_array[] = '<span class="badge badge-success">Aktif</span>';
            } else {
                $sub_array[] = '<span class="badge badge-danger">Non Aktif</span>';
            }
            $sub_array[] = '<a href="#" class="edit_pegawai" id="' . $row->id_pegawai . '" data-toggle="modal" title="Edit"> <i class="fa fa-edit mr-2"></i> </a>
                            <a href="#" class="create_user text-danger" id="' . $row->id_pegawai . '" data-toggle="modal" title="Create User"> <i class="fa fa-lock mr-2"></i> </a>
                            ';
            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_pegawai(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_pegawai(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function tambahPegawai()
    {
        if ($_POST['action'] == 'tambah') {
            $data = array(
                'nama_pegawai'      => $this->input->post('nama_pegawai'),
                'gelar_depan'       => $this->input->post('gelar_depan'),
                'gelar_belakang'    => $this->input->post('gelar_belakang'),
                'tempat_lahir'      => $this->input->post('tempat_lahir'),
                'tanggal_lahir'     => $this->input->post('tanggal_lahir'),
                'jenis_kelamin'     => $this->input->post('jenis_kelamin'),
                'profesi'           => $this->input->post('profesi'),
                'nip'               => $this->input->post('nip'),
                'nik'               => $this->input->post('nik'),
                'status_pegawai'    => $this->input->post('status_pegawai'),
                'ruangan'           => 0,
                'bidang'            => 0,
                'hp_pegawai'        => $this->input->post('nohp'),
                'poli'              => 0
            );

            $this->Admin_model->tambah_pegawai($data);
            echo 'Data Pegawai berhasil disimpan!';
        }

        if ($_POST['action'] == 'edit') {
            $data = array(
                'nama_pegawai'      => $this->input->post('nama_pegawai'),
                'gelar_depan'       => $this->input->post('gelar_depan'),
                'gelar_belakang'    => $this->input->post('gelar_belakang'),
                'tempat_lahir'      => $this->input->post('tempat_lahir'),
                'tanggal_lahir'     => $this->input->post('tanggal_lahir'),
                'jenis_kelamin'     => $this->input->post('jenis_kelamin'),
                'profesi'           => $this->input->post('profesi'),
                'nip'               => $this->input->post('nip'),
                'nik'               => $this->input->post('nik'),
                'hp_pegawai'        => $this->input->post('nohp'),
                'status_pegawai'    => $this->input->post('status_pegawai'),
            );

            $this->Admin_model->edit_pegawai($this->input->post('id_pegawai'), $data);
            echo 'Data Pegawai berhasil diedit!';
        }
    }

    public function editPegawai()
    {
        $output = array();
        $data = $this->Admin_model->fetch_single_pegawai($_POST['id']);

        foreach ($data as $row) {
            $output['nama_pegawai'] = $row->nama_pegawai;
            $output['gelar_depan'] = $row->gelar_depan;
            $output['gelar_belakang'] = $row->gelar_belakang;
            $output['tempat_lahir'] = $row->tempat_lahir;
            $output['tanggal_lahir'] = $row->tanggal_lahir;
            $output['jenis_kelamin'] = $row->jenis_kelamin;
            $output['profesi']  = $row->profesi;
            $output['nip'] = $row->nip;
            $output['nik'] = $row->nik;
            $output['status_pegawai'] = $row->status_pegawai;
            $output['nohp'] = $row->hp_pegawai;
        }
        echo json_encode($output);
    }

    public function fetchSingleUser()
    {
        $output = array();
        $data = $this->Admin_model->fetch_single_user($_POST['id']);

        foreach ($data as $row) {
            $output['nama_akun'] = $row->nama_pegawai;
            $output['nama_pegawai'] = $row->nama_pegawai;
            $output['username'] = $row->username;
            $output['id_user'] = $row->id_user;
            $output['role_id'] = $row->role_id;
            $output['nama_akun'] = '' . $row->gelar_depan . ' ' . $row->nama_pegawai . ' ' . $row->gelar_belakang . '';
        }
        echo json_encode($output);
    }

    public function tambahUser()
    {
        $password = $this->input->post('password2', true);

        if ($_POST['action_modal'] == 'tambah') {
            $data = array(
                'role_id'     => $this->input->post('role_id'),
                'pegawai_id'  => $this->input->post('pegawai_id'),
                'username'    => $this->input->post('username'),
                'password'    => password_hash($password, PASSWORD_DEFAULT),
                'nama_akun'   => $this->input->post('nama_akun'),
                'image'       => 'default.png',
                'is_active'   => 1

            );

            $this->Admin_model->tambah_user($data);
            echo 'User berhasil disimpan!';
        }

        if ($_POST['action_modal'] == 'edit') {
            $data = array(
                'role_id'     => $this->input->post('role_id'),
                'pegawai_id'  => $this->input->post('pegawai_id'),
                'username'    => $this->input->post('username'),
                'password'    => password_hash($password, PASSWORD_DEFAULT),
                'nama_akun'   => $this->input->post('nama_akun'),
                'image'       => 'default.png',
                'is_active'   => 1
            );

            $this->Admin_model->edit_user($this->input->post('id_user'), $data);
            echo 'User berhasil diedit!';
        }
    }

    // ------------------------------------------------------------- ROLE
    public function database()
    {
        $data['title'] = 'Database';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'administrator/database';
        echo modules::run('template/loadview', $data, $page);
    }

    public function backupDatabaseMaster()
    {
        $this->other_db = $this->load->database('db_master', TRUE);
        // $this->load->dbutil();
        $this->myutil = $this->load->dbutil($this->other_db, TRUE);
        $conf = [
            'format' => 'zip',
            'filename' => 'simrsj_master.sql',
        ];
        $backup = $this->myutil->backup($conf);
        $db_name = 'backup_simrsj_master_' . date("d-m-Y_H-i-s") . '.zip';
        $save = 'backupdb/' . $db_name;

        write_file($save, $backup);
        $this->load->helper('download');
        force_download($db_name, $backup);
    }

    public function backupDatabaseAplikasi()
    {
        $this->other_db = $this->load->database('default', TRUE);
        // $this->load->dbutil();
        $this->myutil = $this->load->dbutil($this->other_db, TRUE);
        $conf = [
            'format' => 'zip',
            'filename' => 'simrsj_aplikasi.sql',
        ];
        $backup = $this->myutil->backup($conf);
        $db_name = 'backup_simrsj_aplikasi_' . date("d-m-Y_H-i-s") . '.zip';
        $save = 'backupdb/' . $db_name;

        write_file($save, $backup);
        $this->load->helper('download');
        force_download($db_name, $backup);
    }

    public function backupDatabaseWebservice()
    {
        $this->other_db = $this->load->database('db_webservice', TRUE);
        // $this->load->dbutil();
        $this->myutil = $this->load->dbutil($this->other_db, TRUE);
        $conf = [
            'format' => 'zip',
            'filename' => 'simrsj_webservice.sql',
        ];
        $backup = $this->myutil->backup($conf);
        $db_name = 'backup_simrsj_webservice_' . date("d-m-Y_H-i-s") . '.zip';
        $save = 'backupdb/' . $db_name;

        write_file($save, $backup);
        $this->load->helper('download');
        force_download($db_name, $backup);
    }

    public function edukasi()
    {
        $data['title'] = 'Edukasi';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'administrator/data_edukasi';
        // echo modules::run('template/loadview', $data);
        echo modules::run('template/loadview', $data, $page);
    }

    public function tambahedukasi()
    {
        $data['title'] = 'Edukasi';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'administrator/tambah_edukasi';
        // echo modules::run('template/loadview', $data);
        echo modules::run('template/loadview', $data, $page);
    }

    public function getAllCreators()
    {
        $data = $this->Creator_model->fetch_all_creators();
        echo json_encode($data);
    }

    public function simpanedukasi()
    {
        $data = array(
            'judul'            => $_POST['judul'],
            'jenis'        => $_POST['jenis'],
            'urutan'     => $_POST['urutan'],
            'status'          => $_POST['status'],
            'description'     => $_POST['description'],
            'user_created'     => $this->session->userdata('pegawai_id'),
        );

        $this->Admin_model->simpan_edukasi($data);
        echo json_encode($data);
    }

    public function tabeledukasi()
    {
        $fetch_data = $this->Admin_model->make_datatables_edukasi();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = "<b>" . $row->judul . "</b><br>" . strtoupper("$row->jenis");
            $sub_array[] = substr($row->description, 0, 100);
            if ($row->status == 'aktif') {
                $sub_array[] = '
                <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="badge badge-success">' . $row->status . '</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a id="' . $row->id . '" status="1" class="dropdown-item ubahstatus">Draft</a>
                            <a id="' . $row->id . '" status="2" class="dropdown-item ubahstatus">Published</a>
                        </div>
                </div>';
            } else {
                $sub_array[] = '
                <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="badge badge-secondary">' . $row->status . '</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a id="' . $row->id . '" status="draft" class="dropdown-item ubahstatus">Draft</a>
                            <a id="' . $row->id . '" status="aktif" class="dropdown-item ubahstatus">Aktif</a>
                            <a id="' . $row->id . '" status="non aktif" class="dropdown-item ubahstatus">Non Aktif</a>
                        </div>
                </div>';
            }
            $sub_array[] = '<span href="#" class="status badge badge-primary" title="Diunggah" >' . $row->created_at . '</span><br>' . '<span href="#" class="status badge badge-info" title="Diperbarui" >' . $row->updated_at . '</span><br>';
            $sub_array[] = '
            <a href="#" class="fa fa-images ml-2 mr-2 kontenedukasi" id="' . $row->id . '" judul="' . $row->judul . '" jenis="' . $row->jenis . '" data-toggle="modal" data-target="#staticBackdrop" title="Konten"></a>
            <a href="#" class="fa fa-info-circle ml-2 mr-2 infoedukasi" id="' . $row->id . '" judul="' . $row->judul . '" jenis="' . $row->jenis . '" data-toggle="modal" data-target="#staticBackdrop" title="Info"></a>
          ';

            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_edukasi(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_edukasi(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function kontenedukasi($id)
    {
        $data['title'] = 'Konten';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();
        $data['id_edukasi'] = $id;

        $data['content'] = '';
        $page = 'administrator/konten_edukasi';
        echo modules::run('template/loadview', $data, $page);
    }

    public function simpankontenedukasi()
    {
        $data = array(
            'id_edukasi'            => $_POST['id_edukasi'],
            'link'            => $_POST['link'],
            'jenis'        => $_POST['jenis'],
            'urutan'     => $_POST['urutan'],
            'status'          => $_POST['status'],
            'keterangan'     => $_POST['keterangan'],
        );

        $this->Admin_model->simpan_list_konten_edukasi($data);
        echo json_encode($data);
    }

    public function tabelkontenedukasi()
    {
        $fetch_data = $this->Admin_model->make_datatables_konten_edukasi();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = "<b>" . $row->link . "</b><br>" . strtoupper("$row->jenis");
            $sub_array[] = substr($row->keterangan, 0, 100);
            if ($row->status == 'aktif') {
                $sub_array[] = '
                <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="badge badge-success">' . $row->status . '</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a id="' . $row->id . '" status="1" class="dropdown-item ubahstatus">Draft</a>
                            <a id="' . $row->id . '" status="2" class="dropdown-item ubahstatus">Aktif</a>
                        </div>
                </div>';
            } else {
                $sub_array[] = '
                <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="badge badge-secondary">' . $row->status . '</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a id="' . $row->id . '" status="draft" class="dropdown-item ubahstatus">Draft</a>
                            <a id="' . $row->id . '" status="aktif" class="dropdown-item ubahstatus">Aktif</a>
                            <a id="' . $row->id . '" status="non aktif" class="dropdown-item ubahstatus">Non Aktif</a>
                        </div>
                </div>';
            }
            $sub_array[] = '<span href="#" class="status badge badge-primary" title="Diunggah" >' . $row->created_at . '</span><br>' . '<span href="#" class="status badge badge-info" title="Diperbarui" >' . $row->updated_at . '</span>';
            $sub_array[] = '<a href="#" class="fas fa-question-circle fa-lg ml-2 mr-2 text-primary pertanyaan" id="' . $row->id . '" data-toggle="modal" data-target="#staticBackdrop" title="Pertanyaan"></a>';


            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_konten_edukasi(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_konten_edukasi(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function ubahstatusedukasi()
    {
        $data = array(
            'status'            => $_POST['status'],
        );

        $this->Admin_model->ubah_status_edukasi($data, $_POST['id']);
        echo json_encode($data);
    }

    public function ubahstatuskontenedukasi()
    {
        $data = array(
            'status'            => $_POST['status'],
        );

        $this->Admin_model->ubah_status_konten_edukasi($data, $_POST['id']);
        echo json_encode($data);
    }

    public function kontenedukasipertanyaan($id)
    {
        $data['title'] = 'Pertanyaan';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();
        $data['id_konten_edukasi'] = $id;

        $data['content'] = '';
        $page = 'administrator/konten_edukasi_pertanyaan';
        echo modules::run('template/loadview', $data, $page);
    }

    public function simpankontenedukasiPertanyaan()
    {
        $data = array(
            'id_list_edukasi'            => $_POST['id_list_edukasi'],
            'pertanyaan'            => $_POST['pertanyaan'],
            'jenis'        => $_POST['jenis'],
            'urutan'     => $_POST['urutan'],
            'status'          => $_POST['status'],
            'keterangan'     => $_POST['keterangan'],
        );

        $this->Admin_model->simpan_list_konten_edukasi_pertanyaan($data);
        echo json_encode($data);
    }

    public function tabelkontenedukasiPertanyaan()
    {
        $fetch_data = $this->Admin_model->make_datatables_konten_edukasi_pertanyaan();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = "<b>" . $row->pertanyaan . "</b><br>" . strtoupper("$row->jenis");
            $sub_array[] = substr($row->keterangan, 0, 25);
            if ($row->status == 'aktif') {
                $sub_array[] = '
                <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="badge badge-success">' . $row->status . '</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a id="' . $row->id . '" status="draft" class="dropdown-item statuspertanyaan">Draft</a>
                            <a id="' . $row->id . '" status="aktif" class="dropdown-item statuspertanyaan">Aktif</a>
                            <a id="' . $row->id . '" status="non aktif" class="dropdown-item statuspertanyaan">Non Aktif</a>
                        </div>
                </div>';
            } else {
                $sub_array[] = '
                <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="badge badge-secondary">' . $row->status . '</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a id="' . $row->id . '" status="draft" class="dropdown-item statuspertanyaan">Draft</a>
                            <a id="' . $row->id . '" status="aktif" class="dropdown-item statuspertanyaan">Aktif</a>
                            <a id="' . $row->id . '" status="non aktif" class="dropdown-item statuspertanyaan">Non Aktif</a>
                        </div>
                </div>';
            }
            $sub_array[] = '<span href="#" class="status badge badge-primary" title="Diunggah" >' . $row->created_at . '</span><br>' . '<span href="#" class="status badge badge-info" title="Diperbarui" >' . $row->updated_at . '</span>';
            $sub_array[] = '<a href="#" class="fas fa-clipboard-list fa-lg ml-2 mr-2 text-primary jawaban" id="' . $row->id . '" data-toggle="modal" data-target="#staticBackdrop" title="Jawaban"></a> <a href="#" class="fas fa-clipboard-check fa-lg ml-2 mr-2 text-primary jawaban_betul" id="' . $row->id . '" data-toggle="modal" data-target="#staticBackdrop" title="Jawaban Betul"></a>';


            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_konten_edukasi_pertanyaan(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_konten_edukasi_pertanyaan(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function simpankontenedukasiJawaban()
    {
        $data = array(
            'id_pertanyaan'            => $_POST['id_pertanyaan'],
            'jawaban'            => $_POST['jawaban'],
            'status'          => $_POST['status_jawaban'],
        );

        $this->Admin_model->simpan_list_konten_edukasi_jawaban($data);
        echo json_encode($data);
    }

    public function tabelkontenedukasiJawaban()
    {
        $fetch_data = $this->Admin_model->make_datatables_konten_edukasi_jawaban();
        $data = array();
        $no = $_POST['start'];
        $str = 65;
        foreach ($fetch_data as $row) {

            $no++;

            $sub_array = array();
            $alphabet_letter = chr($str);
            $sub_array[] = $no;

            $sub_array[] = "<b>" . $alphabet_letter . '. ' . $row->jawaban . "</b>";
            $str++;

            if ($row->status == 'aktif') {
                $sub_array[] = '
                <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="badge badge-success">' . $row->status . '</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a id="' . $row->id . '" status="1" class="dropdown-item ubahstatus">Draft</a>
                            <a id="' . $row->id . '" status="2" class="dropdown-item ubahstatus">Aktif</a>
                        </div>
                </div>';
            } else {
                $sub_array[] = '
                <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="badge badge-secondary">' . $row->status . '</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a id="' . $row->id . '" status="draft" class="dropdown-item ubahstatus">Draft</a>
                            <a id="' . $row->id . '" status="aktif" class="dropdown-item ubahstatus">Aktif</a>
                            <a id="' . $row->id . '" status="non aktif" class="dropdown-item ubahstatus">Non Aktif</a>
                        </div>
                </div>';
            }
            $sub_array[] = '<span href="#" class="status badge badge-primary" title="Diunggah" >' . $row->created_at . '</span><br>' . '<span href="#" class="status badge badge-info" title="Diperbarui" >' . $row->updated_at . '</span>';


            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_konten_edukasi_jawaban(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_konten_edukasi_jawaban(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function getAllJawaban()
    {
        $data = $this->Admin_model->fetch_all_jawaban($_POST['id_pertanyaan']);
        echo json_encode($data);
    }

    public function simpanJawabanBetul()
    {
        $data = array(
            'jawaban_betul'            => $_POST['jawaban'],
        );

        $this->Admin_model->simpan_jawaban_betul($data, $_POST['id_pertanyaan']);
        echo json_encode($data);
    }

    public function getPertanyaan()
    {
        // $data = $this->Admin_model->fetch_pertanyaan($_POST['id_pertanyaan']);
        $cek_pertanyaan = $this->db->select('
                           *
                            ')
            ->get_where('pertanyaan_konten_edukasi', ['pertanyaan_konten_edukasi.id' => $_POST['id_pertanyaan']])->row_array();
        // echo json_encode($cek_pertanyaan['jawaban_betul']);
        if ($cek_pertanyaan) {
            echo json_encode([
                'metadata' => [
                    'result' => [
                        'datapertanyaan' => $cek_pertanyaan,
                    ],
                    'message' => 'Data ada',
                    'code' => 200
                ],
            ], 200);
        } else {
            echo json_encode([
                'metadata' => [
                    'message' => 'Data tidak ada',
                    'code' => 201
                ],
            ], 201);
        }
    }

    public function infoedukasi()
    {
        $output = array();
        $data = $this->Edukasi_model->fetch_single_konten($_POST['id']);

        foreach ($data as $row) {
            $output['judul'] = $row->judul;
            $output['description'] = $row->description;
        }
        echo json_encode($output);
    }

    public function ubahstatuspertanyaan()
    {
        $data = array(
            'status'            => $_POST['status'],
        );

        $this->Admin_model->ubah_status_pertanyaan($data, $_POST['id']);
        echo json_encode($data);
    }

    public function pernyataanTarget()
    {
        $data['title'] = 'Pernyataan Target';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'administrator/pernyataan_target';
        // echo modules::run('template/loadview', $data);
        echo modules::run('template/loadview', $data, $page);
    }

    public function tambahpernyataantarget()
    {
        $data['title'] = 'Pernyataan Target';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();

        $data['content'] = '';
        $page = 'administrator/tambah_pernyataan_target';
        // echo modules::run('template/loadview', $data);
        echo modules::run('template/loadview', $data, $page);
    }

    public function simpanpernyataantarget()
    {
        $data = array(
            'target'            => $_POST['target'],
            'jenis'        => $_POST['jenis'],
            'urutan'     => $_POST['urutan'],
            'status'          => $_POST['status'],
            'description'     => $_POST['description'],
            'user_created'     => $this->session->userdata('pegawai_id'),
        );

        $this->Admin_model->simpan_pernyataantarget($data);
        echo json_encode($data);
    }

    public function tabelpernyataantarget()
    {
        $fetch_data = $this->Admin_model->make_datatables_pernyataantarget();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = "<b>" . $row->target . "</b><br>" . strtoupper("$row->jenis");
            $sub_array[] = substr($row->description, 0, 100);
            if ($row->status == 'aktif') {
                $sub_array[] = '
                <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="badge badge-success">' . $row->status . '</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a id="' . $row->id . '" status="1" class="dropdown-item ubahstatus">Draft</a>
                            <a id="' . $row->id . '" status="2" class="dropdown-item ubahstatus">Published</a>
                        </div>
                </div>';
            } else {
                $sub_array[] = '
                <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="badge badge-secondary">' . $row->status . '</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a id="' . $row->id . '" status="draft" class="dropdown-item ubahstatus">Draft</a>
                            <a id="' . $row->id . '" status="aktif" class="dropdown-item ubahstatus">Aktif</a>
                            <a id="' . $row->id . '" status="non aktif" class="dropdown-item ubahstatus">Non Aktif</a>
                        </div>
                </div>';
            }
            $sub_array[] = '<span href="#" class="status badge badge-primary" title="Diunggah" >' . $row->created_at . '</span><br>' . '<span href="#" class="status badge badge-info" title="Diperbarui" >' . $row->updated_at . '</span><br>';
            $sub_array[] = '
            <a href="#" class="fa fa-images ml-2 mr-2 target" id="' . $row->id . '" target="' . $row->target . '" jenis="' . $row->jenis . '" data-toggle="modal" data-target="#staticBackdrop" title="Target"></a>
            <a href="#" class="fa fa-info-circle ml-2 mr-2 info" id="' . $row->id . '" target="' . $row->target . '" jenis="' . $row->jenis . '" data-toggle="modal" data-target="#staticBackdrop" title="Info"></a>
          ';

            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_pernyataantarget(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_pernyataantarget(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function infopernyataantarget()
    {
        $output = array();
        $data = $this->Edukasi_model->fetch_single_target($_POST['id']);

        foreach ($data as $row) {
            $output['target'] = $row->target;
            $output['description'] = $row->description;
        }
        echo json_encode($output);
    }

    public function kontentarget($id)
    {
        $data['title'] = 'Target';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();
        $data['id_target'] = $id;

        $data['content'] = '';
        $page = 'administrator/konten_target';
        echo modules::run('template/loadview', $data, $page);
    }

    public function simpanlisttarget()
    {
        $data = array(
            'id_target'            => $_POST['id_target'],
            'link'            => $_POST['link'],
            'jenis'        => $_POST['jenis'],
            'urutan'     => $_POST['urutan'],
            'status'          => $_POST['status'],
            'keterangan'     => $_POST['keterangan'],
        );

        $this->Admin_model->simpan_list_target($data);
        echo json_encode($data);
    }

    public function tabellisttarget()
    {
        $fetch_data = $this->Admin_model->make_datatables_list_pernyataan_target();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = "<b>" . $row->link . "</b><br>" . strtoupper("$row->jenis");
            $sub_array[] = substr($row->keterangan, 0, 100);
            if ($row->status == 'aktif') {
                $sub_array[] = '
                <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="badge badge-success">' . $row->status . '</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a id="' . $row->id . '" status="1" class="dropdown-item ubahstatus">Draft</a>
                            <a id="' . $row->id . '" status="2" class="dropdown-item ubahstatus">Aktif</a>
                        </div>
                </div>';
            } else {
                $sub_array[] = '
                <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="badge badge-secondary">' . $row->status . '</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a id="' . $row->id . '" status="draft" class="dropdown-item ubahstatus">Draft</a>
                            <a id="' . $row->id . '" status="aktif" class="dropdown-item ubahstatus">Aktif</a>
                            <a id="' . $row->id . '" status="non aktif" class="dropdown-item ubahstatus">Non Aktif</a>
                        </div>
                </div>';
            }
            $sub_array[] = '<span href="#" class="status badge badge-primary" title="Diunggah" >' . $row->created_at . '</span><br>' . '<span href="#" class="status badge badge-info" title="Diperbarui" >' . $row->updated_at . '</span>';
            $sub_array[] = '<a href="#" class="fas fa-question-circle fa-lg ml-2 mr-2 text-primary pertanyaan" id="' . $row->id . '" data-toggle="modal" data-target="#staticBackdrop" title="Pertanyaan"></a>';


            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_list_pernyataan_target(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_list_pernyataan_target(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function ubahstatuslisttarget()
    {
        $data = array(
            'status'            => $_POST['status'],
        );

        $this->Admin_model->ubah_status_list_pernyataan_target($data, $_POST['id']);
        echo json_encode($data);
    }

    public function listtargetpertanyaan($id)
    {
        $data['title'] = 'Pertanyaan';
        $data['user'] = $this->db->get_where('user', ['username' =>
        $this->session->userdata('username')])->row_array();
        $data['id_list_target'] = $id;

        $data['content'] = '';
        $page = 'administrator/list_target_pertanyaan';
        echo modules::run('template/loadview', $data, $page);
    }

    public function simpanlisttargetPertanyaan()
    {
        $data = array(
            'id_list_target'            => $_POST['id_list_target'],
            'pertanyaan'            => $_POST['pertanyaan'],
            'jenis'        => $_POST['jenis'],
            'urutan'     => $_POST['urutan'],
            'status'          => $_POST['status'],
            'keterangan'     => $_POST['keterangan'],
        );

        $this->Admin_model->simpan_pertanyaan_target($data);
        echo json_encode($data);
    }

    public function tabellisttargetPertanyaan()
    {
        $fetch_data = $this->Admin_model->make_datatables_target_pertanyaan();
        $data = array();
        $no = $_POST['start'];
        foreach ($fetch_data as $row) {
            $no++;
            $sub_array = array();
            $sub_array[] = $no;
            $sub_array[] = "<b>" . $row->pertanyaan . "</b><br>" . strtoupper("$row->jenis");
            $sub_array[] = substr($row->keterangan, 0, 25);
            if ($row->status == 'aktif') {
                $sub_array[] = '
                <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="badge badge-success">' . $row->status . '</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a id="' . $row->id . '" status="draft" class="dropdown-item statuspertanyaan">Draft</a>
                            <a id="' . $row->id . '" status="aktif" class="dropdown-item statuspertanyaan">Aktif</a>
                            <a id="' . $row->id . '" status="non aktif" class="dropdown-item statuspertanyaan">Non Aktif</a>
                        </div>
                </div>';
            } else {
                $sub_array[] = '
                <div class="dropdown">
                        <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          <span class="badge badge-secondary">' . $row->status . '</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                            <a id="' . $row->id . '" status="draft" class="dropdown-item statuspertanyaan">Draft</a>
                            <a id="' . $row->id . '" status="aktif" class="dropdown-item statuspertanyaan">Aktif</a>
                            <a id="' . $row->id . '" status="non aktif" class="dropdown-item statuspertanyaan">Non Aktif</a>
                        </div>
                </div>';
            }
            $sub_array[] = '<span href="#" class="status badge badge-primary" title="Diunggah" >' . $row->created_at . '</span><br>' . '<span href="#" class="status badge badge-info" title="Diperbarui" >' . $row->updated_at . '</span>';
            $sub_array[] = '<a href="#" class="fas fa-clipboard-list fa-lg ml-2 mr-2 text-primary jawaban" id="' . $row->id . '" data-toggle="modal" data-target="#staticBackdrop" title="Jawaban"></a> <a href="#" class="fas fa-clipboard-check fa-lg ml-2 mr-2 text-primary jawaban_betul" id="' . $row->id . '" data-toggle="modal" data-target="#staticBackdrop" title="Jawaban Betul"></a>';


            $data[] = $sub_array;
        }

        $output = array(
            "draw"                => intval($_POST['draw']),
            "recordsTotal"        => $this->Admin_model->get_all_data_target_pertanyaan(),
            "recordsFiltered"     => $this->Admin_model->get_filtered_data_target_pertanyaan(),
            "data"                => $data
        );
        echo json_encode($output);
    }

    public function ubahstatustargetpertanyaan()
    {
        $data = array(
            'status'            => $_POST['status'],
        );

        $this->Admin_model->ubah_status_target_pertanyaan($data, $_POST['id']);
        echo json_encode($data);
    }
}
