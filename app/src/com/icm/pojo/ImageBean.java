package com.icm.pojo;

import java.io.InputStream;
import java.net.URL;

import android.graphics.drawable.Drawable;


public class ImageBean {
	
	private static final String baseURL = "http://192.168.8.146/chunky/images/";

	public String user;
	public String path;
	public String question;
	
	public Drawable loadDrawable() {
	    try {
	        InputStream is = (InputStream) new URL(baseURL + path).getContent();
	        return Drawable.createFromStream(is, "src");
	    } catch (Exception e) {
	        return null;
	    }
	}
}
