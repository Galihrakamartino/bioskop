<?php

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'libraries/Format.php';

class studio extends REST_Controller {

    // Konfigurasi letak folder untuk upload image
    private $folder_upload = 'uploads/';

    function all_get(){
        $get_pembeli = $this->db->query("
            SELECT
                id_studio,
                tempat_duduk,
                photo_url
 FROM studio")->result();
       $this->response(
           array(
               "status" => "success",
               "result" => $get_pembeli
           )
       );
    }

    function all_post() {

        $action  = $this->post('action');
        $data_pembeli = array(
                       'id_studio' => $this->post('id_studio'),
                       'tempat_duduk'       => $this->post('tempat_duduk'),
                       'photo_url'   => $this->post('photo_url')
                   );

        switch ($action) {
            case 'insert':
                $this->insertPembeli($data_pembeli);
                break;
            
            case 'update':
                $this->updatePembeli($data_pembeli);
                break;
            
            case 'delete':
                $this->deletePembeli($data_pembeli);
                break;
            
            default:
                $this->response(
                    array(
                        "status"  =>"failed",
                        "message" => "action harus diisi"
                    )
                );
                break;
        }
    }
 function insertPembeli($data_pembeli){

       // Cek validasi
       if (empty($data_pembeli['tempat_duduk'])){
           $this->response(
               array(
                   "status" => "failed",
                   "message" => "Tempat Duduk harus diisi"
               )
           );
       } else {

           $data_pembeli['photo_url'] = $this->uploadPhoto();

           $do_insert = $this->db->insert('studio', $data_pembeli);
          
           if ($do_insert){
               $this->response(
                   array(
                       "status" => "success",
                       "result" => array($data_pembeli),
                       "message" => $do_insert
                   )
               );
            }
       }
    }

    function updatePembeli($data_pembeli){

       // Cek validasi
       if (empty($data_pembeli['id_studio']) || empty($data_pembeli['tempat_duduk'])){
           $this->response(
               array(
                   "status" => "failed",
                   "message" => "Id Studio/ Tempat Duduk / Photo url harus diisi"
               )
           );
       } else {
           // Cek apakah ada di database
           $get_pembeli_baseID = $this->db->query("
               SELECT 1
               FROM studio
               WHERE id_studio =  {$data_pembeli['id_studio']}")->num_rows();

           if($get_pembeli_baseID === 0){
               // Jika tidak ada
               $this->response(
                   array(
                       "status"  => "failed",
                       "message" => "ID Studio tidak ditemukan"
                   )
               );
           } else {
               // Jika ada
               $data_pembeli['photo_url'] = $this->uploadPhoto();

               if ($data_pembeli['photo_url']){
                   // Jika upload foto berhasil, eksekusi update
                   $update = $this->db->query("
                       UPDATE studio SET
                           id_studio = '{$data_pembeli['id_studio']}',
                           tempat_duduk = '{$data_pembeli['tempat_duduk']}',
                           photo_url = '{$data_pembeli['photo_url']}'
                       WHERE id_studio = '{$data_pembeli['id_studio']}'");

               } else {
                   // Jika foto kosong atau upload foto tidak berhasil, eksekusi update
                    $update = $this->db->query("
                        UPDATE pembeli
                        SET
                            id_studio    = '{$data_pembeli['id_studio']}',
                            tempat_duduk  = '{$data_pembeli['tempat_duduk']}',
                            photo_url = '{$data_pembeli['photo_url']}'
                        WHERE id_studio = {$data_pembeli['id_studio']}"
                    );
               }
              
               if ($update){
                   $this->response(
                       array(
                           "status"    => "success",
                           "result"    => array($data_pembeli),
                           "message"   => $update
   )
                   );
                }
           }   
       }
    }

    function deletePembeli($data_pembeli){

        if (empty($data_pembeli['id_studio'])){
           $this->response(
               array(
                   "status" => "failed",
                   "message" => "ID Studio harus diisi"
               )
           );
       } else {
           // Cek apakah ada di database
           $get_pembeli_baseID =$this->db->query("
               SELECT 1
               FROM studio
               WHERE id_studio = {$data_pembeli['id_studio']}")->num_rows();

           if($get_pembeli_baseID > 0){
               
               $get_photo_url =$this->db->query("
               SELECT photo_url
               FROM studio
               WHERE id_studio = {$data_pembeli['id_studio']}")->result();
           
                if(!empty($get_photo_url)){

                    // Dapatkan nama file
                    $photo_nama_file = basename($get_photo_url[0]->photo_url);
                    // Dapatkan letak file di folder upload
                    $photo_lokasi_file = realpath(FCPATH . $this->folder_upload . $photo_nama_file);
                    
                    // Jika file ada, hapus
                    if(file_exists($photo_lokasi_file)) {
                        // Hapus file
                       unlink($photo_lokasi_file);
                   }
 $this->db->query("
                       DELETE FROM studio
                       WHERE id_studio = {$data_pembeli['id_studio']}");
                   $this->response(
                       array(
                           "status" => "success",
                           "message" => "Data ID = " .$data_pembeli['id_studio']. " berhasil dihapus"
                       )
                   );
               }
           
            } else {
                $this->response(
                    array(
                        "status" => "failed",
                        "message" => "ID Studio tidak ditemukan"
                    )
                );
            }
       }
    }

    function uploadPhoto() {

        // Apakah user upload gambar?
        if ( isset($_FILES['photo_url']) && $_FILES['photo_url']['size'] > 0 ){

            // Foto disimpan di android-api/uploads
            $config['upload_path'] = realpath(FCPATH . $this->folder_upload);
            $config['allowed_types'] = 'jpg|png';

           // Load library upload & helper
           $this->load->library('upload', $config);
           $this->load->helper('url');

           // Apakah file berhasil diupload?
           if ( $this->upload->do_upload('photo_url')) {

               // Berhasil, simpan nama file-nya
               // URL image yang disimpan adalah http://localhost/android-api/uploads/namafile
               $img_data = $this->upload->data();
               $post_image = base_url(). $this->folder_upload 
               .$img_data['file_name'];

           } else {

               // Upload gagal, beri nama image dengan errornya
               // Ini bodoh, tapi efektif
               $post_image = $this->upload->display_errors();
               
           }
       } else {
           // Tidak ada file yang di-upload, kosongkan nama image-nya
           $post_image = '';
       }

       return $post_image;
    }
}

?>