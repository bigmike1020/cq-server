package com.icm;

import android.graphics.drawable.Drawable;
import android.os.Bundle;
import android.widget.ImageView;

import com.actionbarsherlock.app.SherlockActivity;
import com.icm.pojo.AnswerResultBean;
import com.icm.pojo.ImageBean;
import com.icm.util.GsonStuff;

public class AnswerActivity extends SherlockActivity {

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		
		String path = getIntent().getStringExtra("path");
		int id = getIntent().getIntExtra("id", 1);
		AnswerResultBean resultBean = GsonStuff.beanFromPictureId(id);
		
		ImageBean bean = new ImageBean();
		bean.path = path;
		Drawable drawable = bean.loadDrawable();
		
		ImageView imageView = (ImageView)findViewById(R.id.answer_imageView);
		imageView.setImageDrawable(drawable);
				
	}

}
