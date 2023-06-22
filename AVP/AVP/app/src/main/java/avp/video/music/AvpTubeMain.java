package avp.video.music;
/*
 * DjAmol Group Inc www.djamol.com
 * Author  : Amol V. Patil - admin@djamol.com
 * splashscreen.java verifydevice(); change package name, version code, and version name
*/
import java.io.ByteArrayOutputStream;
import java.io.File;
import java.io.FileOutputStream;
import java.io.IOException;
import java.io.InputStream;
import java.util.LinkedList;
import java.util.List;
import java.util.ListIterator;
import java.util.Locale;
import java.util.ArrayList;
import java.util.regex.Pattern;

import android.app.DownloadManager;
import android.app.DownloadManager.Request;


import android.annotation.SuppressLint;
import android.app.ActionBar;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.Notification;
import android.app.NotificationManager;
import android.app.PendingIntent;
import android.app.AlertDialog.Builder;
import android.app.Dialog;
import android.app.SearchManager;
import android.content.ActivityNotFoundException;
import android.content.Context;
import android.content.DialogInterface;
import android.content.SharedPreferences;
import android.content.DialogInterface.OnClickListener;
import android.content.Intent;
import android.database.Cursor;
import android.graphics.Bitmap;
import android.graphics.Color;
import android.graphics.drawable.ColorDrawable;
import android.net.ConnectivityManager;
import android.net.NetworkInfo;
import android.net.Uri;
import android.os.AsyncTask;
import android.os.Build;
import android.os.Bundle;
import android.os.Environment;
import android.preference.PreferenceManager;
import android.telephony.TelephonyManager;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.view.ViewGroup;
import android.view.Window;
import android.view.inputmethod.InputMethodManager;
import android.webkit.DownloadListener;
import android.webkit.WebChromeClient;
import android.webkit.WebIconDatabase;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import android.webkit.WebSettings.PluginState;
import android.widget.ArrayAdapter;
import android.widget.Button;
import android.widget.EditText;
import android.widget.FrameLayout;
import android.widget.ImageView;
import android.widget.ProgressBar;
import android.widget.SearchView;
import android.widget.TextView;
import android.widget.Spinner;
import android.widget.Toast;

//download manager import
import avp.video.music.player.PLAYER;
import avp.video.music.player.Video;

import org.apache.http.HttpResponse;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.entity.BufferedHttpEntity;
import org.apache.http.impl.client.DefaultHttpClient;


import djamol.com.lib.webview.*; //Webview Holder required


import djamol.com.lib.mob.BookmarkPageVariables; //For Bookmark HTML PAGE
import djamol.com.lib.mob.database; // Sqlite Database Access

//For Download Manager Function
import djamol.com.lib.dmgr.DownloadNotificationListener;
import djamol.com.lib.dmgr.DownloadTask;
import djamol.com.lib.dmgr.DownloadTaskManager;
import djamol.com.lib.dmgr.Res;
//For Download Manager (Second Version) Function
import djamol.com.lib.dmgr2.utils.MyIntents;
//For Custom Menu Icons menu
import djamol.com.lib.menu.*;
//admob
import djamol.com.lib.mob.ToastAdListener;

import com.google.android.gms.ads.AdRequest;
import com.google.android.gms.ads.AdView;
import com.google.android.youtube.player.YouTubeIntents;


public class AvpTubeMain extends Activity{
    //Activity implements ActionBar.OnNavigationListener
    private WebView webview;
    //Admob
    private AdView mAdView;

    private ProgressBar progressBar;
    private List<Link> historyStack;

    private ArrayAdapter<Link> dialogArrayAdapter;

    //private Button stopButton;

    //private ImageView faviconImageView;

    //QuickMEnu
    private static final int ID_HOME = 1;
    private static final int ID_VS   = 2;
    private static final int ID_SS   = 3;
    private static final int ID_DLOAD= 4;
    //	private static final int ID_STOP = 5;
//	private static final int ID_NEXT = 6;
    private static final int ID_BACK = 7;
    private static final int ID_HR   = 8;
    //	private static final int ID_Sbox = 9;
    private static final int ID_CUP = 10;
    private static final int ID_MORE =11;

    private AlertDialog levelDialog;
    private Button searchmenu;
    private Button searchmenu2;
    private Button keypad;
    private ArrayList<String> countryList;
    private ArrayList<String> countryValueList;
    private NotificationManager mNMapp;//minimizeapp
    Intent notificationIntent;//minimizeapp

    //snipper                //snipper menu searchview
    // action bar
    private ActionBar actionBar;
    // Title navigation Spinner data
    private ArrayList<SpinnerNavItem> navSpinner;
    // Navigation adapter
    private TitleNavigationAdapter adapter;




    //custom search
    Dialog custom1, custom2;
    EditText sbox; Spinner option, option2;
    Button btnSearch, btnCancel;
    //download manager
    private Context mContext;
    private static final String SDCARD = Environment.getExternalStorageDirectory().getPath()+ "/AvpTube";
    private static final Pattern urlPattern = Pattern.compile("^(https?|ftp|file)://(.*?)");
    //Database access
    private database mySQLiteAdapter;
    Cursor cursor;

    @SuppressLint({ "SetJavaScriptEnabled", "NewApi" })
    @Override
    public void onCreate(Bundle savedInstanceState)
    {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.main);
        historyStack = new LinkedList<Link>();
        final SharedPreferences prefs = PreferenceManager.getDefaultSharedPreferences(this);
        final String mydata = prefs.getString("avplang", null);
        webview = (WebView) findViewById(R.id.webkit);
        mNMapp = (NotificationManager)getSystemService(NOTIFICATION_SERVICE);//minimizeapp
        notificationIntent = new Intent(this, AvpTubeMain.class);  //minimizeapp
        //faviconImageView = (ImageView) findViewById(R.id.favicon);
        mContext = this;
        Res.getInstance(mContext);
        //Send Data Device
        //Log.d("Device ID",deviceId);Log.d("MANUFACTURER ID",manufacturer);Log.d("deviceName ID",deviceName);
       //Tracking Class
        ((AnalyticsApplication) getApplication()).getTracker(AnalyticsApplication.TrackerName.APP_TRACKER);
       //Event Tracking
       // ((AnalyticsApplication) getApplication()).trackEvent(AvpTubeMain.this, "MainActivity", "UX", "mybutton-click");


        //urlEditText = (EditText) findViewById(R.id.url);
        progressBar = (ProgressBar) findViewById(R.id.progressbar);

        mAdView = (AdView) findViewById(R.id.adView);
        mAdView.setAdListener(new ToastAdListener(this));
        mAdView.loadAd(new AdRequest.Builder().
                //addTestDevice("B3EEABB8EE11C2BE770B684D95219ECB").
                        build());

        //snipper start
        actionBar = getActionBar();
        //actionBar.setBackgroundDrawable(new ColorDrawable(Color.GRAY));
        ColorDrawable colorDrawable = new ColorDrawable(Color.parseColor("#01a9f2"));
        actionBar.setBackgroundDrawable(colorDrawable);
        // Hide the action bar title
        //actionBar.setDisplayShowTitleEnabled(false);

        // Title + Subtitle data
        actionBar.setTitle(getString(R.string.app_name));
        actionBar.setSubtitle("MENU");

	/*			
					
					//    Android ActionBAR Snipper Dropdown navigation Code
									
				// Enabling Menu dropdown navigation
				actionBar.setNavigationMode(ActionBar.NAVIGATION_MODE_LIST); //menu-item

				
				// Spinner title navigation data
				
				navSpinner = new ArrayList<SpinnerNavItem>();
				navSpinner.add(new SpinnerNavItem(getString(R.string.home), R.drawable.home));
				navSpinner.add(new SpinnerNavItem(getString(R.string.bm), R.drawable.tab_bookmark));
				navSpinner.add(new SpinnerNavItem(getString(R.string.download), R.drawable.tab_download));
				navSpinner.add(new SpinnerNavItem(getString(R.string.setting), R.drawable.tab_setting));
				
				// title drop down adapter
				adapter = new TitleNavigationAdapter(getApplicationContext(),
						navSpinner);
				
				// assigning the spinner navigation
				// required implement activity
				actionBar.setListNavigationCallbacks(adapter, this);
				//example : extend activity implements ActionBar.OnNavigationListener
				
				// Changing the action bar icon
				// actionBar.setIcon(R.drawable.ico_actionbar);
				
				//snipper End
*/




        //QuickMenu Start
        ActionItem hItem 	= new ActionItem(ID_HOME, getString(R.string.home), getResources().getDrawable(R.drawable.menuhome));
        ActionItem vItem 	= new ActionItem(ID_VS, getString(R.string.search_video), getResources().getDrawable(R.drawable.videobox));
        ActionItem sItem 	= new ActionItem(ID_SS, getString(R.string.search_song), getResources().getDrawable(R.drawable.musicbox));
        ActionItem dItem 	= new ActionItem(ID_DLOAD, getString(R.string.dload), getResources().getDrawable(R.drawable.menud));
        //ActionItem stItem 	= new ActionItem(ID_STOP, getString(R.string.stop), getResources().getDrawable(R.drawable.menu_info));
        //ActionItem nItem 	= new ActionItem(ID_NEXT, getString(R.string.forward), getResources().getDrawable(R.drawable.menu_info));
        ActionItem bItem 	= new ActionItem(ID_BACK, getString(R.string.back), getResources().getDrawable(R.drawable.menuback));
        ActionItem hrItem 	= new ActionItem(ID_HR, getString(R.string.bm), getResources().getDrawable(R.drawable.menuh));
        //ActionItem sbItem 	= new ActionItem(ID_Sbox, getString(R.string.searchbox), getResources().getDrawable(R.drawable.menu_info));
        ActionItem cItem 	= new ActionItem(ID_CUP, getString(R.string.share), getResources().getDrawable(R.drawable.check));
        ActionItem mItem 	= new ActionItem(ID_MORE, getString(R.string.more), getResources().getDrawable(R.drawable.option));


        //use setSticky(true) to disable QuickAction dialog being dismissed after an item is clicked
        //prevItem.setSticky(true);
        //nextItem.setSticky(true);

        //create QuickAction. Use QuickAction.VERTICAL or QuickAction.HORIZONTAL param to define layout
        //orientation
        final QuickAction quickAction = new QuickAction(this, QuickAction.VERTICAL);

        //add action items into QuickAction

        quickAction.addActionItem(hItem);
        quickAction.addActionItem(vItem);
        quickAction.addActionItem(sItem);
        quickAction.addActionItem(dItem);
        //quickAction.addActionItem(stItem);
        //quickAction.addActionItem(nItem);
        quickAction.addActionItem(hrItem);
        //quickAction.addActionItem(sbItem);
        quickAction.addActionItem(cItem);
        quickAction.addActionItem(mItem);


        //GET Extra From Previous Activity
		/*Intent intent = getIntent();
		  Bundle extras = intent.getExtras();
	      if(extras != null){
	      String data = extras.getString("keyName"); // retrieve the data using keyName 
	      Toast.makeText(AvpTubeMain.this, data, Toast.LENGTH_SHORT).show();
		  }
        */
        //Set listener for action item clicked
        quickAction.setOnActionItemClickListener(new QuickAction.OnActionItemClickListener() {
            @Override
            public void onItemClick(QuickAction source, int pos, int actionId) {
                ActionItem actionItem = quickAction.getActionItem(pos);

                //here we can filter which action item was clicked with pos or actionId parameter
                if (actionId == ID_HOME) {
                    String mydata = prefs.getString("avplang", null);if (mydata == null)
                    {webview.loadUrl("file:///android_asset/AvpTube-en.html");}else{
                        webview.loadUrl("file:///android_asset/AvpTube-"+mydata+".html");}
                    Toast.makeText(AvpTubeMain.this, R.string.msghome, Toast.LENGTH_SHORT).show();

                } else if (actionId == ID_VS) {

                    custom1 = new Dialog(AvpTubeMain.this,
                            android.R.style.Theme_Translucent);
                    custom1.requestWindowFeature(Window.FEATURE_NO_TITLE);
                    custom1.setCancelable(true);
                    custom1.setContentView(R.layout.search);
                    sbox = (EditText)custom1.findViewById(R.id.sbox);
                    option = (Spinner)custom1.findViewById(R.id.option);
                    btnSearch = (Button)custom1.findViewById(R.id.btnsearch);
                    btnCancel = (Button)custom1.findViewById(R.id.btncancel);
                    keypad = (Button)custom1.findViewById(R.id.keypad);
                    //custom1.setTitle("Custom Dialog");
                    keypad.setOnClickListener(new View.OnClickListener() {
                        @Override
                        public void onClick(View v) {
                            InputMethodManager imm = (InputMethodManager) getSystemService(Activity.INPUT_METHOD_SERVICE);
                            imm.toggleSoftInput(InputMethodManager.HIDE_IMPLICIT_ONLY, 0);                      }
                    });

                    btnSearch.setOnClickListener(new View.OnClickListener() {
                        @Override
                        public void onClick(View v) {
                            // TODO Auto-generated method stub
                            String sbox1 = sbox.getText().toString().trim();

                            Toast.makeText(AvpTubeMain.this,
                                    "Loading Wait : " + "\n Search : "+ sbox1 +
                                            "\n("+ String.valueOf(option.getSelectedItem())+") Result",
                                    Toast.LENGTH_SHORT).show();
                            //Get the instance of TelephonyManager
                            TelephonyManager  tm=(TelephonyManager)getSystemService(Context.TELEPHONY_SERVICE);
                            String operatornumber = tm.getNetworkOperator();
                            String operatorname = tm.getNetworkOperatorName();
                            String country=tm.getSimCountryIso();
                            //String simnumber=tm.getSimSerialNumber();
                            webview.loadUrl("http://mobile.djamol.com/android/tube/search.php?q="+ sbox1 +"&app=20&c="+country+"&onumber="+operatornumber+"&oname="+operatorname+"&map=1&ob="+ String.valueOf(option.getSelectedItemId()));

                            custom1.dismiss();
                        }
                    });
                    btnCancel.setOnClickListener(new View.OnClickListener() {
                        @Override
                        public void onClick(View view) {
                            // TODO Auto-generated method stub
                            custom1.dismiss();
                        }
                    });
                    custom1.show();
                    // Perform action on click
                    //Toast.makeText(getApplicationContext(), "Video Search box", Toast.LENGTH_SHORT).show();

                } else if (actionId == ID_SS) {//SEarch Song Box
                    custom2 = new Dialog(AvpTubeMain.this,
                            android.R.style.Theme_Translucent);
                    custom2.requestWindowFeature(Window.FEATURE_NO_TITLE);
                    custom2.setCancelable(true);
                    custom2.setContentView(R.layout.search2);
                    sbox = (EditText)custom2.findViewById(R.id.sbox);
                    option2 = (Spinner)custom2.findViewById(R.id.option2);
                    btnSearch = (Button)custom2.findViewById(R.id.btnsearch);
                    btnCancel = (Button)custom2.findViewById(R.id.btncancel);
                    keypad = (Button)custom2.findViewById(R.id.keypad);
                    //custom1.setTitle("Custom Dialog");
                    keypad.setOnClickListener(new View.OnClickListener() {
                        @Override
                        public void onClick(View v) {
                            InputMethodManager imm = (InputMethodManager) getSystemService(Activity.INPUT_METHOD_SERVICE);
                            imm.toggleSoftInput(InputMethodManager.HIDE_IMPLICIT_ONLY, 0);                      }
                    });

                    btnSearch.setOnClickListener(new View.OnClickListener() {
                        @Override
                        public void onClick(View v) {
                            // TODO Auto-generated method stub
                            String sbox1 = sbox.getText().toString().trim();

                            Toast.makeText(AvpTubeMain.this,
                                    "Loading Wait : " + "\n Music Search : "+ sbox1 +
                                            "\n("+ String.valueOf(option2.getSelectedItem())+") Result",
                                    Toast.LENGTH_SHORT).show();
                            //Get the instance of TelephonyManager
                            TelephonyManager  tm=(TelephonyManager)getSystemService(Context.TELEPHONY_SERVICE);
                            String operatornumber = tm.getNetworkOperator();
                            String operatorname = tm.getNetworkOperatorName();
                            String country=tm.getSimCountryIso();//String simnumber=tm.getSimSerialNumber();
                            webview.loadUrl("http://mobile.djamol.com/music/free/?q="+ sbox1 +"&c="+country+"&app=20&onumber="+operatornumber+"&oname="+operatorname+"&map=1&ob="+ String.valueOf(option2.getSelectedItemId()));

                            custom2.dismiss();
                        }
                    });
                    btnCancel.setOnClickListener(new View.OnClickListener() {
                        @Override
                        public void onClick(View view) {
                            // TODO Auto-generated method stub
                            custom2.dismiss();
                        }
                    });
                    custom2.show();
                    // Perform action on click
                } else if (actionId == ID_DLOAD) {
                    Toast.makeText(AvpTubeMain.this, R.string.go_to_downloading_list, Toast.LENGTH_SHORT).show();
                    Intent intent = new Intent(AvpTubeMain.this,DownloadListActivity.class);startActivity(intent);
                    //Intent i = new Intent(this, DownloadListActivity.class);
                    intent.putExtra(DownloadListActivity.DOWNLOADED, false);
                    startActivity(intent);

                } else if (actionId == ID_BACK) {
                    Toast.makeText(AvpTubeMain.this, R.string.msgback, Toast.LENGTH_SHORT).show();
                    webview.goBack();
                } else if (actionId == ID_HR) {
                    //ADD Bookmark
                    addBookmark();
                } else if (actionId == ID_CUP) {//Menu2 MORE oPTION
                    shareTextUrl(); //SHARE APP Links And Details
                } else if (actionId == ID_MORE) {//Menu2 MORE oPTION
                    AvpTubeMain.this.openOptionsMenu(); // activity's onCreateOptionsMenu gets called
                    //optionsMenu.performIdentifierAction(R.id.miSubMenu1, 0);
                }	else {
                    Toast.makeText(getApplicationContext(), actionItem.getTitle() + " selected", Toast.LENGTH_SHORT).show();
                }
            }
        });

        //set listnener for on dismiss event, this listener will be called only if QuickAction dialog was dismissed
        //by clicking the area outside the dialog.
        quickAction.setOnDismissListener(new QuickAction.OnDismissListener() {
            @Override
            public void onDismiss() {
                //Toast.makeText(getApplicationContext(), "Dismissed", Toast.LENGTH_SHORT).show();
            }
        });

        //show on btn1
        //  QuickMENU End
//searchmenu2


        searchmenu2 = ((Button) findViewById(R.id.searchmenu2));
        final Button searchmenu2 = (Button) findViewById(R.id.searchmenu2);
        searchmenu2.setOnClickListener(new View.OnClickListener() {
            public void onClick(View v) {
                quickAction.show(v);
                quickAction.setAnimStyle(QuickAction.ANIM_REFLECT);
            }
        });



        //favicon, deprecated since Android 4.3 but it's still necesary O_O ¿?
        WebIconDatabase.getInstance().open(getDir("icons", MODE_PRIVATE).getPath());

        // javascript and zoom
        webview.getSettings().setJavaScriptEnabled(true);
        webview.getSettings().setBuiltInZoomControls(true);


        if (Build.VERSION.SDK_INT >= Build.VERSION_CODES.FROYO)
        {
            webview.getSettings().setPluginState(PluginState.ON);
        }
        else
        {
            //IMPORTANT!! this method is no longer available since Android 4.3
            //so the code doesn't compile anymore
            //	webview.getSettings().setPluginsEnabled(true);
        }

        // downloads
        webview.setDownloadListener(new CustomDownloadListener());

        webview.setWebViewClient(new CustomWebViewClient());

        webview.setWebChromeClient(new WebChromeClient()
        {
            @Override
            public void onProgressChanged(WebView view, int progress)
            {
                progressBar.setProgress(0);
                FrameLayout progressBarLayout = (FrameLayout) findViewById(R.id.progressBarLayout);
                progressBarLayout.setVisibility(View.VISIBLE);
                AvpTubeMain.this.setProgress(progress * 1000);

                TextView progressStatus = (TextView) findViewById(R.id.progressStatus);
                progressStatus.setText(progress + " %");
                progressBar.incrementProgressBy(progress);

                if (progress == 100)
                {
                    progressBarLayout.setVisibility(View.GONE);
                }
            }

            @Override
            public void onReceivedTitle(WebView view, String title)
            {
                //AvpTubeMain.this.setTitle(getString(R.string.app_name) + " - " + AvpTubeMain.this.webview.getTitle());
                actionBar.setSubtitle(AvpTubeMain.this.webview.getTitle());

                for(Link link : historyStack)
                {
                    if (link.getUrl().equals(AvpTubeMain.this.webview.getUrl()))
                    {
                        link.setTitle(title);
                    }
                }
            }

            @Override
            public void onReceivedIcon(WebView view, Bitmap icon)
            {
                //faviconImageView.setImageBitmap(icon);
                view.getUrl();
                boolean b = false;
                ListIterator<Link> listIterator = historyStack.listIterator();
                while (!b && listIterator.hasNext())
                {
                    Link link = listIterator.next();
                    if (link.getUrl().equals(view.getUrl()))
                    {
                        link.setFavicon(icon);
                        b = true;
                    }
                }
            }

        });

        //http://stackoverflow.com/questions/2083909/android-webview-refusing-user-input
        webview.setOnTouchListener(new View.OnTouchListener()
        {
            @Override
            public boolean onTouch(View v, MotionEvent event)
            {
                switch (event.getAction())
                {
                    case MotionEvent.ACTION_DOWN:
                    case MotionEvent.ACTION_UP:
                        if (!v.hasFocus())
                        {
                            v.requestFocus();
                        }
                        break;
                }
                return false;
            }

        });
        if (savedInstanceState == null)
        {   //Welcome page loaded from assets directory
            if (mydata == null)
            {   String getlang = Locale.getDefault().getLanguage();
                SharedPreferences.Editor editor = prefs.edit();
                if (getlang.equals("es")||getlang.equals("fr")||getlang.equals("de")||getlang.equals("hi")||
                        getlang.equals("ru")||getlang.equals("ar"))
                {	//Set Avilalbe  Language in Strings
                    editor.putString("avplang", getlang);
                    webview.loadUrl("file:///android_asset/AvpTube-"+getlang+".html");
                }else{
                    //Set Language English
                    editor.putString("avplang", "en");
                    webview.loadUrl("file:///android_asset/AvpTube-en.html");
                }
                editor.commit();
                Log.d("Set Language",Locale.getDefault().getLanguage());
            }else{
                webview.loadUrl("file:///android_asset/AvpTube-"+mydata+".html");
                Log.d("Loaded Language",mydata);
            }
            webview.requestFocus();
        }

        //SettingDB.saveCurrentUsername("lang","Savedata"+Locale.getDefault().getLanguage());
        //String name = SettingDB.loadCurrentUsername("lang");
        //		Log.d("Data Loaded",name);
        if (prefs.getBoolean("micon",true))
        {searchmenu2.setVisibility(View.VISIBLE);}
        else{
            searchmenu2.setVisibility(View.GONE);}
        //Rating Box Google Play App Store Ration function
        //  RateApp.app_launched(this);
		
		/*
		if(!prefs.getBoolean("upnow", true))
        {
		//Display Custom Dialog 
		Update customizeDialog = new Update(this);
		customizeDialog.show();
        }
		*/



        // Custom Intent Own URL Scheme
        /**
         try {
         Uri data = getIntent().getData();
         if (data != null){//avptube://music/status/1234
         //int port = data.getPort(); //String scheme = data.getScheme(); // "avptube"
         String host = data.getHost(); // "twitter.com"or "music"
         List<String> params = data.getPathSegments();
         String first = params.get(0); // "status"
         String second = params.get(1); // "1234"
         if (host.equalsIgnoreCase("music"))
         {webview.loadUrl("http://mobile.djamol.com/music/free/"+first);
         }else{webview.loadUrl("http://mobile.djamol.com/android/"+first+"/"+second);}
         //Toast.makeText(AvpTubeMain.this, scheme+host+first+"/"+second+".html", Toast.LENGTH_SHORT).show();
         }} catch (NullPointerException e) {// TODO: handle exception
         }
         **/

    } //oncreate End
    @Override
    protected void onSaveInstanceState(Bundle outState)
    {
        super.onSaveInstanceState(outState);
        // Save the state of the WebView
        webview.saveState(outState);
    }

    @Override
    protected void onRestoreInstanceState(Bundle savedInstanceState)
    {
        super.onRestoreInstanceState(savedInstanceState);

        // Restore the state of the WebView
        webview.restoreState(savedInstanceState);
    }

    @Override
    protected Dialog onCreateDialog(int id)
    {
        AlertDialog.Builder builder = new AlertDialog.Builder(this);
        builder.setTitle(getString(R.string.history));
        builder.setPositiveButton(getString(R.string.clear), new OnClickListener()
        {
            @Override
            public void onClick(DialogInterface dialog, int which)
            {
                historyStack.clear();
            }
        });

        builder.setNegativeButton(R.string.close, null);

        dialogArrayAdapter = new ArrayAdapter<Link>(this, R.layout.history, historyStack)
        {
            @Override
            public View getView(int position, View convertView, ViewGroup parent)
            {
                //holder pattern
                LinkHolder holder = null;
                if (convertView == null)
                {
                    LayoutInflater inflater = (LayoutInflater) getSystemService(Context.LAYOUT_INFLATER_SERVICE);
                    convertView = inflater.inflate(R.layout.history, null);
                    holder = new LinkHolder();
                    holder.setUrl((TextView) convertView.findViewById(R.id.textView1));
                    holder.setImageView((ImageView) convertView.findViewById(R.id.favicon));

                    convertView.setTag(holder);
                }
                else
                {
                    holder = (LinkHolder) convertView.getTag();
                }

                Link link = historyStack.get(position);
                //show title when available
                if (link.getTitle() != null)
                {
                    holder.getUrl().setText(link.getTitle());
                }
                else
                {
                    String urlt = link.getUrl().replace("http://mobile.djamol.com/", "");
                    String urlt2 = urlt.replace("android", "");
                    holder.getUrl().setText(urlt2);
                }
                Bitmap favicon = link.getFavicon();
                if (favicon == null)
                {
                    holder.getImageView().setImageDrawable(super.getContext().getResources().getDrawable(R.drawable.favicon_default));
                }
                else
                {
                    holder.getImageView().setImageBitmap(favicon);
                }

                return convertView;
            }
        };

        builder.setAdapter(dialogArrayAdapter, new DialogInterface.OnClickListener()
        {
            public void onClick(DialogInterface dialog, int item)
            {
                webview.loadUrl(historyStack.get(item).getUrl());
                //	stopButton.setEnabled(true);
            }

        });

        return builder.create();
    }

    @Override
    protected void onPrepareDialog(int id, Dialog dialog)
    {
        dialogArrayAdapter.notifyDataSetChanged();
        super.onPrepareDialog(id, dialog);
    }

    // back button
    @Override
    public void onBackPressed()
    {
        if (webview.canGoBack())
        {
            webview.goBack();
        }
        else
        {
            super.onBackPressed();
        }
    }




    class CustomWebViewClient extends WebViewClient
    {
        // the current WebView will handle the url
        @Override
        public boolean shouldOverrideUrlLoading(WebView view, final String url)
        { 				//Get the instance of TelephonyManager
            TelephonyManager  tm=(TelephonyManager)getSystemService(Context.TELEPHONY_SERVICE);
            String operatornumber = tm.getNetworkOperator();
            String operatorname = tm.getNetworkOperatorName();
            String country=tm.getSimCountryIso();//String simnumber=tm.getSimSerialNumber();
            if (url.startsWith("market://"))
            { webview.loadUrl("http://mobile.djamol.com/android?c=" + country + "&app=20&onumber=" + operatornumber + "&oname=" + operatorname + "&error=market");
                ((AnalyticsApplication) getApplication()).trackEvent(AvpTubeMain.this, "Market","GPlay", url); // google AnalyticsApplication
            }
            if (url.startsWith("http://play.google"))
            { webview.loadUrl("http://mobile.djamol.com/android?c="+country+"&app=20&onumber="+operatornumber+"&oname="+operatorname+"&error=googleplay");
                ((AnalyticsApplication) getApplication()).trackEvent(AvpTubeMain.this, "URL-Play","http-Play", url); // google AnalyticsApplication
            }
            if (url.startsWith("https://play.google"))
            { webview.loadUrl("http://mobile.djamol.com/android?c="+country+"&app=20&onumber="+operatornumber+"&oname="+operatorname+"&error=httpsgoogle");
                ((AnalyticsApplication) getApplication()).trackEvent(AvpTubeMain.this, "URL-Play","https-Play", url); // google AnalyticsApplication
            }
            if (url.startsWith("play://"))
            {	String videoid = url.replace("play://", "");
                String version = YouTubeIntents.getInstalledYouTubeVersionName(getBaseContext());
                webview.stopLoading();
                if (version != null) {// installed ( not empty)
                    //Log.d("MainActivity", "Installed YouTube Version==" + version);
                    Intent i = new Intent(AvpTubeMain.this, PLAYER.class);
                    i.putExtra("video", videoid);
                    startActivity(i);
                }
                else {			// youtube not avilable
                    webview.loadData("<iframe class=\"youtube-player\" style=\"border: 0; width: 100%; height: 95%; padding:0px; margin:0px\" id=\"ytplayer\" type=\"text/html\" src=\"http://www.youtube.com/embed/"
                            + videoid
                            + "?fs=0\" frameborder=\"0\">\n</iframe>\n","text/html", "UTF-8");
                }

                ((AnalyticsApplication) getApplication()).trackEvent(AvpTubeMain.this, "FullScreen","PlayVideo", videoid); // google AnalyticsApplication
            }
            if (url.startsWith("rtsp"))
            { 				   	webview.stopLoading();
                Intent urlintent = new Intent(Intent.ACTION_VIEW, Uri.parse(url));
                try {
                    startActivity(urlintent);
                } catch (ActivityNotFoundException e) {
                    Toast.makeText(AvpTubeMain.this, "Sorry, Streaming Player Not Avilable in Your Device",
                            Toast.LENGTH_SHORT).show();
                }

                ((AnalyticsApplication) getApplication()).trackEvent(AvpTubeMain.this, "RTSP","Play", "Video-Streaming"); // google AnalyticsApplication
            }
            if (url.startsWith("about:"))
            {	String[] separated = url.split(":");	//separated[0]; // this will contain "about"
                String option = separated[1]; 			// this will contain "#option#"
                if (option.equalsIgnoreCase("bookmark"))
                {	Bookmark();		}
                else if (option.equalsIgnoreCase("video"))
                {
                    String videourl = "http://"+separated[2];
                    Intent i = new Intent(AvpTubeMain.this, Video.class);
                    i.putExtra("videourl", videourl);  startActivity(i);
                    webview.stopLoading();
                    ((AnalyticsApplication) getApplication()).trackEvent(AvpTubeMain.this, "Video-File-Play","VideoPlayer", url); // google AnalyticsApplication
                }else if (option.equalsIgnoreCase("svideo"))
                {
                    String videourl = "https://"+separated[2];
                    Intent i = new Intent(AvpTubeMain.this, Video.class);
                    i.putExtra("videourl", videourl);  startActivity(i);
                    webview.stopLoading();
                    ((AnalyticsApplication) getApplication()).trackEvent(AvpTubeMain.this, "Video-File-Play", "SecureVideoPlayer", url); // google AnalyticsApplication
                }

            }
            if (url.endsWith(".apk2"))
            { //webview.loadUrl(url.replace(".apk2", ".apk"));
                String apkString = url.replace(".apk2", ".apk");
                DownloadTask downloadTask4 = new DownloadTask(
                        apkString, SDCARD,
                        apkString.substring(apkString
                                .lastIndexOf("/")),
                        apkString.substring(apkString.lastIndexOf("/")), null);
                downloadTask4.setThumbnail("file:///android_asset/fileapk.png"); //use image file uri
                DownloadTaskManager.getInstance(mContext).registerListener(downloadTask4,
                        new DownloadNotificationListener(mContext, downloadTask4));
                DownloadTaskManager.getInstance(mContext).startDownload(downloadTask4);
                Toast.makeText(AvpTubeMain.this, R.string.dback, Toast.LENGTH_SHORT).show();

                webview.stopLoading();
                ((AnalyticsApplication) getApplication()).trackEvent(AvpTubeMain.this, "APK-Allow","FILE-Apk2", url); // google AnalyticsApplication
            }

            if (url.endsWith(".apk"))
            { webview.loadUrl("http://mobile.djamol.com/android?error=apk&app=20");
                ((AnalyticsApplication) getApplication()).trackEvent(AvpTubeMain.this, "APK","FILE", url); // google AnalyticsApplication
            }
            if (url.endsWith(".mp3") || url.endsWith(".aac"))
            {
                AlertDialog.Builder builder = new AlertDialog.Builder(AvpTubeMain.this);

                builder.setTitle(getString(R.string.mdetect));
                builder.setMessage(getString(R.string.mediaq) + "\n" + getString(R.string.selctdm));
                builder.setCancelable(false)
                        .setPositiveButton((R.string.avpdm), new DialogInterface.OnClickListener()
                        {
                            public void onClick(DialogInterface dialog, int id)
                            {
                                //new DownloadAsyncTask().execute(url);
                                //String urlname =url.substring(url.lastIndexOf("/")).replace("%20", " ");
                                DownloadTask downloadTask4 = new DownloadTask(
                                        url, SDCARD,
                                        url.substring(url.lastIndexOf("/")),
                                        url.substring(url.lastIndexOf("/")), null);
                                downloadTask4.setThumbnail("file:///android_asset/download.png"); //use image file uri
                                DownloadTaskManager.getInstance(mContext).registerListener(downloadTask4,
                                        new DownloadNotificationListener(mContext, downloadTask4));
                                DownloadTaskManager.getInstance(mContext).startDownload(downloadTask4);
                                Toast.makeText(AvpTubeMain.this, R.string.dback, Toast.LENGTH_SHORT).show();
                            }

                        }).setNegativeButton((R.string.play), new DialogInterface.OnClickListener()
                {
                    public void onClick(DialogInterface dialog, int id)
                    {
                        Intent intent = new Intent(Intent.ACTION_VIEW);
                        intent.setDataAndType(Uri.parse(url),"audio/mpeg");
                        startActivity(intent);

                    }

                }).setNeutralButton((R.string.adm), new DialogInterface.OnClickListener()
                {
                    public void onClick(DialogInterface dialog, int id)
                    {
                        String servicestring = Context.DOWNLOAD_SERVICE;
                        DownloadManager downloadmanager;
                        downloadmanager = (DownloadManager) getSystemService(servicestring);
                        Uri uri = Uri.parse(url);
                        DownloadManager.Request request = new Request(uri);
                        request.setAllowedNetworkTypes(
                                DownloadManager.Request.NETWORK_WIFI
                                        | DownloadManager.Request.NETWORK_MOBILE)
                                .setDestinationInExternalPublicDir("/AvpTube/",uri.getLastPathSegment());
                        Long reference = downloadmanager.enqueue(request);
                        dialog.cancel();

                    }

                });


                builder.create().show();
                return true;
            }
            return false;
        }

        // history and navigation buttons
        @Override
        public void onPageStarted(WebView view, String url, Bitmap favicon)
        {
            if (checkConnectivity())
            {
                //resets favicon
                //resets favicon
                //AvpTubeMain.this.faviconImageView.setImageDrawable(AvpTubeMain.this.getResources().getDrawable(R.drawable.favicon_default));
                // shows the current url ( Search Box/ Enter URL Box Web Address Show)
                //String url1 = "AvpTube/"+url.substring(32);
                //AvpTubeMain.this.urlEditText.setText(url1);
                //((AnalyticsApplication) getApplication()).trackEvent(AvpTubeMain.this, "WEB",
                //		"URL", url); // google AnalyticsApplication

                //only one occurrence
                boolean b = false;
                ListIterator<Link> listIterator = historyStack.listIterator();
                while (listIterator.hasNext() && !b)
                {
                    if (listIterator.next().getUrl().equals(url))
                    {
                        b = true;
                        listIterator.remove();
                    }
                }
                Link link = new Link(url, favicon);
                historyStack.add(0, link);

                //stopButton.setEnabled(true);
                //updateButtons();
            }
        }

        //@Override
        //public void onPageFinished(WebView view, String url)
        //{
        //	stopButton.setEnabled(false);
        //	updateButtons();
        //}

        // handles unrecoverable errors
        @Override
        public void onReceivedError(WebView view, int errorCode, String description, String failingUrl)
        {			 Log.e(String.valueOf(errorCode), description);

            // API level 5: WebViewClient.ERROR_HOST_LOOKUP
            // if (errorCode == -2) {
            AlertDialog.Builder builder = new AlertDialog.Builder(AvpTubeMain.this);
            builder.setMessage(description).setPositiveButton((R.string.ok), null).setTitle("Error");
            builder.show();
            view.loadUrl("file:///android_asset/error.html");
            return;
        }

    }


    public void go(View view)
    {
        // hides the keyboard
        InputMethodManager inputMethodManager = (InputMethodManager) getSystemService(INPUT_METHOD_SERVICE);
        //inputMethodManager.hideSoftInputFromWindow(urlEditText.getWindowToken(), 0);

        if (checkConnectivity())
        {
            //stopButton.setEnabled(true);

            //http protocol by default
        }
    }

    public void back(View view)
    {
        if (checkConnectivity())
        {
            webview.goBack();
        }
    }

    public void forward(View view)
    {
        if (checkConnectivity())
        {
            webview.goForward();
        }
    }

    public void stop(View view)
    {
        webview.stopLoading();
        Toast.makeText(this, getString(R.string.stopping), Toast.LENGTH_LONG).show();
    }

    public void history(View view)
    {
        showDialog(0);
    }





    // DOWNLOAD MANAGER WITH ASYNCTASK

    class CustomDownloadListener implements DownloadListener
    {
        public void onDownloadStart(final String url, String userAgent,  String contentDisposition, String mimetype, long contentLength)
        {
/*
   url(url link) , useragent (browser useragent),
mimetype (file type content ) eg. ﹕ video/x-flv
 contentdisposition(attachment filename ) Example attachment; filename="Avptube.com_Britney-Spears-Iggy-Azalea---Pretty-Girls.flv"
 */


            AlertDialog.Builder builder = new AlertDialog.Builder(AvpTubeMain.this);
            builder.setTitle(getString(R.string.download));
            //builder.setMessage(getString(R.string.question));
            builder.setMessage(getString(R.string.question) + "\n" + getString(R.string.selctdm));

            builder.setCancelable(false)
                    .setPositiveButton((R.string.avpdm), new DialogInterface.OnClickListener()
                    {
                        public void onClick(DialogInterface dialog, int id)
                        {
//                            new DownloadAsyncTask().execute(url);
                            GETDLINK(url);

                        }

                    }).setNegativeButton((R.string.cancel), new DialogInterface.OnClickListener()
            {
                public void onClick(DialogInterface dialog, int id)
                {
                    dialog.cancel();
                }
            }).setNeutralButton((R.string.adm), new DialogInterface.OnClickListener()
            {
                public void onClick(DialogInterface dialog, int id)
                {
                    String servicestring = Context.DOWNLOAD_SERVICE;
                    DownloadManager downloadmanager;
                    downloadmanager = (DownloadManager) getSystemService(servicestring);
                    Uri uri = Uri.parse(url);
                    DownloadManager.Request request = new Request(uri);
                    request.setAllowedNetworkTypes(
                            DownloadManager.Request.NETWORK_WIFI
                                    | DownloadManager.Request.NETWORK_MOBILE)
                            .setDestinationInExternalPublicDir("/AvpTube/",uri.getLastPathSegment());
                    Long reference = downloadmanager.enqueue(request);

                }

            });



            builder.create().show();

        }

    }
    private class DownloadAsyncTask extends AsyncTask<String, Void, String>
    {

        @Override
        protected String doInBackground(String... arg0)
        {
            String result = "";
            String url = arg0[0];

            if (Environment.getExternalStorageState().equals(Environment.MEDIA_MOUNTED))
            {
                HttpClient httpClient = new DefaultHttpClient();
                HttpGet httpGet = new HttpGet(url);
                InputStream inputStream = null;
                FileOutputStream fileOutputStream = null;
                try
                {
                    HttpResponse httpResponse = httpClient.execute(httpGet);

                    BufferedHttpEntity bufferedHttpEntity = new BufferedHttpEntity(httpResponse.getEntity());

                    inputStream = bufferedHttpEntity.getContent();

                    String fileName = android.os.Environment.getExternalStorageDirectory().getAbsolutePath() + "/AvpTube";
                    File directory = new File(fileName);
                    File file = new File(directory, url.substring(url.lastIndexOf("/")));
                    directory.mkdirs();

                    // commons-io, I miss you :(
                    fileOutputStream = new FileOutputStream(file);
                    ByteArrayOutputStream byteArrayOutputStream = new ByteArrayOutputStream();
                    byte[] buffer = new byte[1024];
                    int len = 0;

                    while (inputStream.available() > 0 && (len = inputStream.read(buffer)) != -1)
                    {
                        byteArrayOutputStream.write(buffer, 0, len);
                    }

                    fileOutputStream.write(byteArrayOutputStream.toByteArray());
                    fileOutputStream.flush();

                    result = getString(R.string.result) + file.getAbsolutePath();
                }
                catch (Exception ex)
                {
                    Log.e(AvpTubeMain.class.toString(), ex.getMessage(), ex);
                    result = ex.getClass().getSimpleName() + " " + ex.getMessage();
                }
                finally
                {
                    if (inputStream != null)
                    {
                        try
                        {
                            inputStream.close();
                        }
                        catch (IOException ex)
                        {
                            Log.e(AvpTubeMain.class.toString(), ex.getMessage(), ex);
                            result = ex.getClass().getSimpleName() + " " + ex.getMessage();
                        }
                    }
                    if (fileOutputStream != null)
                    {
                        try
                        {
                            fileOutputStream.close();
                        }
                        catch (IOException ex)
                        {
                            Log.e(AvpTubeMain.class.toString(), ex.getMessage(), ex);
                            result = ex.getClass().getSimpleName() + " " + ex.getMessage();
                        }
                    }
                }
            }
            else
            {
                result = getString(R.string.nosd);
            }

            return result;
        }

        @Override
        protected void onPostExecute(String result)
        {
            AlertDialog.Builder builder = new AlertDialog.Builder(AvpTubeMain.this);
            builder.setMessage(result).setPositiveButton((R.string.ok), null).setTitle(getString(R.string.download));
            builder.show();

        }

    }


    // AnalyticsApplication Google
    @Override
    public void onStart() {
        super.onStart();
        ((AnalyticsApplication) getApplication()).reportActivityStart(this);
    }

    public void DownloaderOption() {
        // TODO Auto-generated method stub

    }
    @Override
    public void onStop() {
        super.onStop();
        ((AnalyticsApplication) getApplication()).reportActivityStop(this);
    }
    private void showNotification(Context context) {  //minimizeapp notification
        NotificationManager notificationManager
                = (NotificationManager)context.getSystemService(Context.NOTIFICATION_SERVICE);
        Notification.Builder builder = new Notification.Builder(context);
        Intent intent = new Intent(context, AvpTubeMain.class);
        PendingIntent pendingIntent
                = PendingIntent.getActivity(context, 0, intent, 0);

        builder
                .setSmallIcon(R.drawable.ic_launcher)
                .setContentTitle("AvpTube is Minimized")
                .setContentText("DjAmol Group")
                .setContentInfo("Play")
                .setTicker("Ticker")
                .setLights(0xFFFF0000, 500, 500) //setLights (int argb, int onMs, int offMs)
                .setContentIntent(pendingIntent)
                .setAutoCancel(true);

        Notification notification = builder.getNotification();

        notificationManager.notify(R.drawable.ic_launcher, notification);
    }

    /*
     * Method to share either text or URL.
     */
    private void shareTextUrl() {
        Intent share = new Intent(android.content.Intent.ACTION_SEND);
        share.setType("text/plain");
        share.addFlags(Intent.FLAG_ACTIVITY_CLEAR_WHEN_TASK_RESET);

        // Add data to the intent, the receiving app will decide
        // what to do with it.
        share.putExtra(Intent.EXTRA_SUBJECT, "MirchiTube Unlimited Music & Video");
        share.putExtra(Intent.EXTRA_TEXT, "Video And Music Search , Play, Download And More \n" +
                "http://AvpTube.Com" +
                "\n\n http://avptube.com/AvpTube.apk " +
                "\n FB : http://facebook.com/AvpTube " +
                "\n Twitter : http://Twitter.com/AvpTube");

        startActivity(Intent.createChooser(share, "Share App!"));
    }

			/*
			 * Method to share any image.
			 
			private void shareImage() {
				Intent share = new Intent(Intent.ACTION_SEND);
					// If you want to share a png image only, you can do:
					// setType("image/png"); OR for jpeg: setType("image/jpeg");
				share.setType("image/*");
					// Make sure you put example png image named myImage.png in your
					// directory
				String imagePath = Environment.getExternalStorageDirectory()
						+ "/myImage.png";
				File imageFileToShare = new File(imagePath);
				Uri uri = Uri.fromFile(imageFileToShare);
				share.putExtra(Intent.EXTRA_STREAM, uri);
				startActivity(Intent.createChooser(share, "Share Image!"));}
			 */

    //download manager
    public static boolean isNetWorkOn(Context context) {
        ConnectivityManager cManager = (ConnectivityManager) context
                .getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo info = cManager.getActiveNetworkInfo();
        if (info != null && info.isAvailable()) {
            info.getTypeName();
            return true;
        } else {
            return false;
        }
    }

    /* Initiating Menu XML file (menu.xml) */
    @Override
    public boolean onCreateOptionsMenu(Menu menu)
    {
        MenuInflater inflater = getMenuInflater();
        inflater.inflate(R.menu.menu, menu);

        // Associate searchable configuration with the SearchView
        SearchManager searchManager = (SearchManager) getSystemService(Context.SEARCH_SERVICE);
        final SearchView searchView = (SearchView) menu.findItem(R.id.action_search)
                .getActionView();
        searchView.setSearchableInfo(searchManager
                .getSearchableInfo(getComponentName()));
        SearchView.OnQueryTextListener queryTextListener = new SearchView.OnQueryTextListener() {
            public boolean onQueryTextChange(String newText) {
                // this is your adapter that will be filtered
                return true;
            }

            public boolean onQueryTextSubmit(String query) {
                webview.loadUrl("http://mobile.djamol.com/android/tube/search.php?app=15&q="+query+"&on=actionbar");
                searchView.setIconified(true);
                searchView.clearFocus();
                searchView.onActionViewCollapsed();  //collapse your ActionView
                //hide action bar
                //searchView.setVisibility(View.INVISIBLE);
                return true;
            }
        };
        searchView.setOnQueryTextListener(queryTextListener);

        return super.onCreateOptionsMenu(menu);
    }

    /**
     * Event Handling for Individual menu item selected
     * Identify single menu item by it's id
     * */
    @Override
    public boolean onOptionsItemSelected(MenuItem item)
    {
        switch (item.getItemId())
        {
            case R.id.menu_back:
                Toast.makeText(AvpTubeMain.this, R.string.msgback, Toast.LENGTH_SHORT).show();
                webview.goBack();
                return true;
            case R.id.menu_home:
                SharedPreferences prefs = PreferenceManager.getDefaultSharedPreferences(this);
                String mydata = prefs.getString("avplang", null);if (mydata == null)
            {webview.loadUrl("file:///android_asset/AvpTube-en.html");}else{
                webview.loadUrl("file:///android_asset/AvpTube-"+mydata+".html");}
                Toast.makeText(AvpTubeMain.this, R.string.msghome, Toast.LENGTH_SHORT).show();
                return true;
            case R.id.menu_forward:
                Toast.makeText(AvpTubeMain.this, R.string.msgforward, Toast.LENGTH_SHORT).show();
                webview.goForward();
                return true;
            case R.id.menu_dload:
                //Intent intent = new Intent(AvpTubeMain.this,DownloadListActivity.class);startActivity(intent);
                Toast.makeText(this, R.string.go_to_downloading_list, Toast.LENGTH_SHORT).show();
                Intent i = new Intent(this, DownloadListActivity.class);
                i.putExtra(DownloadListActivity.DOWNLOADED, false);
                startActivity(i);
                //Toast.makeText(AvpTubeMain.this, "DirectApps Group", Toast.LENGTH_SHORT).show();
                return true;

            case R.id.menu_about:

                custom1 = new Dialog(AvpTubeMain.this,
                        android.R.style.Theme_Translucent);
                custom1.requestWindowFeature(Window.FEATURE_NO_TITLE);
                custom1.setCancelable(true);
                custom1.setContentView(R.layout.about);
                btnSearch = (Button)custom1.findViewById(R.id.ok);
                //custom1.setTitle("Custom Dialog");
                btnSearch.setOnClickListener(new View.OnClickListener() {
                    @Override
                    public void onClick(View v) {

                        custom1.dismiss();
                    }
                });
                custom1.show();
                return true;

            case R.id.menu_history:
                //Toast.makeText(AvpTubeMain.this, "History Page Open", Toast.LENGTH_SHORT).show();
                showDialog(0);
                return true;
            case R.id.menu_setting:
                Intent myIntent = new Intent(getBaseContext(),
                        TABMAIN.class);
                startActivity(myIntent);


                return true;
			    /*case R.id.menu_searchbox:
			    	// Strings to Show In Dialog with Radio Buttons
			    	final CharSequence[] items2 = {getString(R.string.hmi),getString(R.string.smi),getString(R.string.mci)};
			    	                // Creating and Building the Dialog
			    	                AlertDialog.Builder builder2 = new AlertDialog.Builder(AvpTubeMain.this);
			    	                builder2.setTitle(R.string.sbm);builder2.setSingleChoiceItems(items2, -1, new DialogInterface.OnClickListener() {
			    	                public void onClick(DialogInterface dialog, int item) {
										switch(item){
			    	                       case 0:
			    	                    	   searchmenu2.setVisibility(View.GONE);
				    	            	   break;
			    	                       case 1:
			    	                    	   searchmenu2.setVisibility(View.VISIBLE);
				    	                   break;
			    	                       case 2:
			    	                    	break;
			    	                   }
										levelDialog.dismiss();}
			    	                });
			    	                levelDialog = builder2.create();levelDialog.show();
			    	return true;
			    */

            case R.id.menu_chkup:
                // Check Update

                // Strings to Show In Dialog with Radio Buttons
                final CharSequence[] items3 = {"AvpTube Manager","DM Manager 2"};

                // Creating and Building the Dialog
                AlertDialog.Builder builder3 = new AlertDialog.Builder(this);
                builder3.setTitle(R.string.chkup);
                builder3.setSingleChoiceItems(items3, -1, new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int item) {

                        switch(item)
                        {
                            case 0:
                                DownloadTask downloadTask5 = new DownloadTask(
                                        "http://avptube.com/AvpTube.apk", SDCARD,
                                        "AvpTube.apk", "AvpTube App", null);
                                downloadTask5.setThumbnail("file:///android_asset/fileapk.png"); //use image file uri
                                DownloadTaskManager.getInstance(mContext).registerListener(downloadTask5,
                                        new DownloadNotificationListener(mContext, downloadTask5));
                                DownloadTaskManager.getInstance(mContext).startDownload(downloadTask5);
                                Toast.makeText(AvpTubeMain.this, R.string.dback, Toast.LENGTH_SHORT).show();

                                break;
                            case 1:
                                Intent downloadIntent = new Intent("djamol.com.lib.dmgr2.services.IDownloadService");
                                downloadIntent.putExtra(MyIntents.TYPE, MyIntents.Types.ADD);
                                downloadIntent.putExtra(MyIntents.URL, "http://avptube.com/AvpTube.apk");
                                startService(downloadIntent);
                                //Download lIst Process details
                                Intent intent = new Intent(AvpTubeMain.this,avp.video.music.activities.DownloadListActivity.class);
                                startActivity(intent);

                                break;

                        }

                        levelDialog.dismiss();
                    }
                });
                levelDialog = builder3.create();
                levelDialog.show();
                return true;

            case R.id.menu_stop:
                //	webview.goForward();
                webview.stopLoading();
                return true;

            case R.id.menu_exit:
                final CharSequence[] exitapp = {getString(R.string.minapp),getString(R.string.exiapp)};

                // Creating and Building the Dialog
                AlertDialog.Builder bdexit = new AlertDialog.Builder(this);
                bdexit.setTitle(R.string.exitapp);
                bdexit.setSingleChoiceItems(exitapp, -1, new DialogInterface.OnClickListener() {
                    public void onClick(DialogInterface dialog, int item) {

                        switch(item)
                        {
                            case 0:
                                showNotification(mContext);
                                Intent startMain = new Intent(Intent.ACTION_MAIN);
                                startMain.addCategory(Intent.CATEGORY_HOME);
                                startMain.setFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
                                startActivity(startMain);

                                break;
                            case 1:

                                Intent j=new Intent(Intent.ACTION_MAIN);
                                j.addCategory(Intent.CATEGORY_HOME);
                                j.setFlags(Intent.FLAG_ACTIVITY_CLEAR_TOP);
                                startActivity(j);
                                finish();
                                System.exit(0);
                                //finish();
                                // System.exit(0);
                                break;

                        }

                        levelDialog.dismiss();
                    }
                });
                levelDialog = bdexit.create();
                levelDialog.show();
                return true;
            default:
                return super.onOptionsItemSelected(item);
        }
    }

public void GETDLINK(String url){
    String fileName1 = url.substring(url.lastIndexOf('/') + 1).split("\\?")[0].split("#")[0];  // remove also get tag ?,# symbol after value
    //fileName =  urlString.substring(urlString.lastIndexOf("/")); //last slash name filter
    String fileName = url.substring(url.lastIndexOf('/') + 1).split("\\?")[0].split("#")[0].split("&")[0];  // remove also get tag ?,#,& symbol after value

    //Log.d("CustomLog", fileName);
    //Log.d("CustomLog Filename1", fileName1);
    //Log.d("CustomLog URL", url);
        //new DownloadAsyncTask().execute(url);
    try{
        DownloadTask downloadTask4 = new DownloadTask(
                url, SDCARD, fileName, fileName, null);
    downloadTask4.setThumbnail("file:///android_asset/download.png"); //use image file uri
        DownloadTaskManager.getInstance(mContext).registerListener(downloadTask4,
                new DownloadNotificationListener(mContext, downloadTask4));
        DownloadTaskManager.getInstance(mContext).startDownload(downloadTask4);
    Toast.makeText(AvpTubeMain.this, R.string.dback, Toast.LENGTH_SHORT).show();
       // Log.d("CustomLog", "Run DownloadTask");
    } catch (Exception e) {
        e.printStackTrace();
        Log.d("CustomLog error", "error");
    }

}
    private void Bookmark() {
        //required access database
        mySQLiteAdapter = new database(this);
        mySQLiteAdapter.openToWrite();
        cursor = mySQLiteAdapter.queueAll();
        StringBuilder sb1=new StringBuilder();
        if (cursor.moveToFirst()) {
            do {
                String title = cursor.getString(cursor.getColumnIndex("sid"));//title
                String url = cursor.getString(cursor.getColumnIndex("sname"));//url
                // text1.setText(sb1)
                //System.out.println("string = " + sb2);
                sb1.append(BookmarkPageVariables.Part1);
                sb1.append(url+BookmarkPageVariables.Part2);
                sb1.append(url+BookmarkPageVariables.Part3);
                sb1.append(title);
            } while (cursor.moveToNext());

        }

        webview.loadData(BookmarkPageVariables.Heading+sb1
                +BookmarkPageVariables.End,"text/html", "UTF-8");
        ((AnalyticsApplication) getApplication()).trackEvent(AvpTubeMain.this, "Bookmark", "OfflinePage", "Bookmark"); // google AnalyticsApplication
    }
    private void addBookmark() {
        if(webview.getUrl().startsWith("http://mobile.djamol.com"))
        {
            String tt = webview.getTitle();
            String tt2;
            if (tt != null)
            {tt2 = webview.getTitle();}else{
                tt2 = "No Title....";}

            String uu =webview.getUrl();//	String uu =webview.getUrl().replace("http://mobile.djamol.com/", "");
            //required access database
            mySQLiteAdapter = new database(this);
            mySQLiteAdapter.openToWrite();
            cursor = mySQLiteAdapter.queueAll();
            //insert row in database
            mySQLiteAdapter.insert(tt2, uu,"bookmark");
            Toast.makeText(AvpTubeMain.this, "Bookmark Added", Toast.LENGTH_SHORT).show();

        }else{
            Toast.makeText(AvpTubeMain.this, "Not Valid For Bookmark", Toast.LENGTH_SHORT).show();
        }

    }


    /**
     * Checks networking status.
     */
    private boolean checkConnectivity()
    {
        boolean enabled = true;

        ConnectivityManager connectivityManager = (ConnectivityManager) this.getSystemService(Context.CONNECTIVITY_SERVICE);
        NetworkInfo info = connectivityManager.getActiveNetworkInfo();

        if ((info == null || !info.isConnected() || !info.isAvailable()))
        {
            enabled = false;
            Builder builder = new Builder(this);
            builder.setIcon(android.R.drawable.ic_dialog_alert);
            builder.setMessage(getString(R.string.noconnection));
            builder.setCancelable(false);
            builder.setNeutralButton(R.string.ok, null);
            builder.setTitle(getString(R.string.error));
            builder.create().show();
        }
        return enabled;
    }
	
/*	
	//Snipper Nevigation Actionbar
	public boolean onNavigationItemSelected(int itemPosition, long itemId) {
		// TODO Auto-generated method stub
	    //Log.d("pos:"+itemPosition,"id:"+itemId);
		switch(itemPosition) {
	    case 0:
	    	SharedPreferences prefs = PreferenceManager.getDefaultSharedPreferences(this);
	    	String mydata = prefs.getString("avplang", null);if (mydata == null)
	        {webview.loadUrl("file:///android_asset/AvpTube-en.html");}else{
	        webview.loadUrl("file:///android_asset/AvpTube-"+mydata+".html");}
	        Toast.makeText(AvpTubeMain.this, R.string.msghome, Toast.LENGTH_SHORT).show();
	        break;
	    case 1:
	    	Bookmark();
	        break;
	    case 2:
	    	Toast.makeText(this, R.string.go_to_downloading_list, 1).show();
            Intent i = new Intent(this, DownloadListActivity.class);
            i.putExtra(DownloadListActivity.DOWNLOADED, false);
            startActivity(i);
	        break;
	    case 3:
	    	Intent myIntent = new Intent(getBaseContext(),
		                    TABMAIN.class);
		    startActivity(myIntent);
	        break;
	    default:
	    	
	}
		return false;
	}

*/

}
