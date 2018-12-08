<?php
require('application/libraries/REST_Controller.php');
require APPPATH . 'libraries/Format.php';

class Pembelian extends REST_Controller {

   // show data pembelian
   function user_get() {
       $get_transaksi = $this->db->query("SELECT film.id_film, tiket.id_tiket,tiket.id_film,tiket.id_studio,studio.id_studio, film.judul, tiket.harga, tiket.tayang, tiket.foto_tiket FROM tiket, film, studio Where film.id_film=tiket.id_film AND studio.id_studio=tiket.id_studio")->result();
     
       $this->response(array("status"=>"success","result" => $get_transaksi));
   }
   // insert pembelian
   function user_post() {
       $data_tiket = array(
           'id_tiket'   => $this->post('id_tiket'),
           'id_film'     => $this->post('id_film'),
           'id_studio'   => $this->post('id_studio'),
           'harga'    => $this->post('harga'),
           'tayang'       => $this->post('tayang'),
           'foto_tiket'       => $this->post('foto_tiket')
           );
      
       if  (empty($data_tiket['id_tiket'])){
            $this->response(array('status'=>'fail',"message"=>"id_tiket kosong"));
       }
       else {
           $getId = $this->db->query("Select id_tiket from tiket where id_tiket='".$data_tiket['id_tiket']."'")->result();
          
           //jika id_tiket tidak ada dalam database maka eksekusi insert
           if (empty($getId)){
                    if (empty($data_tiket['id_tiket'])){
                       $this->response(array('status'=>'fail',"message"=>"id_tiket kosong"));
                    }
                    else if(empty($data_tiket['id_film'])){
                       $this->response(array('status'=>'fail',"message"=>"id_film kosong"));
                    }else if(empty($data_tiket['id_studio'])){
                       $this->response(array('status'=>'fail',"message"=>"id_studio kosong"));
                    }else if(empty($data_tiket['harga'])){
                       $this->response(array('status'=>'fail',"message"=>"harga kosong"));
                    }
                    else{
                       //jika masuk pada else atau kondisi ini maka dipastikan seluruh input telah di set
                       //jika akan melakukan pembelian id_pembeli dan id_tiket harus dipastikan ada
                       $getIdfilm = $this->db->query("Select id_film from film Where id_film='".$data_tiket['id_film']."'")->result();
                       $getIdstudio = $this->db->query("Select id_studio from studio Where id_studio='".$data_tiket['id_studio']."'")->result();
                       $message="";
                       if (empty($getIdfilm)) $message.="id_film tidak ada/salah ";
                       if (empty($getIdstudio)) {
                           if (empty($message)) {
                               $message.="id_tiket tidak ada/salah";
                           }
                           else {
                               $message.="dan id_tiket tidak ada/salah";
                           }
                       }
                       if (empty($message)){
                           $insert= $this->db->insert('tiket',$data_tiket);
                           if ($insert){
                               $this->response(array('status'=>'success','result' => $data_tiket,"message"=>$insert));   
                           }
                          
                       }else{
                           $this->response(array('status'=>'fail',"message"=>$message));   
                       }
                      
                    }
           }else{
               $this->response(array('status'=>'fail',"message"=>"id_bioskop sudah ada"));
           }  
       }
   }

   // update data pembelian
   function user_put() {
       $data_tiket = array(
           'id_tiket'   => $this->put('id_tiket'),
           'id_film'     => $this->put('id_film'),
           'id_studio'   => $this->put('id_studio'),
           'harga'    => $this->put('harga'),
           'tayang'       => $this->put('tayang'),
           'foto_tiket'       => $this->put('foto_tiket')
                   );
       if  (empty($data_tiket['id_tiket'])){
            $this->response(array('status'=>'fail',"message"=>"id_tiket kosong"));
       }else{
            $getId = $this->db->query("Select id_tiket from tiket where id_tiket='".$data_tiket['id_tiket']."'")->result();
           //jika id_pembelian harus ada dalam database
           if (empty($getId)){
             $this->response(array('status'=>'fail',"message"=>"id_tiket tidak ada/salah")); 
           }else{
               //jika masuk disini maka dipastikan id_pembelian ada dalam database
                if (empty($data_tiket['id_tiket'])){
                       $this->response(array('status'=>'fail',"message"=>"id_tiket kosong"));
                    }
                    else if(empty($data_tiket['id_film'])){
                       $this->response(array('status'=>'fail',"message"=>"id_film kosong"));
                    }else if(empty($data_tiket['id_studio'])){
                       $this->response(array('status'=>'fail',"message"=>"id_studio kosong"));
                    }else if(empty($data_tiket['harga'])){
                       $this->response(array('status'=>'fail',"message"=>"harga kosong"));
                    }else if(empty($data_tiket['tayang'])){
                       $this->response(array('status'=>'fail',"message"=>"tayang kosong"));
                    }
                else{
                   //jika masuk pada else atau kondisi ini maka dipastikan seluruh input telah di set
                   //jika akan melakukan edit pembelian id_pembeli dan id_tiket harus dipastikan ada
                     //jika akan melakukan pembelian id_pembeli dan id_tiket harus dipastikan ada
                       $getIdlogin = $this->db->query("Select id_tiket from tiket Where id_tiket='".$data_tiket['id_tiket']."'")->result();
                       $getIdTiket = $this->db->query("Select id_tiket from tiket Where id_tiket='".$data_tiket['id_tiket']."'")->result();
                       $message="";
                       if (empty($getIdlogin)) $message.="id_tiket tidak ada/salah ";
                       if (empty($getIdTiket)) {
                           if (empty($message)) {
                               $message.="id_tiket tidak ada/salah";
                           }
                           else {
                               $message.="dan id_tiket tidak ada/salah";
                           }
                       }
                   if (empty($message)){
                       $this->db->where('id_tiket',$data_tiket['id_tiket']);
                       $update= $this->db->update('tiket',$data_tiket);
                       if ($update){
                           $this->response(array('status'=>'success','result' => $data_tiket,"message"=>$update));
                       }
                      
                   }else{
                       $this->response(array('status'=>'fail',"message"=>$message));   
                   }
                }
           }

       }
   }

   // delete pembelian
   function user_delete() {
       $id_tiket = $this->delete('id_tiket');
       if (empty($id_tiket)){
           $this->response(array('status' => 'fail', "message"=>"id_tiket harus diisi"));
       } else {
           $this->db->where('id_tiket', $id_tiket);
           $delete = $this->db->delete('tiket');  
           if ($this->db->affected_rows()) {
               $this->response(array('status' => 'success','message' =>"Berhasil delete dengan id_tiket = ".$id_tiket));
           } else {
               $this->response(array('status' => 'fail', 'message' =>"id_tiket tidak dalam database"));
           }
       }
   }
}  