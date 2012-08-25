package com.icm;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.ArrayAdapter;
import android.widget.ImageView;
import android.widget.ListAdapter;
import android.widget.TextView;

import com.actionbarsherlock.app.SherlockListActivity;
import com.actionbarsherlock.view.Menu;
import com.actionbarsherlock.view.MenuItem;

public class MainActivity extends SherlockListActivity {

    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        //setContentView(R.layout.activity_main);
        final Activity context = this;
        
        String array[] = { "Hello, World", "What's", "Up", "Ya'll" };
        ListAdapter adapter = new ArrayAdapter<String>(this, R.layout.table_main_row, array){
        	
        	@Override
			public View getView(int position, View convertView, ViewGroup parent) {
				View row = convertView;
				if (convertView == null) {
					LayoutInflater inflater = context.getLayoutInflater();
					row = inflater.inflate(R.layout.table_main_row, null);
					
					ImageView imageView = (ImageView) row.findViewById(R.id.row_imageView);
					imageView.setImageResource(R.drawable.ic_menu_camera);
				
					TextView textView = (TextView) row.findViewById(R.id.row_textView);
					textView.setText("Row " + position + " -- " + getItem(position));
					
				}
				return row;
				
			}
        	
        };
        
        
        setListAdapter(adapter);
        
    }
    
    

	@Override
	public boolean onCreateOptionsMenu(Menu menu) {
		final Context context = this;
        
		MenuItem item = menu.add("New");
		item.setIcon(R.drawable.ic_menu_camera);
		item.setShowAsAction(MenuItem.SHOW_AS_ACTION_WITH_TEXT | MenuItem.SHOW_AS_ACTION_ALWAYS);
		//item.setTitleCondensed("New");
		item.setOnMenuItemClickListener(new MenuItem.OnMenuItemClickListener() {
			public boolean onMenuItemClick(MenuItem item) {
				Intent intent = new Intent();
		        intent.setClass(context, TakePictureActivity.class);
		        startActivity(intent);
				return true;
			}
		});
		
		return super.onCreateOptionsMenu(menu);
	}

    
    
}
