package avp.video.music;
/*
 * DjAmol Group Inc www.djamol.com
 * Author  : Amol V. Patil - admin@djamol.com
 */

import android.content.Intent;
import android.os.Bundle;
import android.preference.PreferenceActivity;
import android.view.View;
import android.widget.Button;

public class Setting extends PreferenceActivity {
    @Override
    protected void onCreate(Bundle savedInstanceState) {
    super.onCreate(savedInstanceState);
    setContentView(R.layout.setting);
    addPreferencesFromResource(R.xml.setting);

    Button backButton = (Button) findViewById(R.id.backPrefBurron);
    backButton.setOnClickListener(new View.OnClickListener() {
        public void onClick(View view) {
            //onBackPressed();
            Intent myIntent = new Intent(getBaseContext(),AvpTubeMain.class);
            startActivity(myIntent);
            finish();
        }
    });

     }
  }