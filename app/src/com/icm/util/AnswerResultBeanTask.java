package com.icm.util;

import java.io.InputStreamReader;
import java.net.URL;

import android.os.AsyncTask;
import android.util.Log;

import com.google.gson.Gson;
import com.icm.pojo.AnswerResultBean;

public class AnswerResultBeanTask extends
		AsyncTask<URL, Void, AnswerResultBean> {

	@Override
	protected AnswerResultBean doInBackground(URL... params) {
		URL url = params[0];
		
		try {
	    	Gson gson = new Gson();
	    	return gson.fromJson(new InputStreamReader(url.openStream()), AnswerResultBean.class);
		} catch (Exception e) {
			Log.e("ResultBeanTask", "Exception getting ResultBean", e);
		}

		
		// TODO Auto-generated method stub
		return null;
	}

}
