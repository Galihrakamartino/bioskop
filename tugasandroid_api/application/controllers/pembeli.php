<?php
require('application/libraries/REST_Controller.php');
require APPPATH . 'libraries/Format.php';

class Pembeli extends REST_Controller {

   // show data pembelian
   function index_get() {
       
        $get_transaksi = $this->db->query("SELECT * FROM Pembeli")->result();
     
       $this->response(array("status"=>"success","result" => $get_transaksi));
   }

   // insert pembelian
   function index_post() {
       $data_lokasi = array(
           'id_pembeli'   => $this->post('id_pembeli'),
           'id_tiket'     => $this->post('id_tiket'),
           'nama'   => $this->post('nama'),
           'alamat'    => $this->post('alamat'),
           'telp'       => $this->post('telp')
           );
          
           if  (empty($data_lokasi['id_pembeli'])){
            $this->response(array('status'=>'fail',"message"=>"id_pembeli kosong"));
       }
       else {
           $getId = $this->db->query("Select id_pembeli from pembeli where id_pembeli='".$data_lokasi['id_pembeli']."'")->result();
          
           //jika id_pembelian tidak ada dalam database maka eksekusi insert
           if (empty($getId)){
                    if (empty($data_lokasi['nama'])){
                       $this->response(array('status'=>'fail',"message"=>"nama kosong"));
                    }
                    else if(empty($data_lokasi['alamat'])){
                       $this->response(array('status'=>'fail',"message"=>"alamat kosong"));
                    }else if(empty($data_lokasi['telp'])){
                       $this->response(array('status'=>'fail',"message"=>"telp kosong"));
                    }
                    else{
                       //jika masuk pada else atau kondisi ini maka dipastikan seluruh input telah di set
                       //jika akan melakukan pembelian id_pembeli dan id_tiket harus dipastikan ada
                       $getIdPembeli = $this->db->query("Select id_pembeli from pembeli Where id_pembeli='".$data_lokasi['id_pembeli']."'")->result();
                       $getIdTiket = $this->db->query("Select id_tiket from tiket Where id_tiket='".$data_lokasi['id_tiket']."'")->result();
                       $message="";
                       if (empty($getIdTiket)) {
                           if (empty($message)) {
                               $message.="id_tiket tidak ada/salah";
                           }
                           else {
                               $message.="dan id_tiket tidak ada/salah";
                           }
                       }
                       if (empty($message)){
                           $insert= $this->db->insert('pembeli',$data_lokasi);
                           if ($insert){
                               $this->response(array('status'=>'success','result' => $data_lokasi,"message"=>$insert));   
                           }
                          
                       }else{
                           $this->response(array('status'=>'fail',"message"=>$message));   
                       }
                      
                    }
           }else{
               $this->response(array('status'=>'fail',"message"=>"id_pembeli sudah ada"));
           }  
       }
   }
   

   // update data pembelian
   function index_put() {
       $data_lokasi = array(
                     'id_pembeli'   => $this->put('id_pembeli'),
           'id_tiket'     => $this->put('id_tiket'),
           'nama'   => $this->put('nama'),
           'alamat'    => $this->put('alamat'),
           'telp'       => $this->put('telp')
                   );
        if  (empty($data_lokasi['id_pembeli'])){
            $this->response(array('status'=>'fail',"message"=>"id_pembeli kosong"));
       }else{
           $getId = $this->db->query("Select id_pembeli from pembeli where id_pembeli='".$data_lokasi['id_pembeli']."'")->result();
           //jika id_pembelian harus ada dalam database
           if (empty($getId)){
             $this->response(array('status'=>'fail',"message"=>"id_pembeli tidak ada/salah")); 
           }else{
               //jika masuk disini maka dipastikan id_pembelian ada dalam database
                if (empty($data_lokasi['id_tiket'])){
                   $this->response(array('status'=>'fail',"message"=>"id_tiket kosong"));
                }
                else if(empty($data_lokasi['nama'])){
                   $this->response(array('status'=>'fail',"message"=>"nama kosong"));
                }else if(empty($data_lokasi['alamat'])){
                   $this->response(array('status'=>'fail',"message"=>"alamat kosong"));
                }else if(empty($data_lokasi['telp'])){
                       $this->response(array('status'=>'fail',"message"=>"telp kosong"));
                } 
                else{
                   //jika masuk pada else atau kondisi ini maka dipastikan seluruh input telah di set
                   //jika akan melakukan edit pembelian id_pembeli dan id_tiket harus dipastikan ada
                   $getIdPembeli = $this->db->query("Select id_pembeli from pembeli Where id_pembeli='".$data_lokasi['id_pembeli']."'")->result();
                       $getIdTiket = $this->db->query("Select id_tiket from tiket Where id_tiket='".$data_lokasi['id_tiket']."'")->result();
                   $message="";
                   if (empty($getIdTiket)) {
                       if (empty($message)) {
                           $message.="id_tiket tidak ada/salah";
                       }
                       else {
                           $message.="dan id_tiket tidak ada/salah";
                       }
                   }
                   if (empty($message)){
                       $this->db->where('id_pembeli',$data_lokasi['id_pembeli']);
                       $update= $this->db->update('pembeli',$data_lokasi);
                       if ($update){
                           $this->response(array('status'=>'success','result' => $data_lokasi,"message"=>$update));
                       }
                      
                   }else{
                       $this->response(array('status'=>'fail',"message"=>$message));   
                   }
                }
           }

       }
   }
       
   

   // delete pembelian
   function index_delete() {
       $id_pembeli = $this->delete('id_pembeli');
       if (empty($id_pembeli)){
           $this->response(array('status' => 'fail', "message"=>"id_pembeli harus diisi"));
       } else {
           $this->db->where('id_pembeli', $id_pembeli);
           $delete = $this->db->delete('pembeli');  
           if ($this->db->affected_rows()) {
               $this->response(array('status' => 'success','message' =>"Berhasil delete dengan id_pembeli = ".$id_pembeli));
           } else {
               $this->response(array('status' => 'fail', 'message' =>"id_pembeli tidak dalam database"));
           }
       }
   }
}  