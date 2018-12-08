package com.example.acer.retrofit;

import com.google.gson.annotations.SerializedName;

import java.util.ArrayList;
import java.util.List;

public class GetStudio {
    @SerializedName("status")
    private String status;
    @SerializedName("result")
    private List<Studio> result = new ArrayList<Studio>();
    @SerializedName("message")
    private String message;
    public GetStudio() {}

    public String getStatus() {
        return status;
    }

    public void setStatus(String status) {
        this.status = status;
    }

    public List<Studio> getResult() {
        return result;
    }

    public void setResult(List<Studio> result) {
        this.result = result;
    }

    public String getMessage() {
        return message;
    }

    public void setMessage(String message) {
        this.message = message;
    }
}
