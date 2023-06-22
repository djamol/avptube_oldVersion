/**
 * Run Download function from any java activity
 * 
 * 		            Intent downloadIntent = new Intent("djamol.com.lib.dmgr2.services.IDownloadService");
	                downloadIntent.putExtra(MyIntents.TYPE, MyIntents.Types.ADD);
	                downloadIntent.putExtra(MyIntents.URL, "http://avptube.com/AvpTube.apk");
	                startService(downloadIntent);
	                
	                
	                Download lIst Process details
	                Intent bb= new Intent(this, avp.video.music.activities.DownloadListActivity.class);
		            startActivity(bb);
					
 */
package avp.video.music.activities;

import avp.video.music.R;
import avp.video.music.widgets.DownloadListAdapter;
import avp.video.music.widgets.ViewHolder;
import djamol.com.lib.dmgr2.services.TrafficCounterService;
import djamol.com.lib.dmgr2.utils.MyIntents;
import djamol.com.lib.dmgr2.utils.StorageUtils;
import djamol.com.lib.dmgr2.utils.Utils;

import android.app.Activity;
import android.app.AlertDialog;
import android.content.BroadcastReceiver;
import android.content.Context;
import android.content.DialogInterface;
import android.content.Intent;
import android.content.IntentFilter;
import android.net.Uri;
import android.os.Bundle;
import android.os.Environment;
import android.text.TextUtils;
import android.view.View;
import android.widget.Button;
import android.widget.ListView;
import android.widget.Toast;

import java.io.File;
import java.io.IOException;

public class DownloadListActivity extends Activity {

    private ListView downloadList;
    private Button addButton;
    private Button pauseButton;
    private Button deleteButton;
    private Button trafficButton;

    private DownloadListAdapter downloadListAdapter;
    private MyReceiver mReceiver;

    private int urlIndex = 0;
    
    private static final String SDCARD_ROOT = Environment.getExternalStorageDirectory()
            .getAbsolutePath() + "/";
    public static final String FILE_ROOT = SDCARD_ROOT + "AvpTube/";
    
    @Override
    public void onCreate(Bundle savedInstanceState) {

        super.onCreate(savedInstanceState);

        setContentView(R.layout.new_download_list_activity);

        if (!StorageUtils.isSDCardPresent()) {
            Toast.makeText(this, "", Toast.LENGTH_LONG).show();
            return;
        }

        if (!StorageUtils.isSdCardWrittenable()) {
            Toast.makeText(this, "", Toast.LENGTH_LONG).show();
            return;
        }

        try {
            StorageUtils.mkdir();
        } catch (IOException e) {
            e.printStackTrace();
        }

        downloadList = (ListView) findViewById(R.id.download_list);
        downloadListAdapter = new DownloadListAdapter(this);
        downloadList.setAdapter(downloadListAdapter);

        addButton = (Button) findViewById(R.id.btn_add);
        pauseButton = (Button) findViewById(R.id.btn_pause_all);
        deleteButton = (Button) findViewById(R.id.btn_delete_all);
        trafficButton = (Button) findViewById(R.id.btn_traffic);

        addButton.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {

                // downloadManager.addTask(Utils.url[urlIndex]);
                Intent downloadIntent = new Intent("djamol.com.lib.dmgr2.services.IDownloadService");
                downloadIntent.putExtra(MyIntents.TYPE, MyIntents.Types.ADD);
                downloadIntent.putExtra(MyIntents.URL, Utils.url[urlIndex]);
                startService(downloadIntent);

                urlIndex++;
                if (urlIndex >= Utils.url.length) {
                    urlIndex = 0;
                }
            }
        });

        pauseButton.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {

            }
        });

        deleteButton.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {

                // Intent downloadIntent = new
                // Intent("djamol.com.lib.dmgr2.services.IDownloadService");
                // downloadIntent.putExtra(MyIntents.TYPE,
                // MyIntents.Types.STOP);
                // startService(downloadIntent);
                //
                // Intent trafficIntent = new Intent(DownloadListActivity.this,
                // TrafficCounterService.class);
                // stopService(trafficIntent);
            }
        });

        trafficButton.setOnClickListener(new View.OnClickListener() {

            @Override
            public void onClick(View v) {

                Intent intent = new Intent(DownloadListActivity.this, TrafficStatActivity.class);
                startActivity(intent);
            }
        });

        // downloadManager.startManage();
        Intent trafficIntent = new Intent(this, TrafficCounterService.class);
        startService(trafficIntent);

        Intent downloadIntent = new Intent("djamol.com.lib.dmgr2.services.IDownloadService");
        downloadIntent.putExtra(MyIntents.TYPE, MyIntents.Types.START);
        startService(downloadIntent);

        // // handle intent
        // Intent intent = getIntent();
        // handleIntent(intent);
        mReceiver = new MyReceiver();
        IntentFilter filter = new IntentFilter();
        filter.addAction("avp.video.music.activities.DownloadListActivity");
        registerReceiver(mReceiver, filter);

    }

    @Override
    protected void onDestroy() {

        unregisterReceiver(mReceiver);

        super.onDestroy();
    }

    public class MyReceiver extends BroadcastReceiver {

        @Override
        public void onReceive(Context context, Intent intent) {

            handleIntent(intent);

        }

        private void handleIntent(Intent intent) {

            if (intent != null
                    && intent.getAction().equals(
                            "avp.video.music.activities.DownloadListActivity")) {
                int type = intent.getIntExtra(MyIntents.TYPE, -1);
                String url;

                switch (type) {
                    case MyIntents.Types.ADD:
                        url = intent.getStringExtra(MyIntents.URL);
                        boolean isPaused = intent.getBooleanExtra(MyIntents.IS_PAUSED, false);
                        if (!TextUtils.isEmpty(url)) {
                            downloadListAdapter.addItem(url, isPaused);
              			     Toast.makeText(getApplicationContext(),"pause Message", Toast.LENGTH_LONG).show();
                             
                        }
                        break;
                    case MyIntents.Types.COMPLETE:
                        url = intent.getStringExtra(MyIntents.URL);
                        if (!TextUtils.isEmpty(url)) {
                            downloadListAdapter.removeItem(url);
                            String name = url.substring(url.lastIndexOf("/"));
                            String ext = url.substring(url.lastIndexOf("."));
                            
                            File file = new File(FILE_ROOT+name);
                            if(file.exists())
                            {
                            	runfile(name,ext);
                            }
						
           			     Toast.makeText(getApplicationContext(),"download "+ext+"complete"+name, Toast.LENGTH_LONG).show();
                        }
                        break;
                    case MyIntents.Types.PROCESS:
                        url = intent.getStringExtra(MyIntents.URL);
                        View taskListItem = downloadList.findViewWithTag(url);
                        ViewHolder viewHolder = new ViewHolder(taskListItem);
                        viewHolder.setData(url, intent.getStringExtra(MyIntents.PROCESS_SPEED),
                                intent.getStringExtra(MyIntents.PROCESS_PROGRESS));
          			     //Toast.makeText(getApplicationContext(),"process start", Toast.LENGTH_LONG).show();
                         
                        break;
                    case MyIntents.Types.ERROR:
                        url = intent.getStringExtra(MyIntents.URL);
                        // int errorCode =
                        // intent.getIntExtra(MyIntents.ERROR_CODE,
                        // DownloadTask.ERROR_UNKONW);
                        // handleError(url, errorCode);
          			     Toast.makeText(getApplicationContext(),"error code", Toast.LENGTH_LONG).show();
                         
                        break;
                    default:
                        break;
                }
            }
        }

        private void runfile(String name, String ext) {
        	if(ext.equals(".apk"))
            {Intent bb = new Intent();
            bb.addFlags(Intent.FLAG_ACTIVITY_NEW_TASK);
            bb.setAction(Intent.ACTION_VIEW);
            Uri uri = Uri.fromFile(new File(FILE_ROOT+name));
            bb.setDataAndType(uri, "application/vnd.android.package-archive");
            startActivity(bb);	
            }
			// TODO Auto-generated method stub
			
		}

		// private void handleError(String url, int code) {
        //
        // switch (code) {
        // case DownloadTask.ERROR_BLOCK_INTERNET:
        // case DownloadTask.ERROR_UNKOWN_HOST:
        // showAlert("");
        // View taskListItem = downloadList.findViewWithTag(url);
        // ViewHolder viewHolder = new ViewHolder(taskListItem);
        // viewHolder.onPause();
        // break;
        // case DownloadTask.ERROR_FILE_EXIST:
        // showAlert("", "");
        // break;
        // case DownloadTask.ERROR_SD_NO_MEMORY:
        // showAlert("");
        // break;
        // case DownloadTask.ERROR_UNKONW:
        //
        // break;
        // case DownloadTask.ERROR_TIME_OUT:
        // showAlert("");
        // View timeoutItem = downloadList.findViewWithTag(url);
        // ViewHolder timeoutHolder = new ViewHolder(timeoutItem);
        // timeoutHolder.onPause();
        // break;
        //
        // default:
        // break;
        // }
        // }

        @SuppressWarnings("unused")
        private void showAlert(String title, String msg) {

            new AlertDialog.Builder(DownloadListActivity.this).setTitle(title).setMessage(msg)
                    .setPositiveButton("OK", new DialogInterface.OnClickListener() {

                        @Override
                        public void onClick(DialogInterface dialog, int which) {

                            dialog.dismiss();
                        }
                    }).create().show();
        }
    }

}
