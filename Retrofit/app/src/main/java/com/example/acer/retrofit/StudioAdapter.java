package com.example.acer.retrofit;

import android.content.Intent;
import android.support.v7.widget.RecyclerView;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ImageView;
import android.widget.TextView;

import com.bumptech.glide.Glide;

import java.util.List;

public class StudioAdapter extends RecyclerView.Adapter<StudioAdapter.StudioViewHolder>  {
    List<Studio> listStudio;

    public StudioAdapter(List<Studio> listStudio) {
        this.listStudio = listStudio;
    }

    @Override
    public StudioAdapter.StudioViewHolder onCreateViewHolder(ViewGroup parent, int viewType) {
        View view = LayoutInflater.from(parent.getContext()).inflate(R.layout.list_studio, parent, false);
        StudioViewHolder mHolder = new StudioViewHolder(view);
        return mHolder;
    }

    @Override
    public void onBindViewHolder(StudioAdapter.StudioViewHolder holder, final int position) {

        holder.tvIdStudio.setText(listStudio.get(position).getIdStudio());
        holder.tvtempat.setText(listStudio.get(position).getTempatduduk());
        if (listStudio.get(position).getPhotoUrl() != null ){
//            Picasso.with(holder.itemView.getContext()).load(ApiClient.BASE_URL+listPembeli.get(position).getPhotoId())
//                    .into(holder.mPhotoURL);
            Glide.with(holder.itemView.getContext()).load(listStudio.get
                    (position).getPhotoUrl())
                    .into(holder.mPhotoURL);
        } else {
//          Picasso.with(holder.itemView.getContext()).load(R.drawable.photoid).into(holder
// .mPhotoURL);
            Glide.with(holder.itemView.getContext()).load(R.drawable.default_user).into(holder
                    .mPhotoURL);


        }
        holder.itemView.setOnClickListener(new View.OnClickListener() {
            @Override
            public void onClick(View view) {
                Intent in = new Intent(view.getContext(), LayarEditStudio.class);
                in.putExtra("id_studio",listStudio.get(position).getIdStudio());
                in.putExtra("tempat",listStudio.get(position).getTempatduduk());
                in.putExtra("photo_url",listStudio.get(position).getPhotoUrl());
                view.getContext().startActivity(in);
            }
        });
    }

    @Override
    public int getItemCount() {
        return listStudio.size();
    }

    public class StudioViewHolder extends RecyclerView.ViewHolder {
        ImageView mPhotoURL;
        TextView tvIdStudio, tvtempat;

        public StudioViewHolder(View itemView) {
            super(itemView);
            mPhotoURL = (ImageView) itemView.findViewById(R.id.imgStudio);
            tvIdStudio = (TextView) itemView.findViewById(R.id.tvIdStudio);
            tvtempat = (TextView) itemView.findViewById(R.id.tvTempatContent);

        }
    }

}
