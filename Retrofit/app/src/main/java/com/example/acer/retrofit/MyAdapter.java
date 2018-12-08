package com.example.acer.retrofit;
import android.content.Intent;
import android.support.v7.widget.RecyclerView;
import android.support.v7.widget.RecyclerView.ViewHolder;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.TextView;
import java.util.List;

/**
 * Created by Acer on 06/11/2018.
 */

public class MyAdapter extends RecyclerView.Adapter<MyAdapter.MyViewHolder>
{
    List<Pembeli> mPembeliList;

    public MyAdapter(List<Pembeli> pembeliList)
    {
        mPembeliList = pembeliList;
    }

    @Override
    public MyAdapter.MyViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View mView = LayoutInflater.from(parent.getContext()).inflate(R.layout.list_pembeli,parent,false);
        MyViewHolder mViewHolder = new MyViewHolder(mView);
        return mViewHolder;
    }

    @Override
    public void onBindViewHolder(MyAdapter.MyViewHolder holder, final int position) {
        holder.mTextViewIdpembeli.setText("Id pembeli :  "+mPembeliList.get(position).getIdPembeli());
        holder.mTextViewIdTiket.setText("Id Tiket :  "+mPembeliList.get(position).getIdTiket());
        holder.mTextViewnama.setText("Nama :  "+mPembeliList.get(position).getNama());
        holder.mTextViewalamat.setText("Alamat :  "+mPembeliList.get(position).getAlamat());
        holder.mTextViewtelp.setText("Telp :  "+String.valueOf(mPembeliList.get(position).getTelp()));
        holder.itemView.setOnClickListener(new View.OnClickListener()
        {
            @Override
            public void onClick(View view)
            {
                Intent mIntent = new Intent(view.getContext(), LayarEditPembeli.class);
                mIntent.putExtra("id_pembeli",mPembeliList.get(position).getIdPembeli());
                mIntent.putExtra("id_tiket",mPembeliList.get(position).getIdTiket());
                mIntent.putExtra("nama",mPembeliList.get(position).getNama());
                mIntent.putExtra("alamat",mPembeliList.get(position).getAlamat());
                mIntent.putExtra("telp",String.valueOf(mPembeliList.get(position).getTelp()));
                view.getContext().startActivity(mIntent);
            }
        });
    }

    @Override
    public int getItemCount() {
        return mPembeliList.size();
    }

    public class MyViewHolder extends ViewHolder
    {
        public TextView mTextViewIdpembeli, mTextViewnama, mTextViewalamat,mTextViewIdTiket,mTextViewtelp;
        public MyViewHolder(View itemView)
        {
            super(itemView);
            mTextViewIdpembeli = (TextView) itemView.findViewById(R.id.tvIdPembelicontent);
            mTextViewIdTiket = (TextView) itemView.findViewById(R.id.tvtiketcontent);
            mTextViewnama = (TextView) itemView.findViewById(R.id.tvnamacontent);
            mTextViewalamat = (TextView) itemView.findViewById(R.id.tvalamatcontent);
            mTextViewtelp = (TextView) itemView.findViewById(R.id.tvtelpcontent);
        }
    }
}

