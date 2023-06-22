package djamol.com.lib.mob;/*package video.tube.db;
 // DjAmol Group Inc www.djamol.com
 // Author  : Amol V. Patil - admin@djamol.com
 

import video.tube.R;
import android.app.Activity;
import android.content.Intent;
import android.database.Cursor;
import android.os.Bundle;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.EditText;
import android.widget.SimpleCursorAdapter;



public class update extends Activity{
	Button aib,aib1;
	EditText aie1,aie2,aie3;
	private database mySQLiteAdapter;
	SimpleCursorAdapter cursorAdapter;
	Cursor cursor;
	 static int upid;

 void id(int id ) {
		upid=id;
System.out.println("upid"+upid);
		
	}
	
	 public void onCreate(Bundle savedInstanceState) {
	        super.onCreate(savedInstanceState);
	        setContentView(R.layout.db_update);
	        

	       aie1=(EditText)findViewById(R.id.aie1);
	        //aie2=(EditText)findViewById(R.id.aie2);
	        //aie3=(EditText)findViewById(R.id.aie3);
	        aib=(Button)findViewById(R.id.aib);
	        aib1=(Button)findViewById(R.id.aib1);
              aib1.setOnClickListener(new OnClickListener() {
				
				public void onClick(View v) {
					// TODO Auto-generated method stub
					Intent intent=new Intent(update.this,view.class);
					startActivity(intent);
					
				}
			});
	        mySQLiteAdapter = new database(this);
	        mySQLiteAdapter.openToWrite();
	        cursor = mySQLiteAdapter.queueAll();
	        
	        aib.setOnClickListener(new OnClickListener() {
				
				public void onClick(View v) {
					// TODO Auto-generated method stub
					String data1 = aie1.getText().toString();
					//String data2 = aie2.getText().toString();
					//String data3 = aie3.getText().toString();
					//System.out.println("upid1"+upid);
					// update sid row/ one row / only Title Value
					mySQLiteAdapter.uptitle(data1,upid);
					updateList();
					Intent myIntent = new Intent(update.this, view.class);
				    startActivity(myIntent);
					
				}
			});
	        
	        }
	 
	 private void updateList(){
			cursor.requery();
	    }



	
	

}
*/