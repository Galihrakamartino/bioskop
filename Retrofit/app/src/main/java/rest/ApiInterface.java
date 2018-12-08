package rest;
import com.example.acer.retrofit.GetPembeli;
import com.example.acer.retrofit.GetPembelian;
import com.example.acer.retrofit.GetStudio;
import com.example.acer.retrofit.PostPutDelPembeli;
import com.example.acer.retrofit.PostPutDelPembelian;

import okhttp3.MultipartBody;
import okhttp3.RequestBody;
import retrofit2.Call;
import retrofit2.http.Field;
import retrofit2.http.FormUrlEncoded;
import retrofit2.http.GET;
import retrofit2.http.HTTP;
import retrofit2.http.Multipart;
import retrofit2.http.POST;
import retrofit2.http.PUT;
import retrofit2.http.Part;


/**
 * Created by Acer on 01/11/2018.
 */

public interface ApiInterface {
    @GET("pembelian/user")
    Call<GetPembelian> getPembelian();

    @FormUrlEncoded
    @POST("pembelian/user")
    Call<PostPutDelPembelian> postPembelian(@Field("id_pembelian") String idPembelian,
                                            @Field("id_pembeli") String idPembeli,
                                            @Field("tanggal_beli") String tanggalBeli,
                                            @Field("total_harga") String totalHarga,
                                            @Field("id_tiket") String idTiket);
    @FormUrlEncoded
    @PUT("pembelian/user")
    Call<PostPutDelPembelian> putPembelian(@Field("id_pembelian") String idPembelian,
                                           @Field("id_pembeli") String idPembeli,
                                           @Field("tanggal_beli") String tanggalBeli,
                                           @Field("total_harga") String totalHarga,
                                           @Field("id_tiket") String idTiket);

    @FormUrlEncoded
    @HTTP(method = "DELETE", path = "pembelian/user", hasBody = true)
    Call<PostPutDelPembelian> deletePembelian(@Field("id_pembelian") String idPembelian);

    /********* Pembeli *********/

    @GET("pembeli")
    Call<GetPembeli> getPembeli();

    @FormUrlEncoded
    @POST("pembeli")
    Call<PostPutDelPembeli> postPembeli
            (@Field("id_pembeli") String idPembeli, @Field("id_tiket") String idTiket,
             @Field("nama") String nama, @Field("alamat") String alamat,
             @Field("telp") String telp);

    @FormUrlEncoded
    @PUT("pembeli")
    Call<PostPutDelPembeli> putPembeli(
            @Field("id_pembeli") String idPembeli, @Field("id_tiket") String idTiket,
            @Field("nama") String nama, @Field("alamat") String alamat,
            @Field("telp") String telp);

    @FormUrlEncoded
    @HTTP(method = "DELETE", path = "pembeli", hasBody = true)
    Call<PostPutDelPembeli> deletePembeli(@Field("id_pembeli") String idPembeli);


    /********* Studio *********/

    @GET("studio/all")
    Call<GetStudio> getStudio();

    @Multipart
    @POST("studio/all")
    Call<GetStudio> postStudio(
            @Part MultipartBody.Part file,
            @Part("tempat_duduk") RequestBody tempatduduk,
            @Part("action") RequestBody action
    );

    @Multipart
    @POST("studio/all")
    Call<GetStudio> putStudio(
            @Part MultipartBody.Part file,
            @Part("id_studio") RequestBody idStudio,
            @Part("tempat_duduk") RequestBody tempatduduk,
            @Part("action") RequestBody action
    );

    @Multipart
    @POST("studio/all")
    Call<GetStudio> deleteStudio(
            @Part("id_Studio") RequestBody idStudio,
            @Part("action") RequestBody action);


}
