package com.icm;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.View;

import com.actionbarsherlock.app.SherlockActivity;
import com.actionbarsherlock.view.Menu;

public class MainActivity extends SherlockActivity {

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        
        final Context context = this;
        
        findViewById(R.id.button1).setOnClickListener(
    		new View.OnClickListener() {
				public void onClick(View v) {

			        Intent intent = new Intent();
			        intent.setClass(context, TakePictureActivity.class);
			        startActivity(intent);
					
				}
		});
    }

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		
		return super.onCreateOptionsMenu(menu);
	}

    
    
}
