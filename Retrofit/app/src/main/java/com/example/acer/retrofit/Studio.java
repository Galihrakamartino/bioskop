package com.example.acer.retrofit;

import com.google.gson.annotations.SerializedName;

public class Studio {
    @SerializedName("id_studio")
    private String idStudio;
    @SerializedName("tempat_duduk")
    private String tempatduduk;
    @SerializedName("photo_url")
    private String photoUrl;
    private String action;

    public Studio(String idStudio, String tempatduduk, String photoUrl, String action) {
        this.idStudio = idStudio;
        this.tempatduduk = tempatduduk;
        this.photoUrl = photoUrl;
        this.action = action;
    }

    public String getIdStudio() {
        return idStudio;
    }

    public void setIdStudio(String idStudio) {
        this.idStudio = idStudio;
    }

    public String getTempatduduk() {
        return tempatduduk;
    }

    public void setTempatduduk(String tempatduduk) {
        this.tempatduduk = tempatduduk;
    }

    public String getPhotoUrl() {
        return photoUrl;
    }

    public void setPhotoUrl(String photoUrl) {
        this.photoUrl = photoUrl;
    }

    public String getAction() {
        return action;
    }

    public void setAction(String action) {
        this.action = action;
    }
}
