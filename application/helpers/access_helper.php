<?php

function is_logged_in()
{
    $ci = get_instance();
    if (!$ci->session->userdata('username')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);

        $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu])->row_array();
        $menu_id = $queryMenu['id'];

        $userAccess = $ci->db->get_where('user_access_menu', [
            'role_id' => $role_id,
            'menu_id' => $menu_id
        ]);

        if ($userAccess->num_rows() < 1) {
            redirect('auth/blocked');
        }
    }
}
function check_access($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('role_id', $role_id);
    $ci->db->where('menu_id', $menu_id);
    $result = $ci->db->get('user_access_menu');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function check_jawaban($pertanyaan_id, $id_akses_materi, $id_jawaban)
{
    $ci = get_instance();

    $ci->db->where('id_pertanyaan', $pertanyaan_id);
    $ci->db->where('id_akses_materi', $id_akses_materi);
    $ci->db->where('id_jawaban', $id_jawaban);
    $result = $ci->db->get('pilih_jawaban_edukasi');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function check_jawaban_selfcontrol($pertanyaan_id, $id_akses_selfcontrol, $id_jawaban)
{
    $ci = get_instance();

    $ci->db->where('id_pertanyaan', $pertanyaan_id);
    $ci->db->where('id_akses_selfcontrol', $id_akses_selfcontrol);
    $ci->db->where('id_jawaban', $id_jawaban);
    $result = $ci->db->get('pilih_jawaban_selfcontrol');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function check_jawaban_kuesioner($pertanyaan_id, $id_akses_materi, $id_jawaban)
{
    $ci = get_instance();

    $ci->db->where('id_pertanyaan', $pertanyaan_id);
    $ci->db->where('id_akses_kuesioner', $id_akses_materi);
    $ci->db->where('id_jawaban', $id_jawaban);
    $result = $ci->db->get('pilih_jawaban_kuesioner');

    if ($result->num_rows() > 0) {
        return "checked='checked'";
    }
}

function check_jawaban_kuesioner_text($pertanyaan_id, $id_akses_materi)
{
    $ci = get_instance();

    $result = $ci->db->get_where('pilih_jawaban_kuesioner', ['id_pertanyaan' => $pertanyaan_id, 'id_akses_kuesioner' => $id_akses_materi])->row_array();
    if ($result) {
        return $result['jawaban'];
    }
}
