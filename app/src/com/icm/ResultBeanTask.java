package com.icm;

import java.io.InputStreamReader;
import java.net.URL;

import android.os.AsyncTask;
import android.util.Log;

import com.google.gson.Gson;
import com.icm.pojo.ResultBean;

public class ResultBeanTask extends AsyncTask<URL, Void, ResultBean> {

	@Override
	protected ResultBean doInBackground(URL... params) {
		URL url = params[0];
		
		try {
	    	Gson gson = new Gson();
	    	return gson.fromJson(new InputStreamReader(url.openStream()), ResultBean.class);
		} catch (Exception e) {
			Log.e("ResultBeanTask", "Exception getting ResultBean", e);
		}

		
		// TODO Auto-generated method stub
		return null;
	}

}
