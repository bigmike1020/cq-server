package com.icm.pojo;


public class ResultBean {

	public ImageBean result[];
	public String error;
	
	/* 
	 * an example with the beans
	
		String json = null;
        Gson gson = new Gson();
        
        ImageBean bean = new ImageBean();
        bean.user = "my user";
        bean.path = "my path";
        bean.question = "my question";
        ResultBean result = new ResultBean();
        result.result = new ImageBean[]{bean};
        String gsonString = gson.toJson(result);
        Log.d("what", gsonString);
        
        ResultBean anotherBean = gson.fromJson(gsonString, ResultBean.class);
        Log.d("what again", gson.toJson(anotherBean));
        
	 */
}
