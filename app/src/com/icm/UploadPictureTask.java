package com.icm;

import java.io.ByteArrayOutputStream;
import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import org.apache.http.HttpResponse;
import org.apache.http.NameValuePair;
import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.entity.UrlEncodedFormEntity;
import org.apache.http.client.methods.HttpPost;
import org.apache.http.impl.client.DefaultHttpClient;
import org.apache.http.message.BasicNameValuePair;

import android.graphics.Bitmap;
import android.os.AsyncTask;
import android.util.Base64;
import android.util.Log;

public class UploadPictureTask extends AsyncTask<UploadArgs, Void, Void> {

	@Override
	protected Void doInBackground(UploadArgs... args) {
        Log.w("myApp", "0");
		UploadArgs arg = args[0];

        // Create a new HttpClient and Post Header
        Log.w("myApp", "1");
        HttpClient httpclient = new DefaultHttpClient();
        Log.w("myApp", "2");
        HttpPost httppost = new HttpPost("http://192.168.8.146/chunky/upload.php");
        Log.w("myApp", "3");

        try {
            // Add your data
            Log.w("myApp", "4");
            List<NameValuePair> nameValuePairs = new ArrayList<NameValuePair>(3);
            Log.w("myApp", "5");
            ByteArrayOutputStream bao = new ByteArrayOutputStream();
            Log.w("myApp", "6");
            arg.image.compress(Bitmap.CompressFormat.JPEG, 90, bao);
            Log.w("myApp", "7");
            byte [] ba = bao.toByteArray();
            Log.w("myApp", "8");
            int flags = Base64.NO_WRAP | Base64.URL_SAFE;
            Log.w("myApp", "9");
            String ba1=Base64.encodeToString(ba, flags);
            Log.w("myApp", "10");
            
            nameValuePairs.add(new BasicNameValuePair("file", ba1));
            Log.w("myApp", "11");
            nameValuePairs.add(new BasicNameValuePair("username", arg.username));
            Log.w("myApp", "12");
            nameValuePairs.add(new BasicNameValuePair("question", arg.question));
            Log.w("myApp", "13");
            httppost.setEntity(new UrlEncodedFormEntity(nameValuePairs));
            Log.w("myApp", "14");

            // Execute HTTP Post Request
            HttpResponse response = httpclient.execute(httppost);
            Log.w("myApp", "15");

        } catch (ClientProtocolException e) {
            // TODO Auto-generated catch block
            Log.w("myApp", "16");
        } catch (IOException e) {
            // TODO Auto-generated catch block
            Log.w("myApp", "16");
        }
        Log.w("myApp", "17");
        return null;
	}

}
