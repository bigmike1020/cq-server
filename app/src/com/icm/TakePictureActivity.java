package com.icm;


import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Bundle;
import android.provider.MediaStore;
import android.view.View;
import android.widget.Button;
import android.widget.ImageView;

import com.actionbarsherlock.app.SherlockActivity;
import com.actionbarsherlock.view.Menu;
import com.actionbarsherlock.view.MenuItem;

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
        Button cameraButton = (Button) this.findViewById(R.id.newPictureButton);
        cameraButton.setOnClickListener(new View.OnClickListener(){
			
			@Override
			public void onClick(View v) {
				Intent cameraIntent = new Intent(android.provider.MediaStore.ACTION_IMAGE_CAPTURE);
				startActivityForResult(cameraIntent, CAMERA_REQUEST);
			}
		});
        Button photoGalleryButton = (Button) this.findViewById(R.id.existingPictureButton);
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
		super.onActivityResult(requestCode, resultCode, data);
        
        if (requestCode == RESULT_LOAD_IMAGE && resultCode == RESULT_OK && null != data) {
            Uri selectedImage = data.getData();
            String[] filePathColumn = { MediaStore.Images.Media.DATA };
 
            Cursor cursor = getContentResolver().query(selectedImage,
                    filePathColumn, null, null, null);
            cursor.moveToFirst();
 
            int columnIndex = cursor.getColumnIndex(filePathColumn[0]);
            String picturePath = cursor.getString(columnIndex);
            cursor.close();
             
            imageView.setImageBitmap(BitmapFactory.decodeFile(picturePath));
            imageView.setVisibility(View.VISIBLE);
        }
    
		if(requestCode == CAMERA_REQUEST) {
			Bitmap photo = (Bitmap) data.getExtras().get("data");
			imageView.setImageBitmap(photo);
			imageView.setVisibility(View.VISIBLE);
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
