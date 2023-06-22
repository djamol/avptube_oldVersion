package djamol.com.lib.mob;
import android.app.Dialog;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.net.Uri;
import android.view.View;
import android.view.View.OnClickListener;
import android.widget.Button;
import android.widget.LinearLayout;
import android.widget.TextView;
import android.widget.Toast;

public class RateApp
{
 // Insert your Application Title
 private final static String TITLE = "AvpTube";

 // Insert your Application Package Name
 private final static String PACKAGE_NAME = "audio.video.play";

 // Day until the Rate Us Dialog Prompt(Default 2 Days)
 private final static int DAYS_UNTIL_PROMPT = 0;

 // Rate Us Dialog Prompt when user launch app second time
 private final static int LAUNCHES_UNTIL_PROMPT = 2;

 public static void app_launched(Context mContext)
 {
  SharedPreferences prefs = mContext.getSharedPreferences("rateapp", 0);
  if (prefs.getBoolean("dontshowagain", false))
  {
   return;
  }

  SharedPreferences.Editor editor = prefs.edit();

  // Increment launch counter
  long launch_count = prefs.getLong("launch_count", 0) + 1;
  editor.putLong("launch_count", launch_count);

  // Get date of first launch
  Long date_firstLaunch = prefs.getLong("date_firstlaunch", 0);
  if (date_firstLaunch == 0)
  {
   date_firstLaunch = System.currentTimeMillis();
   editor.putLong("date_firstlaunch", date_firstLaunch);
  }

  // Wait at least n days before opening
  if (launch_count >= LAUNCHES_UNTIL_PROMPT)
  {
   if (System.currentTimeMillis() >= date_firstLaunch
     + (DAYS_UNTIL_PROMPT * 24 * 60 * 60 * 1000))
   {
    showRateDialog(mContext, editor);
   }
  }

  editor.commit();
 }

 public static void showRateDialog(final Context mContext,final SharedPreferences.Editor editor)
 {
  final Dialog dialog = new Dialog(mContext);
  // Set Dialog Title
  dialog.setTitle("Rate " + TITLE);

  LinearLayout ll = new LinearLayout(mContext);
  ll.setOrientation(LinearLayout.VERTICAL);

  TextView tv = new TextView(mContext);
  tv.setText("If you like " + TITLE + ", please give Rating");
  tv.setWidth(240);
  tv.setPadding(4, 0, 4, 10);
  ll.addView(tv);

  // First Button
  Button btnRate = new Button(mContext);
  btnRate.setText("Rate " + TITLE);
  btnRate.setOnClickListener(new OnClickListener()
  {
   public void onClick(View v)
   {
	   //simple
	   //mContext.startActivity(new Intent(Intent.ACTION_VIEW, Uri.parse("market://details?id=" + PACKAGE_NAME)));
   
	   try {
		   mContext.startActivity(new Intent(Intent.ACTION_VIEW, Uri.parse("market://details?id=" + PACKAGE_NAME)));
	   } catch (android.content.ActivityNotFoundException anfe) {
		//   mContext.startActivity(new Intent(Intent.ACTION_VIEW, Uri.parse("https://play.google.com/store/apps/details?id=" + PACKAGE_NAME)));
		   Toast.makeText(mContext, "Not Install Play Store in your Device", Toast.LENGTH_SHORT).show();
		}
    dialog.dismiss();
   }
  });
  ll.addView(btnRate);

  // Second Button
  Button btnLater = new Button(mContext);
  btnLater.setText("Remind me later");
  btnLater.setOnClickListener(new OnClickListener()
  {
   public void onClick(View v)
   {
    dialog.dismiss();
   }
  });
  ll.addView(btnLater);

  // Third Button Stop Bugging me
  Button btnNoRating = new Button(mContext);
  btnNoRating.setText("No rating");
  btnNoRating.setOnClickListener(new OnClickListener()
  {
   public void onClick(View v)
   {
    if (editor != null)
    {
     editor.putBoolean("dontshowagain", true);
     editor.commit();
    }
    dialog.dismiss();
   }
  });
  ll.addView(btnNoRating);

  dialog.setContentView(ll);

  // Show Dialog
  dialog.show();
 }
}