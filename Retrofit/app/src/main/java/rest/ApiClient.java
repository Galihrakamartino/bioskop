package rest;

import retrofit2.Retrofit;
import retrofit2.converter.gson.GsonConverterFactory;
/**
 * Created by Acer on 01/11/2018.
 */

public class ApiClient {
    public static final String BASE_URL = "http://192.168.0.32:81/tugasandroid_api/index.php/";
    private static Retrofit retrofit = null;


    public static Retrofit getClient()
    {
        if (retrofit==null)
        {
            retrofit = new Retrofit.Builder()
                    .baseUrl(BASE_URL)
                    .addConverterFactory(GsonConverterFactory.create())
                    .build();
        }
        return retrofit;
    }
}
