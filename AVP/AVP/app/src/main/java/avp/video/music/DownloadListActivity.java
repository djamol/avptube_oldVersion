package avp.video.music;
/*
 * DjAmol Group Inc www.djamol.com
 * Author  : Amol V. Patil - admin@djamol.com
 * avp.video.music.dmgr package required....
 */
import java.util.List;

import djamol.com.lib.dmgr.*;
//import avp.video.music.log.Analytics;
import djamol.com.lib.mob.ToastAdListener;


import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.SharedPreferences;
import android.os.Bundle;
import android.os.Environment;
import android.preference.PreferenceManager;
import android.util.Log;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.MotionEvent;
import android.view.View;
import android.view.Window;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.AdapterView.OnItemClickListener;
import android.widget.AdapterView.OnItemLongClickListener;
import android.widget.Button;
import android.widget.ListView;
import android.widget.Toast;
import com.google.android.gms.ads.AdRequest;
import com.google.android.gms.ads.InterstitialAd;

public class DownloadListActivity extends Activity  {
    public static final String DOWNLOADED = "isDownloaded";

    private static final String TAG = "DownloadListActivity";
    
    private static final String ADMOB = "ca-app-pub-8457085474604831/6356682308";
    private InterstitialAd mInterstitial;
    private ListView mDownloadingListView;

    private ListView mDownloadedListView;

    private Context mContext;
    private float startX;

    private Button mDownloadedBtn;

    private Button mDownloadingBtn;

    List<DownloadTask> mDownloadinglist;

    List<DownloadTask> mDownloadedlist;

    DownloadingAdapter mDownloadingAdapter;
	private AlertDialog levelDialog;
    DownloadingAdapter mDownloadedAdapter;
    //download manager
	Dialog custom1;Button btnSearch;
    private static final String SDCARD = Environment.getExternalStorageDirectory().getPath()+ "/AvpTube";


    @Override
    public void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(Res.getInstance(mContext).getLayout("download_list"));
        mContext = this;
        mDownloadingBtn = (Button) findViewById(Res.getInstance(mContext).getId("buttonDownloading"));
        mDownloadedBtn = (Button) findViewById(Res.getInstance(mContext).getId("buttonDownloaded"));
        mDownloadedBtn.setOnClickListener(new OnClickListener(){

            @Override
            public void onClick(View v) {
                toggleView(true);
            }});
        mDownloadingBtn.setOnClickListener(new OnClickListener(){

            @Override
            public void onClick(View v) {
                toggleView(false);
            }});

        mDownloadingListView = (ListView) findViewById(Res.getInstance(mContext).getId("downloadingListView"));
        mDownloadedListView = (ListView) findViewById(Res.getInstance(mContext).getId("downloadedListView"));

        toggleView(getIntent().getBooleanExtra(DOWNLOADED, false));

        mDownloadedlist = DownloadTaskManager.getInstance(mContext).getFinishedDownloadTask();
        mDownloadedAdapter = new DownloadingAdapter(DownloadListActivity.this, 0, mDownloadedlist);

        mDownloadedListView.setAdapter(mDownloadedAdapter);
        mDownloadedListView.setOnItemClickListener(new OnItemClickListener() {

            @Override
            public void onItemClick(AdapterView<?> arg0, View arg1, int arg2, long arg3) {
                Log.d(TAG, "arg2" + arg2 + " mDownloadedlist" + mDownloadedlist.size());
                onDownloadFinishedClick(mDownloadedlist.get(arg2));
            }
        });
        mDownloadedListView.setOnItemLongClickListener(new OnItemLongClickListener() {

            @Override
            public boolean onItemLongClick(AdapterView<?> arg0, View arg1, final int arg2,
                    final long arg3) {
                new AlertDialog.Builder(mContext)
                        .setItems(
                                new String[] {
                                        mContext.getString(Res.getInstance(mContext).getString("download_delete_task")),
                                        mContext.getString(Res.getInstance(mContext).getString("download_delete_task_file"))
                                }, new DialogInterface.OnClickListener() {
                                    public void onClick(DialogInterface dialog, int which) {
                                        if (which == 0) {
                                            Toast.makeText(mContext,
                                                    Res.getInstance(mContext).getString("download_deleted_task_ok"),
                                                    Toast.LENGTH_LONG).show();
                                            DownloadTaskManager.getInstance(mContext)
                                                    .deleteDownloadTask(mDownloadedlist.get(arg2));
                                            mDownloadedlist.remove(arg2);
                                            mDownloadedAdapter.notifyDataSetChanged();
                                        } else if (which == 1) {
                                            Toast.makeText(mContext,
                                                    Res.getInstance(mContext).getString("download_deleted_task_file_ok"),
                                                    Toast.LENGTH_LONG).show();
                                            DownloadTaskManager.getInstance(mContext)
                                                    .deleteDownloadTask(mDownloadedlist.get(arg2));
                                            DownloadTaskManager.getInstance(mContext)
                                                    .deleteDownloadTaskFile(mDownloadedlist.get(arg2));
                                            mDownloadedlist.remove(arg2);
                                            mDownloadedAdapter.notifyDataSetChanged();
                                        }

                                    }
                                }).create().show();
                return false;
            }
        });

        // downloading list
        mDownloadinglist = DownloadTaskManager.getInstance(mContext).getDownloadingTask();
        mDownloadingAdapter = new DownloadingAdapter(DownloadListActivity.this, 0, mDownloadinglist);

        mDownloadingListView.setAdapter(mDownloadingAdapter);
        mDownloadingListView.setOnItemClickListener(new OnItemClickListener() {

            @Override
            public void onItemClick(AdapterView<?> arg0, View arg1, int arg2, long arg3) {

                DownloadTask task = mDownloadinglist.get(arg2);
                switch (task.getDownloadState()) {
                    case PAUSE:
                        Log.i(TAG, "PAUSE continue " + task.getFileName());
                        DownloadTaskManager.getInstance(mContext).continueDownload(task);
                        //addListener(task);
                        break;
                    case FAILED:
                        Log.i(TAG, "FAILED continue " + task.getFileName());
                        DownloadTaskManager.getInstance(mContext).continueDownload(task);
                        //addListener(task);
                        break;
                    case DOWNLOADING:
                        Log.i(TAG, "DOWNLOADING pause " + task.getFileName());
                        DownloadTaskManager.getInstance(mContext).pauseDownload(task);

                        break;
                    case FINISHED:
                        onDownloadFinishedClick(task);
                        break;
                    case INITIALIZE:

                        break;
                    default:
                        break;
                }

            }
        });

        mDownloadingListView.setOnItemLongClickListener(new OnItemLongClickListener() {

            @Override
            public boolean onItemLongClick(AdapterView<?> arg0, View arg1, final int arg2,
                    final long arg3) {
                new AlertDialog.Builder(mContext)
                        .setItems(
                                new String[] {
                                        mContext.getString(Res.getInstance(mContext).getString("download_delete_task")),
                                        mContext.getString(Res.getInstance(mContext).getString("download_delete_task_file"))
                                }, new DialogInterface.OnClickListener() {
                                    public void onClick(DialogInterface dialog, int which) {
                                        if (which == 0) {
                                            Toast.makeText(mContext,
                                                    Res.getInstance(mContext).getString("download_deleted_task_ok"),
                                                    Toast.LENGTH_LONG).show();
                                            DownloadTaskManager.getInstance(mContext)
                                                    .deleteDownloadTask(mDownloadinglist.get(arg2));
                                            mDownloadinglist.remove(arg2);
                                            mDownloadingAdapter.notifyDataSetChanged();
                                        } else if (which == 1) {
                                            Toast.makeText(mContext,
                                                    Res.getInstance(mContext).getString("download_deleted_task_file_ok"),
                                                    Toast.LENGTH_LONG).show();
                                            DownloadTaskManager.getInstance(mContext)
                                                    .deleteDownloadTask(mDownloadinglist.get(arg2));
                                            DownloadTaskManager.getInstance(mContext)
                                                    .deleteDownloadTaskFile(mDownloadinglist.get(arg2));
                                            mDownloadinglist.remove(arg2);
                                            mDownloadingAdapter.notifyDataSetChanged();
                                        }

                                    }
                                }).create().show();
                return false;
            }
        });

        for (final DownloadTask task : mDownloadinglist) {
            if (!task.getDownloadState().equals(DownloadState.FINISHED)) {
                Log.d(TAG, "add listener");
                addListener(task);
            }
        }
        
        //DownloadOperator.check(mContext);//key checker
    
      //first time option function
        SharedPreferences prefs = PreferenceManager.getDefaultSharedPreferences(this);
        if(!prefs.getBoolean("first_time", false))
        { //first time show message

			custom1 = new Dialog(DownloadListActivity.this,
					android.R.style.Theme_Translucent);
			custom1.requestWindowFeature(Window.FEATURE_NO_TITLE);
			custom1.setCancelable(true);
			custom1.setContentView(R.layout.tips);
	        btnSearch = (Button)custom1.findViewById(R.id.ok);
	       //custom1.setTitle("Custom Dialog");
                 btnSearch.setOnClickListener(new OnClickListener() {
	          @Override
	          public void onClick(View v) {

	        	  custom1.dismiss();
	          }
	        });
	        custom1.show();

        	SharedPreferences.Editor editor = prefs.edit();
            editor.putBoolean("first_time", true);
            editor.commit();
                    }/*first time option function end code
        	// Else(activity not first time) Show  Interstitial Admob Ads */
        else{
            mInterstitial = new InterstitialAd(this);
            mInterstitial.setAdUnitId(ADMOB);
            mInterstitial.setAdListener(new ToastAdListener(this) {
                @Override public void onAdLoaded() { //Successfully Loaded Ads
                    super.onAdLoaded();    
                    		if (mInterstitial.isLoaded()) {
                    			mInterstitial.show(); //show ads
                                ((AnalyticsApplication) getApplication()).trackEvent(DownloadListActivity.this, "ADS",
                    					"INTERSTITIAL", "SUCCESS"); // google analytics

                            }
                }
                @Override public void onAdFailedToLoad(int errorCode) {
                	super.onAdFailedToLoad(errorCode);//Ad Failed to Load
                }
            });
            mInterstitial.loadAd(new AdRequest.Builder().build());
            
        }
        
    }//oncreate function end
    
	@Override
	public boolean onTouchEvent(MotionEvent event) {
		switch (event.getAction()) {
		case MotionEvent.ACTION_DOWN:
			startX = event.getX();
			break;
		case MotionEvent.ACTION_UP: {
			float endX = event.getX();
			
			if (startX < endX) {
				//System.out.println("Move UP");
				//ll.setVisibility(View.VISIBLE);//show item ll.setVisibility(View.VISIBLE);
                toggleView(false);
			}
			else { 
                toggleView(true);
				//ll.setVisibility(View.GONE);//hide item ll.setVisibility(View.GONE);
				}
	    }}  return true;	}
	
	// Analytics Google
	 @Override
	 public void onStart() {
	   super.onStart();
         ((AnalyticsApplication) getApplication()).reportActivityStart(this);
	 }

	 @Override
	 public void onStop() {
	   super.onStop();
         ((AnalyticsApplication) getApplication()).reportActivityStop(this);
	 }
	/* Initiating Menu XML file (menu.xml) */
	@Override
	public boolean onCreateOptionsMenu(Menu menu)
	{
	    MenuInflater menuInflater = getMenuInflater();
	    menuInflater.inflate(R.menu.menu2, menu);
	    return true;
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
	    case R.id.menu_home:
	    	super.onBackPressed();
	    	//Intent intent2 = new Intent(DownloadListActivity.this,
			//		AvpTubeMain.class);
			//startActivity(intent2);
	    	return true;
		case R.id.menu_dload:
			//Intent intent = new Intent(AvpTubeMain.this,DownloadListActivity.class);startActivity(intent);
			Toast.makeText(this, R.string.go_to_downloading_list, Toast.LENGTH_SHORT).show();
            Intent i = new Intent(this, DownloadListActivity.class);
            i.putExtra(DownloadListActivity.DOWNLOADED, false);
            startActivity(i);
	    	//Toast.makeText(AvpTubeMain.this, "DjAmol Group", Toast.LENGTH_SHORT).show();
	        return true;
			   
		case R.id.menu_about:

			custom1 = new Dialog(DownloadListActivity.this,
					android.R.style.Theme_Translucent);
			custom1.requestWindowFeature(Window.FEATURE_NO_TITLE);
			custom1.setCancelable(true);
			custom1.setContentView(R.layout.about);
	        btnSearch = (Button)custom1.findViewById(R.id.ok);
	       //custom1.setTitle("Custom Dialog");
                 btnSearch.setOnClickListener(new OnClickListener() {
	          @Override
	          public void onClick(View v) {

	        	  custom1.dismiss();
	          }
	        });
	        custom1.show();
	    	return true;
	        
	    case R.id.menu_chkup:
	    	// Check Update

	    	// Strings to Show In Dialog with Radio Buttons
	    	final CharSequence[] items3 = {"Download DM","Using DM"};
	    	           
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
	    	   			            downloadTask5.setThumbnail("file:///android_asset/ic_launcher.png"); //use image file uri
	    	   			            DownloadTaskManager.getInstance(mContext).registerListener(downloadTask5,
	    	   			                    new DownloadNotificationListener(mContext, downloadTask5));
	    	   			            DownloadTaskManager.getInstance(mContext).startDownload(downloadTask5);
	    	   					   	Toast.makeText(DownloadListActivity.this, R.string.dback, Toast.LENGTH_SHORT).show();
	    	                          break;
	    	                       case 1:
	    	                    	   DownloadTask downloadTask6 = new DownloadTask(
	    	                                   "http://avptube.com/AvpTube.apk", SDCARD,
	    	                                   "AvpTube.apk", "AvpTube App", null);
	    	   			            downloadTask6.setThumbnail("file:///android_asset/ic_launcher.png"); //use image file uri
	    	   			            DownloadTaskManager.getInstance(mContext).registerListener(downloadTask6,
	    	   			                    new DownloadNotificationListener(mContext, downloadTask6));
	    	   			            DownloadTaskManager.getInstance(mContext).startDownload(downloadTask6);
	    	   					   	Toast.makeText(DownloadListActivity.this, R.string.dback, Toast.LENGTH_SHORT).show();
	    	   					   	
	    	                    	   //startActivity(new Intent(Intent.ACTION_VIEW, Uri.parse("http://mobile.djamol.com/app/Ytube.apk")));	    	                    	   
	    	                    	   break;
	    	                       
	    	                   }
								
								levelDialog.dismiss();   
	    	                    }
	    	                });
	    	                levelDialog = builder3.create();
	    	                levelDialog.show();
	        return true;
	        
	    default:
	        return super.onOptionsItemSelected(item);
	    }
	}


    
    private void toggleView(boolean isShowDownloaded) {
        if (isShowDownloaded) {
            mDownloadedBtn.setBackgroundResource(Res.getInstance(mContext).getDrawable("download_right_tab_selected"));
            mDownloadingBtn.setBackgroundResource(Res.getInstance(mContext).getDrawable("download_left_tab"));
            mDownloadedListView.setVisibility(View.VISIBLE);
            mDownloadingListView.setVisibility(View.GONE);
        } else {
            mDownloadedBtn.setBackgroundResource(Res.getInstance(mContext).getDrawable("download_right_tab"));
            mDownloadingBtn.setBackgroundResource(Res.getInstance(mContext).getDrawable("download_left_tab_selected"));
            mDownloadedListView.setVisibility(View.GONE);
            mDownloadingListView.setVisibility(View.VISIBLE);
        }
    }

    class MyDownloadListener implements DownloadListener {
        private DownloadTask task;

        public MyDownloadListener(DownloadTask downloadTask) {
            task = downloadTask;
        }

        @Override
        public void onDownloadFinish(String filepath) {
            Log.d(TAG, "onDownloadFinish");
            task.setDownloadState(DownloadState.FINISHED);
            task.setFinishedSize(task.getFinishedSize());
            task.setPercent(100);
            DownloadListActivity.this.runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    mDownloadingAdapter.notifyDataSetChanged();
                    mDownloadedAdapter.add(task);
                    mDownloadingAdapter.remove(task);
                    // toggleView(true);
                }
            });

        }

        @Override
        public void onDownloadStart() {
            task.setDownloadState(DownloadState.INITIALIZE);
            DownloadListActivity.this.runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    mDownloadingAdapter.notifyDataSetChanged();
                }
            });
        }

        @Override
        public void onDownloadPause() {
            Log.d(TAG, "onDownloadPause");
            task.setDownloadState(DownloadState.PAUSE);
            DownloadListActivity.this.runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    mDownloadingAdapter.notifyDataSetChanged();
                }
            });
        }

        @Override
        public void onDownloadStop() {
            Log.d(TAG, "onDownloadStop");
            task.setDownloadState(DownloadState.PAUSE);
            DownloadListActivity.this.runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    mDownloadingAdapter.notifyDataSetChanged();
                }
            });
        }

        @Override
        public void onDownloadFail() {
            Log.d(TAG, "onDownloadFail");
            task.setDownloadState(DownloadState.FAILED);
            DownloadListActivity.this.runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    mDownloadingAdapter.notifyDataSetChanged();
                }
            });
        }

        @Override
        public void onDownloadProgress(final int finishedSize, final int totalSize,
                int speed) {
            // Log.d(TAG, "download " + finishedSize);
            task.setDownloadState(DownloadState.DOWNLOADING);
            task.setFinishedSize(finishedSize);
            task.setTotalSize(totalSize);
            task.setPercent(finishedSize*100/totalSize);
            task.setSpeed(speed);

            DownloadListActivity.this.runOnUiThread(new Runnable() {
                @Override
                public void run() {
                    mDownloadingAdapter.notifyDataSetChanged();
                }
            });
        }
    }

    public void addListener(DownloadTask task) {
        DownloadTaskManager.getInstance(mContext).registerListener(task, new MyDownloadListener(task));
    }

    @Override
    protected void onNewIntent(Intent intent) {
        toggleView(intent.getBooleanExtra(DOWNLOADED, false));

        super.onNewIntent(intent);
    }

    /**
     * You can overwrite this method to implement what you want do after download task item is clicked.
     * @param task
     */
    public void onDownloadFinishedClick(DownloadTask task) {
        Log.d(TAG, task.getFilePath() + "/"+ task.getFileName());
        Intent intent = DownloadOpenFile.openFile(task.getFilePath()
                + "/"+ task.getFileName());
        if (null == intent) {
            Toast.makeText(mContext, R.string.download_file_not_exist, Toast.LENGTH_LONG).show();
        } else {
            mContext.startActivity(intent);
        }
    }
    

    
    
}
