package com.example.acer.retrofit;
import com.google.gson.annotations.SerializedName;

import java.util.List;

/**
 * Created by Acer on 01/11/2018.
 */

public class GetPembelian {
    @SerializedName("status")
    String status;
    @SerializedName("result")
    List<Pembelian> listDataPembelian;
    @SerializedName("message")
    String message;


    public String getStatus()
    {
        return status;
    }

    public void setStatus(String status)
    {
        this.status = status;
    }

    public String getMessage()
    {
        return message;
    }

    public void setMessage(String message)
    {
        this.message = message;
    }

    public List<Pembelian> getListDataPembelien()
    {
        return listDataPembelian;
    }

    public void setListDataPembelien(List<Pembelian> listDataPembelien)
    {
        this.listDataPembelian = listDataPembelien;
    }
}
