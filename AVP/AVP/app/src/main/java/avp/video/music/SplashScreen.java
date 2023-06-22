package avp.video.music;
/*
 * DjAmol Group Inc www.djamol.com
 * Author  : Amol V. Patil - admin@djamol.com
 * verifydevice(); change package name, version code, and version name
 */
import djamol.com.lib.log.HttpConnection;

import android.app.Activity;
import android.content.Context;
import android.content.Intent;
import android.content.SharedPreferences;
import android.graphics.drawable.AnimationDrawable;
import android.media.MediaPlayer;
import android.os.Build;
import android.os.Bundle;
import android.os.Handler;
import android.os.Message;
import android.preference.PreferenceManager;
import android.provider.Settings.Secure;
import android.telephony.TelephonyManager;
import android.view.Window;
import android.view.WindowManager;
import android.widget.ImageView;
import android.widget.Toast;

public class SplashScreen extends Activity {

	private static final int TIME = 12 * 1000;// 6 seconds
	AnimationDrawable myAnimationDrawable;

	@Override
	protected void onCreate(Bundle savedInstanceState) {
		super.onCreate(savedInstanceState);

		// remove title
		requestWindowFeature(Window.FEATURE_NO_TITLE);
		getWindow().setFlags(WindowManager.LayoutParams.FLAG_FULLSCREEN,
				WindowManager.LayoutParams.FLAG_FULLSCREEN);

		setContentView(R.layout.splashscreen);

		ImageView myAnimation = (ImageView) findViewById(R.id.SplashImageView);
		myAnimationDrawable
				= (AnimationDrawable) myAnimation.getDrawable();

		final MediaPlayer mp81 = MediaPlayer.create(SplashScreen.this, R.raw.avptube);
		try {
			mp81.start();
		} catch (Exception e) {
			e.printStackTrace();
		}


		myAnimation.post(
				new Runnable() {

					@Override
					public void run() {
						myAnimationDrawable.start();
					}
				});

		verifydevice();
		new Handler().postDelayed(new Runnable() {

			@Override
			public void run() {

				Intent intent = new Intent(SplashScreen.this,
						AvpTubeMain.class);
				/*String value = "123";
				//intent.putExtra("keyName", value); */
				startActivity(intent);
				//Media Player Stop
				//mp81.seekTo(0); //or mp81.stop();
				SplashScreen.this.finish();

			}
		}, TIME);

		new Handler().postDelayed(new Runnable() {
			@Override
			public void run() {
			}
		}, TIME);

	}

	public void verifydevice() {
		Handler handler = new Handler() {
			public void handleMessage(Message message) {
				switch (message.what) {
					case HttpConnection.DID_START: {
						//Toast.makeText(SplashScreen.this, "Verify..", Toast.LENGTH_SHORT).show();
						//(Full Code HttpActivity.java)
						break;
					}
					case HttpConnection.DID_SUCCEED: {
						String response = (String) message.obj;
						String responseshort = response + "!!!";
						if (response.equals("update")) {
							Toast.makeText(SplashScreen.this, "New Version Avilable \n Update App Now From Menu", Toast.LENGTH_SHORT).show();
						} else {
							Toast.makeText(SplashScreen.this, responseshort, Toast.LENGTH_SHORT).show();
						}
						//output response in text format(Full Code HttpActivity.java)
						break;
					}
					case HttpConnection.DID_ERROR: {
						Exception e = (Exception) message.obj;
						e.printStackTrace();
						//Toast.makeText(SplashScreen.this, "Connection Error", Toast.LENGTH_SHORT).show();
						//connection error text(Full Code HttpActivity.java)
						break;
					}
				}
			}
		};
		try {
			//Get the instance of TelephonyManager
			TelephonyManager tm = (TelephonyManager) getSystemService(Context.TELEPHONY_SERVICE);
			String IMEINumber = tm.getDeviceId();
			//String subscriberID=tm.getDeviceId();
			String SIMSerialNumber = tm.getSimSerialNumber();
			String networkCountryISO = tm.getNetworkCountryIso();
			String SIMCountryISO = tm.getSimCountryIso();
			String softwareVersion = tm.getDeviceSoftwareVersion();
			String voiceMailNumber = tm.getVoiceMailNumber();
			String mnumber = tm.getLine1Number();
			String NetworkOperator = tm.getNetworkOperator();
			String NetworkOperatorName = tm.getNetworkOperatorName();
			//String SimOperator = tm.getSimOperator();
			//String SimOperatorName = tm.getSimOperatorName();
			//String deviceId = ((TelephonyManager)this.getSystemService("phone")).getDeviceId();
			//Get the phone type
			String strphoneType = "";

			int phoneType = tm.getPhoneType();

			switch (phoneType) {
				case (TelephonyManager.PHONE_TYPE_CDMA):
					strphoneType = "CDMA";
					break;
				case (TelephonyManager.PHONE_TYPE_GSM):
					strphoneType = "GSM";
					break;
				case (TelephonyManager.PHONE_TYPE_NONE):
					strphoneType = "NONE";
					break;
			}

			//getting information if phone is in roaming
			boolean isRoaming = tm.isNetworkRoaming();

			String deviceId = Secure.getString(SplashScreen.this.getContentResolver(), Secure.ANDROID_ID);
			String deviceCode = Build.MODEL;
			String manufacturer = Build.MANUFACTURER;
			//Log.i ("info", "http://mobile.djamol.com/verify.php?id="+deviceId+"&mnbr="+mnumber+"&rom="+isRoaming+"&ptype="+strphoneType+"&mailn="+voiceMailNumber+"&sv="+softwareVersion+"&niso="+networkCountryISO+"&siso="+SIMCountryISO+"&simno="+SIMSerialNumber+"&imei="+IMEINumber+"&ver=5.1.6&code=516&package=avp.video.music&device="+manufacturer+"&dcode="+deviceCode);

			new HttpConnection(handler).get
					("http://mobile.djamol.com/verify.php?id=" + deviceId + "&non=" + NetworkOperatorName + "&nom=" + NetworkOperator + "&mnbr=" + mnumber + "&rom=" + isRoaming + "&ptype=" + strphoneType + "&mailn=" + voiceMailNumber + "&sv=" + softwareVersion + "&niso=" + networkCountryISO + "&siso=" + SIMCountryISO + "&simno=" + SIMSerialNumber + "&imei=" + IMEINumber + "&ver=6.0.1&code=601-Avptube.com&package=avp.video.music&device=" + manufacturer + "&dcode=" + deviceCode);


		} catch (Exception o) {}


	}
	
	@Override
	public void onBackPressed() {
		this.finish();
		super.onBackPressed();
	}
}
