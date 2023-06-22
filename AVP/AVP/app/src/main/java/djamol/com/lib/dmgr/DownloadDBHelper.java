
package djamol.com.lib.dmgr;

import java.util.ArrayList;
import java.util.List;

import android.content.ContentValues;
import android.content.Context;
import android.database.Cursor;
import android.database.sqlite.SQLiteDatabase;
import android.database.sqlite.SQLiteOpenHelper;
import android.util.Log;

public class DownloadDBHelper extends SQLiteOpenHelper {
    /**
     * debug tag.
     */
    private static final String TAG = "DownloadDBHelper";

    /**
     * table name : download
     */
    private static final String TABLE_NAME = "download";

    private static final String FIELD_ID = "_id";

    private static final String FIELD_URL = "url";

    private static final String FIELD_DOWNLOAD_STATE = "downloadState";

    private static final String FIELD_FILEPATH = "filepath";

    private static final String FIELD_FILENAME = "filename";

    private static final String FIELD_TITLE = "title";

    private static final String FIELD_THUMBNAIL = "thumbnail";

    private static final String FIELD_FINISHED_SIZE = "finishedSize";

    private static final String FIELD_TOTAL_SIZE = "totalSize";

    /**
     * Constructor
     * 
     * @param context Context
     */
    public DownloadDBHelper(Context context, String name) {
        super(context, name, null, 1);
    }

    /**
     * 
     * @param db SQLiteDatabase
     * @see SQLiteOpenHelper#onCreate(SQLiteDatabase)
     */

    @Override
    public void onCreate(SQLiteDatabase db) {
        Log.i(TAG, "create download table.");
        StringBuffer buffer = new StringBuffer("create table ");
        buffer.append(TABLE_NAME);
        buffer.append("(");
        buffer.append(FIELD_ID);
        buffer.append(" integer primary key autoincrement, ");
        buffer.append(FIELD_URL);
        buffer.append(" text unique, ");
        buffer.append(FIELD_DOWNLOAD_STATE);
        buffer.append(" text,");
        buffer.append(FIELD_FILEPATH);
        buffer.append(" text, ");
        buffer.append(FIELD_FILENAME);
        buffer.append(" text, ");
        buffer.append(FIELD_TITLE);
        buffer.append(" text, ");
        buffer.append(FIELD_THUMBNAIL);
        buffer.append(" text, ");
        buffer.append(FIELD_FINISHED_SIZE);
        buffer.append(" integer, ");
        buffer.append(FIELD_TOTAL_SIZE);
        buffer.append(" integer)");

        String sql = buffer.toString();
        Log.i(TAG, sql);
        db.execSQL(sql);
    }

    /**
     * @param db The database.
     * @param oldVersion The old database version.
     * @param newVersion The new database version
     * @see SQLiteOpenHelper#onUpgrade(SQLiteDatabase,
     *      int, int)
     */

    @Override
    public void onUpgrade(SQLiteDatabase db, int oldVersion, int newVersion) {

    }

    /**
     * @param downloadTask DownloadTask
     */
    void insert(DownloadTask downloadTask) {
        SQLiteDatabase db = getWritableDatabase();
        db.insert(TABLE_NAME, null, getContentValues(downloadTask));
    }

    /**
     * 
     * @param url
     * @return DownloadTask
     */
    DownloadTask query(String url) {
        SQLiteDatabase db = getReadableDatabase();
        DownloadTask dlTask = null;
        Cursor cursor = db.query(TABLE_NAME, new String[] {
                FIELD_URL, FIELD_DOWNLOAD_STATE, FIELD_FILEPATH, FIELD_FILENAME, FIELD_TITLE,
                FIELD_THUMBNAIL, FIELD_FINISHED_SIZE, FIELD_TOTAL_SIZE
        }, FIELD_URL + "=?", new String[] {
            url
        }, null, null, null);
        if (cursor != null) {
            if (cursor.moveToNext()) {
                dlTask = new DownloadTask(cursor.getString(0), cursor.getString(2),
                        cursor.getString(3), cursor.getString(4), cursor.getString(5));
                dlTask.setDownloadState(DownloadState.valueOf(cursor.getString(1)));
                dlTask.setFinishedSize(cursor.getInt(6));
                dlTask.setTotalSize(cursor.getInt(7));
            }
            cursor.close();
        }
        return dlTask;
    }

    /**
     */
    List<DownloadTask> queryAll() {
        List<DownloadTask> tasks = new ArrayList<DownloadTask>();

        SQLiteDatabase db = getReadableDatabase();
        Cursor cursor = db.query(TABLE_NAME, new String[] {
                FIELD_URL, FIELD_DOWNLOAD_STATE, FIELD_FILEPATH, FIELD_FILENAME, FIELD_TITLE,
                FIELD_THUMBNAIL, FIELD_FINISHED_SIZE, FIELD_TOTAL_SIZE
        }, null, null, null, null, null);
        if (cursor != null) {
            while (cursor.moveToNext()) {
                DownloadTask dlTask = new DownloadTask(cursor.getString(0), cursor.getString(2),
                        cursor.getString(3), cursor.getString(4), cursor.getString(5));
                dlTask.setDownloadState(DownloadState.valueOf(cursor.getString(1)));
                dlTask.setFinishedSize(cursor.getInt(6));
                dlTask.setTotalSize(cursor.getInt(7));

                tasks.add(dlTask);
            }
            cursor.close();
        }

        return tasks;
    }

    List<DownloadTask> queryDownloaded() {
        List<DownloadTask> tasks = new ArrayList<DownloadTask>();

        SQLiteDatabase db = getReadableDatabase();
        Cursor cursor = db.query(TABLE_NAME, new String[] {
                FIELD_URL, FIELD_DOWNLOAD_STATE, FIELD_FILEPATH, FIELD_FILENAME, FIELD_TITLE,
                FIELD_THUMBNAIL, FIELD_FINISHED_SIZE, FIELD_TOTAL_SIZE
        }, FIELD_DOWNLOAD_STATE + "='FINISHED'", null, null, null, "_id desc");
        if (cursor != null) {
            while (cursor.moveToNext()) {
                DownloadTask dlTask = new DownloadTask(cursor.getString(0), cursor.getString(2),
                        cursor.getString(3), cursor.getString(4), cursor.getString(5));
                dlTask.setDownloadState(DownloadState.valueOf(cursor.getString(1)));
                dlTask.setFinishedSize(cursor.getInt(6));
                dlTask.setTotalSize(cursor.getInt(7));

                tasks.add(dlTask);
            }
            cursor.close();
        }

        return tasks;
    }

    List<DownloadTask> queryUnDownloaded() {
        List<DownloadTask> tasks = new ArrayList<DownloadTask>();

        SQLiteDatabase db = getReadableDatabase();
        Cursor cursor = db.query(TABLE_NAME, new String[] {
                FIELD_URL, FIELD_DOWNLOAD_STATE, FIELD_FILEPATH, FIELD_FILENAME, FIELD_TITLE,
                FIELD_THUMBNAIL, FIELD_FINISHED_SIZE, FIELD_TOTAL_SIZE
        }, FIELD_DOWNLOAD_STATE + "<> 'FINISHED'", null, null, null, "_id desc");
        if (cursor != null) {
            while (cursor.moveToNext()) {
                DownloadTask dlTask = new DownloadTask(cursor.getString(0), cursor.getString(2),
                        cursor.getString(3), cursor.getString(4), cursor.getString(5));
                dlTask.setDownloadState(DownloadState.valueOf(cursor.getString(1)));
                dlTask.setFinishedSize(cursor.getInt(6));
                dlTask.setTotalSize(cursor.getInt(7));

                tasks.add(dlTask);
            }
            cursor.close();
        }

        return tasks;
    }

    /**
     * 
     * @param downloadTask DownloadTask
     */
    void update(DownloadTask downloadTask) {
        SQLiteDatabase db = getWritableDatabase();

        db.update(TABLE_NAME, getContentValues(downloadTask), FIELD_URL + "=?", new String[] {
            downloadTask.getUrl()
        });
    }

    /**
     * @param downloadTask DownloadTask
     */
    void delete(DownloadTask downloadTask) {
        SQLiteDatabase db = getWritableDatabase();
        db.delete(TABLE_NAME, FIELD_URL + "=?", new String[] {
            downloadTask.getUrl()
        });
    }

    /**
     * 
     * @param downloadTask DownloadTask
     * @return ContentValues
     */
    private ContentValues getContentValues(DownloadTask downloadTask) {
        ContentValues values = new ContentValues();
        values.put(FIELD_URL, downloadTask.getUrl());
        values.put(FIELD_DOWNLOAD_STATE, downloadTask.getDownloadState().toString());
        values.put(FIELD_FILEPATH, downloadTask.getFilePath());
        values.put(FIELD_FILENAME, downloadTask.getFileName());
        values.put(FIELD_TITLE, downloadTask.getTitle());
        values.put(FIELD_THUMBNAIL, downloadTask.getThumbnail());
        values.put(FIELD_FINISHED_SIZE, downloadTask.getFinishedSize());
        values.put(FIELD_TOTAL_SIZE, downloadTask.getTotalSize());
        return values;
    }
}
