package avp.video.music;
/*
 * DjAmol Group Inc www.djamol.com
 * Author  : Amol V. Patil - admin@djamol.com
 */


import avp.video.music.db.view;
//import avp.video.music.dmgr2.activities.TrafficStatActivity;
import android.app.TabActivity;
import android.content.Intent;
import android.content.res.Resources;
import android.os.Bundle;
import android.widget.TabHost;
import android.widget.TabHost.TabSpec;

public class TABMAIN extends TabActivity {

	public void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);
		setContentView(R.layout.tab_main);

		Resources ressources = getResources(); 
		TabHost tabHost = getTabHost(); 
		
		// Setting Manager
		Intent intentAndroid = new Intent().setClass(this, Setting.class);
		TabSpec tabSpecAndroid = tabHost
			.newTabSpec("Setting")
			.setIndicator("", ressources.getDrawable(R.mipmap.tab_setting))
			.setContent(intentAndroid);

		// Bookmamrk Manager
		Intent intentApple = new Intent().setClass(this, view.class);
		TabSpec tabSpecApple = tabHost
			.newTabSpec("Bookmarks")
			.setIndicator("", ressources.getDrawable(R.mipmap.tab_bookmark))
			.setContent(intentApple);
		
		// Download Manager
		Intent intentWindows = new Intent().setClass(this, DownloadListActivity.class);
		TabSpec tabSpecWindows = tabHost
			.newTabSpec("Downloads")
			.setIndicator("", ressources.getDrawable(R.mipmap.tab_download))
			.setContent(intentWindows);
		
		// Blackberry tab
		Intent intentBerry = new Intent().setClass(this, Setting.class);
		TabSpec tabSpecBerry = tabHost
			.newTabSpec("About")
			.setIndicator("", ressources.getDrawable(R.mipmap.tab_about))
			.setContent(intentBerry);
	
		// add all tabs 
		tabHost.addTab(tabSpecAndroid);
		tabHost.addTab(tabSpecApple);
		tabHost.addTab(tabSpecWindows);
		tabHost.addTab(tabSpecBerry);
		
		//set default tab open... (zero based) 0,1,2,3
		tabHost.setCurrentTab(0);
	}

}