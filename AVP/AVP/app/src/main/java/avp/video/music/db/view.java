package avp.video.music.db;
/*
 * DjAmol Group Inc www.djamol.com
 * Author  : Amol V. Patil - admin@djamol.com
 */

import djamol.com.lib.mob.database;
import avp.video.music.AvpTubeMain;
import avp.video.music.R;
import android.app.Activity;
import android.app.AlertDialog;
import android.app.Dialog;
import android.content.DialogInterface;
import android.content.Intent;
import android.database.Cursor;
import android.os.Bundle;
import android.view.Menu;
import android.view.MenuInflater;
import android.view.MenuItem;
import android.view.View;
import android.view.Window;
import android.view.View.OnClickListener;
import android.widget.AdapterView;
import android.widget.Button;
import android.widget.EditText;
import android.widget.ListView;
import android.widget.SimpleCursorAdapter;
import android.widget.AdapterView.OnItemClickListener;

public class view extends Activity{
	private database mySQLiteAdapter;
	//private update up=new update();
	//private sdetails sdid=new sdetails();
	ListView listContent;
	SimpleCursorAdapter cursorAdapter;
	Cursor cursor;
	//custom search
	  Dialog custom1;
	  EditText sbox;
	  Button btnSearch, btnCancel;
	  
	 public void onCreate(Bundle savedInstanceState) {
	        super.onCreate(savedInstanceState);
	        setContentView(R.layout.db_view);
	        listContent = (ListView)findViewById(R.id.vl);
	        mySQLiteAdapter = new database(this);
	        mySQLiteAdapter.openToWrite();
	        Button aib1 = (Button)findViewById(R.id.back);
            aib1.setOnClickListener(new OnClickListener() {
				
				public void onClick(View v) {
					// TODO Auto-generated method stub
					Intent intent=new Intent(view.this,AvpTubeMain.class);
					startActivity(intent);
					
				}
			});

	        cursor = mySQLiteAdapter.queueAll();
	        if (cursor.moveToFirst()) {
	            //StringBuilder sb1=new StringBuilder();
				do {
					 //sb1.append(employees.getString(1));
		             //sb1.append(employees.getString(2));
	    String sb2 = cursor.getString(cursor.getColumnIndex("sname"));
			
		            // text1.setText(sb1)
		 		    System.out.println("string = " + sb2);
		        } while (cursor.moveToNext());

			}
     
	 
	        String[] from = new String[]{database.KEY_ID, database.SID};
	        int[] to = new int[]{R.id.rid, R.id.rt1};
	       	        
	        cursorAdapter =
	        	new SimpleCursorAdapter(this, R.layout.db_rowview, cursor, from, to);
	        listContent.setAdapter(cursorAdapter);
	    /*    listContent.setOnItemClickListener(new OnItemClickListener() {

				public void onItemClick(AdapterView<?> arg0, View arg1,
						int arg2, long arg3) {

					Cursor cursor = (Cursor) arg0.getItemAtPosition(arg2);
					final int item_id = cursor.getInt(cursor.getColumnIndex(database.KEY_ID));
					sdid.sdid(item_id);
					Intent intent=new Intent(view.this,sdetails.class);
					startActivity(intent);	
				}
				
				});
	       */     
	        listContent.setOnItemLongClickListener(new AdapterView.OnItemLongClickListener() {
	            @Override
	            public boolean onItemLongClick(AdapterView<?> av, View v, int pos, long id) {
	            	final int item_id = cursor.getInt(cursor.getColumnIndex(database.KEY_ID));
					mySQLiteAdapter.delete_byID(item_id);
        			updateList();
	            	return true;
	            }
	        });
	        listContent.setOnItemClickListener(new OnItemClickListener() {

				public void onItemClick(AdapterView<?> arg0, View arg1,
						int arg2, long arg3) {
					
					// TODO Auto-generated method stub
	
					Cursor cursor = (Cursor) arg0.getItemAtPosition(arg2);
					final int item_id = cursor.getInt(cursor.getColumnIndex(database.KEY_ID));
					  AlertDialog.Builder myDialog  = new AlertDialog.Builder(view.this);
					  myDialog.setTitle("Delete?");
					  myDialog.setPositiveButton("OK", new DialogInterface.OnClickListener() {
			                // do something when the button is clicked
			                public void onClick(DialogInterface arg0, int arg1) {
			                	mySQLiteAdapter.delete_byID(item_id);
			        			updateList();
			        		//	Intent intent=new Intent(view.this,AvpTubeMain.class);
							//	startActivity(intent);
			                 }
			                });
			            
			            myDialog.setNegativeButton("edit", new DialogInterface.OnClickListener() {
			                // do something when the button is clicked
			                public void onClick(DialogInterface arg0, int arg1) {
			                	custom1 = new Dialog(view.this,
				        				android.R.style.Theme_Translucent);
				        		custom1.requestWindowFeature(Window.FEATURE_NO_TITLE);
				        		custom1.setCancelable(true);
				        		custom1.setContentView(R.layout.db_update);
				                sbox = (EditText)custom1.findViewById(R.id.sbox);
				                btnSearch = (Button)custom1.findViewById(R.id.btnsearch);
				                btnCancel = (Button)custom1.findViewById(R.id.btncancel);
				                //custom1.setTitle("Custom Dialog");
				                btnSearch.setOnClickListener(new OnClickListener() {
				                  @Override
				                  public void onClick(View v) {
				                    // TODO Auto-generated method stub
				  					String data1 = sbox.getText().toString();
				  					mySQLiteAdapter.uptitle(data1,item_id);
									updateList();
									custom1.dismiss();
				                  }
				                });
				                btnCancel.setOnClickListener(new OnClickListener() {
				                  @Override
				                  public void onClick(View view) {
				                    // TODO Auto-generated method stub
				                    custom1.dismiss();
				                  }
				                });
				                custom1.show();
				                // Perform action on click
								//Toast.makeText(getApplicationContext(), "Video Search box", Toast.LENGTH_SHORT).show();
								
       	
			         
			                 }
			                });
			            
			            myDialog.show();
			            
					//mySQLiteAdapter.delete_byID(item_id);
					//Intent intent=new Intent(view.this,MainActivity.class);
					//startActivity(intent);
					
					
					
				}
	        	
			});
	 }
	 
		/* Initiating Menu XML file (menu.xml) */
		@Override
		public boolean onCreateOptionsMenu(Menu menu)
		{
		    MenuInflater menuInflater = getMenuInflater();
		    menuInflater.inflate(R.menu.db, menu);
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
			case R.id.menu_back:
		    	super.onBackPressed();
				return true;
				   
			case R.id.menu_about:

				custom1 = new Dialog(view.this,
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
		        
		    default:
		        return super.onOptionsItemSelected(item);
		    }
		}

	 
	 private void updateList(){
			cursor.requery();
	    }


}
