package com.icm;


import android.app.Activity;
import android.content.Intent;
import android.graphics.Bitmap;
import android.os.Bundle;

import com.actionbarsherlock.app.SherlockActivity;
import com.actionbarsherlock.view.Menu;
import com.actionbarsherlock.view.MenuItem;

import android.view.View;
import android.widget.Button;
import android.widget.ImageView;

public class TakePictureActivity extends SherlockActivity {
	private static final int CAMERA_REQUEST = 1000;
	private static final int RESULT_LOAD_IMAGE = 1001;
	private ImageView imageView;
	
	@Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_takepicture);
		getSupportActionBar().setHomeButtonEnabled(true);
		getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        this.imageView = (ImageView)this.findViewById(R.id.imageView1);
        Button cameraButton = (Button) this.findViewById(R.id.button1);
        cameraButton.setOnClickListener(new View.OnClickListener(){
			
			@Override
			public void onClick(View v) {
				Intent cameraIntent = new Intent(android.provider.MediaStore.ACTION_IMAGE_CAPTURE);
				startActivityForResult(cameraIntent, CAMERA_REQUEST);
			}
		});
        Button photoGalleryButton = (Button) this.findViewById(R.id.button2);
        photoGalleryButton.setOnClickListener(new View.OnClickListener(){
			
			@Override
			public void onClick(View v) {
				Intent cameraIntent = new Intent(Intent.ACTION_PICK, android.provider.MediaStore.Images.Media.EXTERNAL_CONTENT_URI);
				startActivityForResult(cameraIntent, RESULT_LOAD_IMAGE);
			}
		});
	}

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		return super.onCreateOptionsMenu(menu);
	}
	
	protected void onActivityResult(int requestCode, int resultCode, Intent data) {
		if(requestCode == CAMERA_REQUEST) {
			Bitmap photo = (Bitmap) data.getExtras().get("data");
			imageView.setImageBitmap(photo);
		}
	}

	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		if (item.getItemId() == android.R.id.home) {
			onBackPressed();
		}
		
		return true;
	}
}
