package djamol.com.lib.mob;
/*
 * DjAmol Group Inc www.djamol.com
 * Author  : Amol V. Patil - admin@djamol.com
 */




import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.database.sqlite.SQLiteDatabase.CursorFactory;

public class database {

	public static final String MYDATABASE_NAME = "AVPTUBE";
	public static final int MYDATABASE_VERSION = 1;
	
	
	public static final String MYDATABASE_TABLE = "ST";
	public static final String KEY_ID = "_id";
	public static final String SID = "sid";
	public static final String SNAME = "sname";
	public static final String SROLL = "sroll";

	
	public static final String MYDATABASE_TABLE1 = "MT";
	public static final String KEY_ID1 = "_id";
    public static final String MSID= "msid";
	public static final String MID= "mid";
	public static final String SUB= "sub";
	public static final String MARK= "mark";


	//create table MY_DATABASE (ID integer primary key, Content text not null);
	private static final String SCRIPT_CREATE_DATABASE =
		"create table " + MYDATABASE_TABLE + " ("
		+ KEY_ID + " integer primary key autoincrement, "
		+ SID+ " text not null, "
		+ SNAME + " text not null,"
	    + SROLL+ " text not null);";
	
	private static final String SCRIPT_CREATE_DATABASE1 =
			"create table " + MYDATABASE_TABLE1 + " ("
			+ KEY_ID1 + " integer primary key autoincrement, "
			+ MID+ " text not null, "
			+ MSID + " text not null,"
			+ SUB + " text not null,"
		    + MARK+ " text not null);";
	private SQLiteHelper sqLiteHelper;
	private SQLiteDatabase sqLiteDatabase;

	private Context context;
	
	public database(Context c){
		context = c;
	}
	
	public database openToRead() throws android.database.SQLException {
		
		sqLiteHelper = new SQLiteHelper(context, MYDATABASE_NAME, null, MYDATABASE_VERSION);
		sqLiteDatabase = sqLiteHelper.getReadableDatabase();
		return this;	
	}
	
	public database openToWrite() throws android.database.SQLException {
		sqLiteHelper = new SQLiteHelper(context, MYDATABASE_NAME, null, MYDATABASE_VERSION);
		sqLiteDatabase = sqLiteHelper.getWritableDatabase();
		return this;	
	}
	
	public void close(){
		sqLiteHelper.close();
	}
	
	public long insert(String sid, String sname,String sroll){
		
		ContentValues contentValues = new ContentValues();
		contentValues.put(SID, sid);
		contentValues.put(SNAME,sname);	
		contentValues.put(SROLL,sroll);	
		return sqLiteDatabase.insert(MYDATABASE_TABLE, null, contentValues);
		
	}
	public long insert1(String mid, String msid ,String sub,String mark){
		
		ContentValues contentValues1 = new ContentValues();
		contentValues1.put(MID, mid);
		contentValues1.put(MSID,msid);	
		contentValues1.put(SUB,sub);	
		contentValues1.put(MARK,mark);
		return sqLiteDatabase.insert(MYDATABASE_TABLE1, null, contentValues1);
		
		
	}
//public int update(String table, ContentValues values, String whereClause, String[] whereArgs){
public long update(String sid, String sname,String sroll,int id){
	ContentValues contentValues = new ContentValues();
	contentValues.put(SID, sid);
	contentValues.put(SNAME,sname);	
	contentValues.put(SROLL,sroll);	
	System.out.println(id);
	
	return sqLiteDatabase.update(MYDATABASE_TABLE, contentValues, KEY_ID+"="+id, null);
}
public long uptitle(String sid, int id){
	ContentValues contentValues = new ContentValues();
	contentValues.put(SID, sid);
	//contentValues.put(SNAME,sname);	
	//contentValues.put(SROLL,sroll);	
	System.out.println(id);
	return sqLiteDatabase.update(MYDATABASE_TABLE, contentValues, KEY_ID+"="+id, null);
}
	
	public int deleteAll(){
		return sqLiteDatabase.delete(MYDATABASE_TABLE, null, null);
	}
	
	public void delete_byID(int id){
		sqLiteDatabase.delete(MYDATABASE_TABLE, KEY_ID+"="+id, null);
	}
	public void delete_byID1(int id){
		sqLiteDatabase.delete(MYDATABASE_TABLE1, KEY_ID+"="+id, null);
	}
	
	public Cursor queueAll1(){
		String[] columns1 = new String[]{KEY_ID1, MID,MSID,SUB,MARK};
		Cursor cursor = sqLiteDatabase.query(MYDATABASE_TABLE1, columns1, 
				null, null, null, null, null);
		
		return cursor;
	}
	public Cursor queueAll(){
		String[] columns = new String[]{KEY_ID, SID,SNAME,SROLL};
		Cursor cursor = sqLiteDatabase.query(MYDATABASE_TABLE, columns, 
				null, null, null, null, null);
		
		return cursor;
	}
	public Cursor queueAll2(int id){
		
		  String a="SELECT * FROM ST WHERE _id = "+id;
		
		  Cursor cursor=sqLiteDatabase.rawQuery(a, null);
		
		return cursor;
	}
	public Cursor queueAll3(int id){
		//String[] columns = new String[]{KEY_ID, SID,SNAME,SROLL};
		  String a="SELECT * FROM MT,ST WHERE _id = "+id;
		//Cursor cursor = sqLiteDatabase.query(MYDATABASE_TABLE, columns, 
			//	null, null, null, null, null);
		  Cursor cursor=sqLiteDatabase.rawQuery(a, null);
		
		return cursor;
	}
	
	public class SQLiteHelper extends SQLiteOpenHelper {

		public SQLiteHelper(Context context, String name,
				CursorFactory factory, int version) {
			super(context, name, factory, version);
		}

		@Override
		public void onCreate(SQLiteDatabase db) {
			// TODO Auto-generated method stub
			db.execSQL(SCRIPT_CREATE_DATABASE);
			db.execSQL(SCRIPT_CREATE_DATABASE1);
		}
	
		

		@Override
		public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {
			// TODO Auto-generated method stub

		}

	}
	
}
