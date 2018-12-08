<?php
require('application/libraries/REST_Controller.php');
require APPPATH . 'libraries/Format.php';

class film extends REST_Controller {

   // show data pembelian
   function index_get() {
       $get_film = $this->db->query("SELECT * FROM studio")->result();
     
       $this->response(array("status"=>"success","result" => $get_film));
   }
   // insert pembelian
   function index_post() {
       $data_tiket = array(
           'id_film'   => $this->post('id_film'),
           'judul'     => $this->post('judul'),
           'genre'     => $this->post('foto_tiket')
           );
      
       if  (empty($data_film['id_film'])){
            $this->response(array('status'=>'fail',"message"=>"id_film kosong"));
       }
       else {
           $getId = $this->db->query("Select id_film from film where id_film='".$data_film['id_film']."'")->result();
          
           //jika id_tiket tidak ada dalam database maka eksekusi insert
           if (empty($getId)){
                    if (empty($data_film['id_film'])){
                       $this->response(array('status'=>'fail',"message"=>"id_film kosong"));
                    }
                    else if(empty($data_film['judul'])){
                       $this->response(array('status'=>'fail',"message"=>"judul kosong"));
                    }else if(empty($data_tiket['genre'])){
                       $this->response(array('status'=>'fail',"message"=>"genre kosong"));
                    }
                    else{
                       //jika masuk pada else atau kondisi ini maka dipastikan seluruh input telah di set
                       //jika akan melakukan pembelian id_pembeli dan id_tiket harus dipastikan ada
                      
                           $insert= $this->db->insert('tiket',$data_tiket);
                           if ($insert){
                               $this->response(array('status'=>'success','result' => $data_tiket,"message"=>$insert));    
                       }else{
                           $this->response(array('status'=>'fail',"message"=>$message));   
                       }
                     }
           }  
       }
   }


   // update data pembelian
   function index_put() {
       $data_film = array(
           'id_film'   => $this->put('id_film'),
           'judul'     => $this->put('judul'),
           'genre'       => $this->put('genre')
                   );
       if  (empty($data_film['id_film'])){
            $this->response(array('status'=>'fail',"message"=>"id_film kosong"));
       }else{
            $getId = $this->db->query("Select id_film from film where id_film='".$data_film['id_film']."'")->result();
           //jika id_pembelian harus ada dalam database
           if (empty($getId)){
             $this->response(array('status'=>'fail',"message"=>"id_film tidak ada/salah")); 
           }else{
               //jika masuk disini maka dipastikan id_pembelian ada dalam database
                if (empty($data_film['id_film'])){
                       $this->response(array('status'=>'fail',"message"=>"id_tiket kosong"));
                    }
                    else if(empty($data_film['id_film'])){
                       $this->response(array('status'=>'fail',"message"=>"id_film kosong"));
                    }else if(empty($data_film['judul'])){
                       $this->response(array('status'=>'fail',"message"=>"judul kosong"));
                     }else if(empty($data_film['genre'])){
                       $this->response(array('status'=>'fail',"message"=>"genre kosong"));
                    }
                else{
                  
                       $this->db->where('id_film',$data_film['id_film']);
                       $update= $this->db->update('film',$data_film);
                       if ($update){
                           $this->response(array('status'=>'success','result' => $data_film,"message"=>$update));
                       
                      
                   }else{
                       $this->response(array('status'=>'fail',"message"=>$message));   
                   }
                }
           }

       }
   }

   // delete pembelian
   function index_delete() {
       $id_film = $this->delete('id_film');
       if (empty($id_film)){
           $this->response(array('status' => 'fail', "message"=>"id_film harus diisi"));
       } else {
           $this->db->where('id_film', $id_film);
           $delete = $this->db->delete('film');  
           if ($this->db->affected_rows()) {
               $this->response(array('status' => 'success','message' =>"Berhasil delete dengan id_film = ".$id_film));
           } else {
               $this->response(array('status' => 'fail', 'message' =>"id_film tidak dalam database"));
           }
       }
   }
}  