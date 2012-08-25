package com.icm;


import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;
import java.util.concurrent.ExecutionException;

import org.apache.http.HttpResponse;
import org.apache.http.HttpVersion;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;
import org.apache.http.params.BasicHttpParams;
import org.apache.http.params.CoreProtocolPNames;
import org.apache.http.params.HttpParams;

import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.BitmapFactory;
import android.net.Uri;
import android.os.Bundle;
import android.provider.MediaStore;
import android.util.Base64;
import android.util.Log;
import android.view.View;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ImageView;
import android.widget.TextView;

import com.actionbarsherlock.app.SherlockActivity;
import com.actionbarsherlock.view.Menu;
import com.actionbarsherlock.view.MenuItem;

public class TakePictureActivity extends SherlockActivity {
	private static final int CAMERA_REQUEST = 1000;
	private static final int RESULT_LOAD_IMAGE = 1001;
	private ImageView imageView;
	private EditText questionText;
	private Button submitQuestion;
	private TextView errorText;
	private Bitmap uploadedImage;
	
	private DefaultHttpClient mHttpClient;
	
	@Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        
        uploadedImage = null;
        
        HttpParams params = new BasicHttpParams();
        params.setParameter(CoreProtocolPNames.PROTOCOL_VERSION, HttpVersion.HTTP_1_1);
        mHttpClient = new DefaultHttpClient(params);
        
        setContentView(R.layout.activity_takepicture);
		getSupportActionBar().setHomeButtonEnabled(true);
		getSupportActionBar().setDisplayHomeAsUpEnabled(true);
        this.imageView = (ImageView)this.findViewById(R.id.imageView1);
        this.questionText = (EditText)this.findViewById(R.id.textView);
        this.errorText = (TextView)this.findViewById(R.id.errorTextView);
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
        this.submitQuestion = (Button)this.findViewById(R.id.submitButton);
        submitQuestion.setOnClickListener(new View.OnClickListener() {
			@Override
			public void onClick(View v) {
				Upload();
				finish();
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
             
            setImageInView(BitmapFactory.decodeFile(picturePath));
        }
    
		if(requestCode == CAMERA_REQUEST) {
			setImageInView((Bitmap) data.getExtras().get("data"));
		}
	}
	
	private void setImageInView(Bitmap photo){
		imageView.setDrawingCacheEnabled(true);
		imageView.setImageBitmap(photo);
		imageView.buildDrawingCache(true);
		uploadedImage = Bitmap.createBitmap(imageView.getDrawingCache());
		imageView.setDrawingCacheEnabled(false);
		
        imageView.setVisibility(View.VISIBLE);
		questionText.setVisibility(View.VISIBLE);
		submitQuestion.setVisibility(View.VISIBLE);
		errorText.setVisibility(View.INVISIBLE);
	}
	
	public void Upload(){
		
		UploadArgs arg = new UploadArgs();
		arg.question = (String) questionText.getText().toString();
		arg.username = "Anonymous";
		arg.image = uploadedImage;
		
		UploadPictureTask task= new UploadPictureTask();
		Log.w("test", "before execute");
		task.execute(arg);
		Log.w("test", "after execute");
		this.finish();
	}

	@Override
	public boolean onOptionsItemSelected(MenuItem item) {
		if (item.getItemId() == android.R.id.home) {
			onBackPressed();
		}
		
		return true;
	}
}
