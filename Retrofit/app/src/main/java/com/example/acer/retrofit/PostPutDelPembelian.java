package com.example.acer.retrofit;
import com.google.gson.annotations.SerializedName;

/**
 * Created by Acer on 01/11/2018.
 */

public class PostPutDelPembelian {
    @SerializedName("status")
    String status;
    @SerializedName("result")
    Pembelian mPembelian;
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

    public Pembelian getPembelian()
    {
        return mPembelian;
    }

    public void setPembelian(Pembelian pembelian)
    {
        mPembelian = pembelian;
    }
}

