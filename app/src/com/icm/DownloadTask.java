package com.icm;

import java.io.InputStream;
import java.net.URL;

import android.graphics.drawable.Drawable;
import android.os.AsyncTask;

public class DownloadTask extends AsyncTask<URL, Void, Drawable> {

	@Override
	protected Drawable doInBackground(URL... params) {
		
		Drawable result = null;
		for(URL url : params)
		{
		    try {
		        InputStream is = (InputStream) url.getContent();
		        result = Drawable.createFromStream(is, "src");
		    } catch (Exception e) {
		    	result = null;
		    }
		}
		
		// TODO Auto-generated method stub
		return result;
	}

}
